<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\LessonCompletion;
use App\Models\Review;

class StudentController extends Controller
{
    /**
     * Show the student dashboard with enrolled courses.
     */
    public function dashboard()
    {
        $student = Auth::user();

        // Get all enrolled courses with their relationships
        $enrollments = Enrollment::where('user_id', $student->id)
            ->with(['course.category', 'course.instructor'])
            ->whereHas('course', function ($query) {
                $query->where('is_published', true);
            })
            ->get();

        return inertia('Student/Dashboard', [
            'enrollments' => $enrollments->map(function ($enrollment) {
                return [
                    'id' => $enrollment->id,
                    'enrolled_at' => $enrollment->enrolled_at,
                    'course' => [
                        'id' => $enrollment->course->id,
                        'title' => $enrollment->course->title,
                        'description' => $enrollment->course->description,
                        'thumbnail_url' => $enrollment->course->thumbnail_url,
                        'type' => $enrollment->course->type,
                        'price' => $enrollment->course->price,
                        'category' => [
                            'id' => $enrollment->course->category->id ?? null,
                            'name' => $enrollment->course->category->name ?? 'N/A',
                        ],
                        'instructor' => [
                            'id' => $enrollment->course->instructor->id ?? null,
                            'name' => $enrollment->course->instructor->name ?? 'N/A',
                        ],
                    ],
                ];
            }),
        ]);
    }

    /**
     * Show course details with modules and lessons.
     */
    public function course($id)
    {
        $student = Auth::user();

        // Check if student is enrolled
        $enrollment = Enrollment::where('user_id', $student->id)
            ->where('course_id', $id)
            ->firstOrFail();

        $course = \App\Models\Course::with([
            'category',
            'instructor',
            'modules.lessons' => function ($query) {
                $query->orderBy('order_index');
            },
            'reviews.user'
        ])
        ->withAvg('reviews', 'rating')
        ->withCount('enrollments')
        ->findOrFail($id);

        // Get completed lessons for this student
        $completedLessons = LessonCompletion::where('user_id', $student->id)
            ->where('course_id', $id)
            ->pluck('lesson_id')
            ->toArray();

        // Check if student has already reviewed this course
        $userReview = Review::where('user_id', $student->id)
            ->where('course_id', $id)
            ->first();

        return inertia('Student/Course', [
            'course' => [
                'id' => $course->id,
                'title' => $course->title,
                'description' => $course->description,
                'thumbnail_url' => $course->thumbnail_url,
                'type' => $course->type,
                'price' => $course->price,
                'category' => [
                    'id' => $course->category->id ?? null,
                    'name' => $course->category->name ?? 'N/A',
                ],
                'instructor' => [
                    'id' => $course->instructor->id ?? null,
                    'name' => $course->instructor->name ?? 'N/A',
                    'bio' => $course->instructor->bio ?? '',
                ],
                'modules' => $course->modules->map(function ($module) {
                    return [
                        'id' => $module->id,
                        'title' => $module->title,
                        'description' => $module->description,
                        'order' => $module->order,
                        'lessons' => $module->lessons->map(function ($lesson) {
                            return [
                                'id' => $lesson->id,
                                'title' => $lesson->title,
                                'description' => $lesson->description,
                                'video_url' => $lesson->video_url,
                                'duration' => $lesson->duration,
                                'order' => $lesson->order,
                            ];
                        }),
                    ];
                })->sortBy('order')->values(),
                'reviews' => $course->reviews->map(function ($review) {
                    return [
                        'id' => $review->id,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at,
                        'user' => [
                            'name' => $review->user->name,
                        ],
                    ];
                }),
                'reviews_avg_rating' => $course->reviews_avg_rating,
                'enrollments_count' => $course->enrollments_count,
            ],
            'completedLessons' => $completedLessons,
            'userReview' => $userReview ? [
                'id' => $userReview->id,
                'rating' => $userReview->rating,
                'comment' => $userReview->comment,
            ] : null,
        ]);
    }

    /**
     * Mark lesson as complete.
     */
    public function markLessonComplete(Request $request)
    {
        try {
            $request->validate([
                'lesson_id' => 'required|exists:lessons,id',
                'course_id' => 'required|exists:courses,id',
            ]);

            $student = Auth::user();

            // Verify enrollment
            $enrollment = Enrollment::where('user_id', $student->id)
                ->where('course_id', $request->course_id)
                ->firstOrFail();

            // Create or update lesson completion
            $completion = LessonCompletion::updateOrCreate(
                [
                    'user_id' => $student->id,
                    'lesson_id' => $request->lesson_id,
                    'course_id' => $request->course_id,
                ],
                [
                    'completed_at' => now(),
                ]
            );

            \Log::info('Lesson marked as complete', [
                'completion_id' => $completion->id,
                'user_id' => $student->id,
                'lesson_id' => $request->lesson_id,
                'course_id' => $request->course_id,
            ]);

            return redirect()->back()->with('success', 'Lesson marked as complete!');
        } catch (\Exception $e) {
            \Log::error('Failed to mark lesson as complete', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Failed to mark lesson as complete: ' . $e->getMessage());
        }
    }

    /**
     * Submit a course review.
     */
    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $student = Auth::user();

        // Verify enrollment
        $enrollment = Enrollment::where('user_id', $student->id)
            ->where('course_id', $id)
            ->firstOrFail();

        // Check if review already exists
        $existingReview = Review::where('user_id', $student->id)
            ->where('course_id', $id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this course.');
        }

        // Create review
        Review::create([
            'user_id' => $student->id,
            'course_id' => $id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }

    /**
     * Show student profile.
     */
    public function profile()
    {
        return inertia('Student/Profile');
    }

    /**
     * Update student profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $student = Auth::user();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->address = $request->address;

        if ($request->filled('password')) {
            $student->password = bcrypt($request->password);
        }

        $student->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
