<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\Review;

class WebsiteController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get published courses
        $courses = Course::where('is_published', true)
            ->with(['category', 'instructor', 'modules.lessons'])
            ->withCount(['enrollments', 'reviews'])
            ->latest()
            ->get();

        // Get categories
        $categories = Category::all();

        // Get featured courses (first 6)
        $featuredCourses = $courses->take(6);

        // Get approved reviews
        $reviews = Review::where('status', 'approved')
            ->with(['user', 'course'])
            ->latest()
            ->take(6)
            ->get();

        return view('website.home', compact(
            'featuredCourses',
            'courses',
            'categories',
            'reviews'
        ));
    }

    /**
     * Display all courses with filters.
     */
    public function courses(Request $request)
    {
        $query = Course::where('is_published', true)
            ->with(['category', 'instructor', 'reviews.user', 'modules.lessons'])
            ->withCount(['enrollments', 'reviews']);

        // Filter by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        // Filter by type (FREE/PAID)
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        // Filter by price (max price)
        if ($request->has('price') && !empty($request->price)) {
            $query->where('price', '<=', $request->price);
        }

        $courses = $query->latest()->paginate(12);
        $categories = Category::all();

        return view('website.courses', compact(
            'courses',
            'categories'
        ));
    }

    /**
     * Display course details.
     */
    public function courseDetails($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('is_published', true)
            ->with([
                'category',
                'instructor',
                'modules.lessons' => function ($query) {
                    $query->orderBy('order_index');
                },
                'reviews.user'
            ])
            ->withCount('enrollments')
            ->firstOrFail();

        // Calculate average rating
        $avgRating = $course->reviews()->where('status', 'approved')->avg('rating') ?? 0;

        // Calculate total duration
        $totalDurationMinutes = 0;
        foreach ($course->modules as $module) {
            foreach ($module->lessons as $lesson) {
                $totalDurationMinutes += $lesson->duration_in_minutes ?? 0;
            }
        }

        $hours = floor($totalDurationMinutes / 60);
        $minutes = $totalDurationMinutes % 60;

        // Check if user is enrolled
        $isEnrolled = false;
        if (Auth::check()) {
            $isEnrolled = Enrollment::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->exists();
        }

        return view('website.course-details', compact(
            'course',
            'isEnrolled'
        ));
    }

    /**
     * Enroll in a course.
     */
    public function enroll(Request $request, $id)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to enroll in this course.',
                'requires_auth' => true
            ], 401);
        }

        $user = Auth::user();

        // Check if course exists
        $course = Course::where('is_published', true)->findOrFail($id);

        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'success' => false,
                'message' => 'You are already enrolled in this course.'
            ], 400);
        }

        // For paid courses, you would typically redirect to payment
        // For now, we'll create enrollment directly
        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Successfully enrolled in the course!',
            'redirect' => route('student.course', $course->id)
        ]);
    }

    /**
     * Display the expert connection page.
     */
    public function expertConnection()
    {
        return view('website.expert-connection');
    }

    /**
     * Display the blog index page.
     */
    public function blogIndex()
    {
        return view('website.blog-index');
    }

    /**
     * Display a single blog post.
     */
    public function blogShow($slug)
    {
        return view('website.blog-show', ['slug' => $slug]);
    }
}
