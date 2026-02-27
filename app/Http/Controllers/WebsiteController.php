<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\Review;
use App\Models\BootcampConfig;
use App\Models\EnrollmentRequest;
use App\Models\SiteSetting;

class WebsiteController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get site settings
        $siteSettings = SiteSetting::getSettings();

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

        // Get active bootcamp configuration
        $bootcampConfig = BootcampConfig::where('is_active', true)
            ->with(['course.instructor', 'instructor'])
            ->latest()
            ->first();

        // Get top 3 enrolled courses for footer
        $topCourses = Course::where('is_published', true)
            ->withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->take(3)
            ->get();

        return view('website.home', compact(
            'featuredCourses',
            'courses',
            'categories',
            'reviews',
            'bootcampConfig',
            'siteSettings',
            'topCourses'
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
            'isEnrolled',
            'avgRating',
            'hours',
            'minutes'
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
     * Submit bootcamp enrollment request.
     */
    public function submitBootcampEnrollment(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'payment_method' => 'required|in:nagad,bkash,rocket',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'payment_number' => 'required|string|max:20',
            'transaction_id' => 'required|string|max:255',
            'paid_amount' => 'required|numeric|min:0',
            'course_id' => 'nullable|exists:courses,id',
        ]);

        // Get the active bootcamp config
        $bootcampConfig = BootcampConfig::where('is_active', true)->latest()->first();

        if (!$bootcampConfig) {
            return response()->json([
                'success' => false,
                'message' => 'No active bootcamp found.',
            ], 404);
        }

        // Determine course_id
        $courseId = $validated['course_id'] ?? $bootcampConfig->course_id;

        // Create enrollment request
        $enrollmentRequest = EnrollmentRequest::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['payment_number'], // Store payment_number in phone field
            'course_id' => $courseId,
            'transaction_id' => $validated['transaction_id'],
            'payment_method' => $validated['payment_method'],
            'payment_number' => $validated['payment_number'],
            'amount_paid' => $validated['paid_amount'],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'আপনার এনরোলমেন্ট রিকোয়েস্ট সফলভাবে জমা হয়েছে! আমরা শীঘ্রই আপনার পেমেন্ট যাচাই করে আপনার সাথে যোগাযোগ করবো।',
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
