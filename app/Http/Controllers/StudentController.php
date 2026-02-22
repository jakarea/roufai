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
            ->with(['course.category', 'course.instructor', 'course.modules.lessons'])
            ->whereHas('course', function ($query) {
                $query->where('is_published', true);
            })
            ->get();

        // Get completed lessons for this student
        $completedLessons = LessonCompletion::where('user_id', $student->id)
            ->pluck('lesson_id')
            ->toArray();

        // Get certificates count
        $certificatesCount = \App\Models\Certificate::where('user_id', $student->id)->count();

        // Get active or upcoming live class (real-time status calculation)
        $enrolledCourseIds = $enrollments->pluck('course.id')->unique()->filter()->values();

        $liveClass = null;
        $now = now();
        $currentDate = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        // Get all relevant live classes (public or enrolled courses)
        // Exclude expired classes
        $allLiveClasses = \App\Models\LiveClass::with(['course', 'instructor'])
            ->where(function ($query) use ($enrolledCourseIds) {
                // Either course is NULL (public to all students)
                // OR course_id is in the student's enrolled courses
                $query->whereNull('course_id')
                    ->orWhereIn('course_id', $enrolledCourseIds);
            })
            ->where('start_date', '>=', $now->subDays(7)->format('Y-m-d')) // Get classes from last 7 days onwards
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        // Find currently live class (within duration)
        $currentlyLive = null;
        $upcomingClass = null;

        foreach ($allLiveClasses as $class) {
            // Combine date and time properly
            $startDateStr = $class->start_date->format('Y-m-d');
            $startTimeStr = $class->start_time; // Should be "HH:MM:SS"

            $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startDateStr . ' ' . $startTimeStr);
            $endDateTime = $startDateTime->copy()->addMinutes($class->duration_minutes);

            \Log::info('Checking class', [
                'class_id' => $class->id,
                'topic' => $class->topic,
                'start_date' => $startDateStr,
                'start_time' => $startTimeStr,
                'duration' => $class->duration_minutes,
                'startDateTime' => $startDateTime->toDateTimeString(),
                'endDateTime' => $endDateTime->toDateTimeString(),
                'now' => $now->toDateTimeString(),
                'is_between' => $now->between($startDateTime, $endDateTime),
            ]);

            // Check if class is currently live (within start and end time)
            if ($now->between($startDateTime, $endDateTime)) {
                $currentlyLive = $class;
                \Log::info('Found currently live class', ['class_id' => $class->id, 'topic' => $class->topic]);
                break;
            }

            // Get first upcoming class if not already found
            if (!$upcomingClass && $startDateTime->isFuture()) {
                $upcomingClass = $class;
            }
        }

        // Show currently live class if available, otherwise show upcoming
        $liveClass = $currentlyLive ?? $upcomingClass;

        \Log::info('Final selection', [
            'has_currently_live' => $currentlyLive !== null,
            'has_upcoming' => $upcomingClass !== null,
            'selected_id' => $liveClass ? $liveClass->id : null,
        ]);

        return inertia('Student/Dashboard', [
            'enrollments' => $enrollments->map(function ($enrollment) use ($completedLessons) {
                // Calculate total lessons and completed lessons
                $totalLessons = 0;
                $completedCount = 0;

                foreach ($enrollment->course->modules as $module) {
                    $totalLessons += $module->lessons->count();
                    foreach ($module->lessons as $lesson) {
                        if (in_array($lesson->id, $completedLessons)) {
                            $completedCount++;
                        }
                    }
                }

                $isCompleted = $totalLessons > 0 && $completedCount === $totalLessons;

                return [
                    'id' => $enrollment->id,
                    'enrolled_at' => $enrollment->enrolled_at,
                    'course' => [
                        'id' => $enrollment->course->id,
                        'title' => $enrollment->course->title,
                        'description' => $enrollment->course->description,
                        'thumbnail_url' => $enrollment->course->thumbnail_url,
                        'thumbnail_path' => $enrollment->course->thumbnail_path,
                        'type' => $enrollment->course->type,
                        'price' => $enrollment->course->price,
                        'is_completed' => $isCompleted,
                        'progress' => $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0,
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
            'totalLearningTime' => $student->total_learning_time,
            'certificatesCount' => $certificatesCount,
            'liveClass' => $liveClass ? [
                'id' => $liveClass->id,
                'topic' => $liveClass->topic,
                'description' => $liveClass->description,
                'meeting_link' => $liveClass->meeting_link,
                'start_date' => $liveClass->start_date?->format('d-m-Y'),
                'start_time' => substr($liveClass->start_time, 0, 5), // Convert "HH:MM:SS" to "HH:MM"
                'duration_minutes' => $liveClass->duration_minutes,
                'status' => $currentlyLive ? 'live' : 'scheduled', // Real-time status
                'thumbnail_url' => $liveClass->thumbnail_url,
                'instructor' => [
                    'name' => $liveClass->instructor->name,
                ],
            ] : null,
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
            ->withCount('enrollments')
            ->findOrFail($id);

        // Calculate average rating only from approved reviews
        $avgRating = \App\Models\Review::where('course_id', $course->id)
            ->where('status', 'approved')
            ->avg('rating');

        $approvedReviewsCount = \App\Models\Review::where('course_id', $course->id)
            ->where('status', 'approved')
            ->count();

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
                                'duration' => $lesson->duration_in_minutes,
                                'order' => $lesson->order,
                                'video_provider' => $lesson->video_provider,
                                'video_id' => $lesson->video_id,
                                'attachment_url' => $lesson->attachment_url,
                            ];
                        }),
                    ];
                })->sortBy('order')->values(),
                'reviews' => $course->reviews
                    ->filter(function ($review) use ($student) {
                        // Show approved reviews, or pending reviews only from current student
                        return $review->status === 'approved' ||
                            ($review->status === 'pending' && $review->user_id === $student->id);
                    })
                    ->map(function ($review) {
                        return [
                            'id' => $review->id,
                            'rating' => $review->rating,
                            'comment' => $review->comment,
                            'created_at' => $review->created_at,
                            'status' => $review->status,
                            'user' => [
                                'name' => $review->user->name,
                            ],
                        ];
                    })
                    ->values(),
                'reviews_avg_rating' => $avgRating,
                'enrollments_count' => $course->enrollments_count,
            ],
            'completedLessons' => $completedLessons,
            'userReview' => $userReview ? [
                'id' => $userReview->id,
                'rating' => $userReview->rating,
                'comment' => $userReview->comment,
                'status' => $userReview->status,
            ] : null,
        ]);
    }

    /**
     * Show completed courses with certificates.
     */
    public function completedCourses()
    {
        $student = Auth::user();

        // Get all enrolled courses with their relationships
        $enrollments = Enrollment::where('user_id', $student->id)
            ->with(['course.category', 'course.instructor', 'course.modules.lessons'])
            ->whereHas('course', function ($query) {
                $query->where('is_published', true);
            })
            ->get();

        // Get completed lessons for this student
        $completedLessons = LessonCompletion::where('user_id', $student->id)
            ->pluck('lesson_id')
            ->toArray();

        // Filter only completed courses
        $completedCourses = [];
        foreach ($enrollments as $enrollment) {
            $totalLessons = 0;
            $completedCount = 0;

            foreach ($enrollment->course->modules as $module) {
                $totalLessons += $module->lessons->count();
                foreach ($module->lessons as $lesson) {
                    if (in_array($lesson->id, $completedLessons)) {
                        $completedCount++;
                    }
                }
            }

            if ($totalLessons > 0 && $completedCount === $totalLessons) {
                $completedCourses[] = [
                    'id' => $enrollment->course->id,
                    'title' => $enrollment->course->title,
                    'description' => $enrollment->course->description,
                    'thumbnail_url' => $enrollment->course->thumbnail_url,
                    'thumbnail_path' => $enrollment->course->thumbnail_path,
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
                    'completed_at' => LessonCompletion::where('user_id', $student->id)
                        ->where('course_id', $enrollment->course->id)
                        ->latest('completed_at')
                        ->first()
                        ?->completed_at,
                ];
            }
        }

        return inertia('Student/CompletedCourses', [
            'completedCourses' => $completedCourses,
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

            // Get the lesson to add its duration to learning time
            $lesson = \App\Models\Lesson::findOrFail($request->lesson_id);

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

            // Only add learning time if this is a new completion (not already completed before)
            if ($completion->wasRecentlyCreated) {
                $student->total_learning_time += $lesson->duration_in_minutes;
                $student->save();
            }

            \Log::info('Lesson marked as complete', [
                'completion_id' => $completion->id,
                'user_id' => $student->id,
                'lesson_id' => $request->lesson_id,
                'course_id' => $request->course_id,
                'duration_added' => $lesson->duration_in_minutes,
                'total_learning_time' => $student->total_learning_time,
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
     * Show all live classes for the student.
     */
    public function liveClasses()
    {
        $student = Auth::user();

        // Get all enrolled courses
        $enrollments = Enrollment::where('user_id', $student->id)
            ->with(['course'])
            ->whereHas('course', function ($query) {
                $query->where('is_published', true);
            })
            ->get();

        $enrolledCourseIds = $enrollments->pluck('course.id')->unique()->filter()->values();

        // Get all relevant live classes (public or enrolled courses)
        $allLiveClasses = \App\Models\LiveClass::with(['course', 'instructor'])
            ->where(function ($query) use ($enrolledCourseIds) {
                // Either course is NULL (public to all students)
                // OR course_id is in the student's enrolled courses
                $query->whereNull('course_id')
                    ->orWhereIn('course_id', $enrolledCourseIds);
            })
            ->orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        // Calculate real-time status for each class
        $now = now();
        $liveClassesData = [];

        foreach ($allLiveClasses as $class) {
            // Combine date and time properly - start_time is now a string
            $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $class->start_date->format('Y-m-d') . ' ' . $class->start_time);
            $endDateTime = $startDateTime->copy()->addMinutes($class->duration_minutes);
            $isCompleted = $endDateTime->isPast();
            $isCurrentlyLive = $now->between($startDateTime, $endDateTime);
            $isUpcoming = $startDateTime->isFuture();

            $status = $isCompleted ? 'completed' : ($isCurrentlyLive ? 'live' : 'scheduled');

            $liveClassesData[] = [
                'id' => $class->id,
                'topic' => $class->topic,
                'description' => $class->description,
                'meeting_link' => $class->meeting_link,
                'start_date' => $class->start_date?->format('d-m-Y'),
                'start_time' => substr($class->start_time, 0, 5), // Convert "HH:MM:SS" to "HH:MM"
                'duration_minutes' => $class->duration_minutes,
                'status' => $status,
                'thumbnail_url' => $class->thumbnail_url,
                'instructor' => [
                    'name' => $class->instructor->name,
                ],
                'course' => $class->course ? [
                    'id' => $class->course->id,
                    'title' => $class->course->title,
                ] : null,
            ];
        }

        return inertia('Student/LiveClasses', [
            'liveClasses' => $liveClassesData,
        ]);
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
