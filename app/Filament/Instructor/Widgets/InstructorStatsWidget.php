<?php

namespace App\Filament\Instructor\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class InstructorStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        $instructorId = Auth::id();

        // Total students enrolled across all courses
        $totalStudents = \App\Models\Enrollment::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })->count();

        // Total pending enrollment requests
        $pendingRequests = \App\Models\EnrollmentRequest::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })->where('status', 'pending')->count();

        // Total courses
        $totalCourses = \App\Models\Course::where('instructor_id', $instructorId)->count();
        $publishedCourses = \App\Models\Course::where('instructor_id', $instructorId)
            ->where('is_published', true)->count();

        // Total paid courses
        $paidCourses = \App\Models\Course::where('instructor_id', $instructorId)
            ->where('type', 'PAID')->count();

        // Total free courses
        $freeCourses = \App\Models\Course::where('instructor_id', $instructorId)
            ->where('type', 'FREE')->count();

        // Total revenue from all paid enrollments
        $totalRevenue = \App\Models\EnrollmentRequest::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })->where('status', 'approved')->sum('amount_paid');

        // Average rating
        $avgRating = \App\Models\Review::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })->avg('rating');

        return [
            Stat::make('Total Students', number_format($totalStudents))
                ->description('All enrolled students')
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([7, 12, 10, 14, 18, 15, $totalStudents]),

            Stat::make('Pending Requests', number_format($pendingRequests))
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendingRequests > 0 ? 'warning' : 'success'),

            Stat::make('Total Courses', number_format($totalCourses))
                ->description($paidCourses . ' Paid • ' . $freeCourses . ' Free')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('info'),

            Stat::make('Published Courses', number_format($publishedCourses))
                ->description(($totalCourses - $publishedCourses) . ' drafts')
                ->descriptionIcon('heroicon-o-eye')
                ->color('primary'),

            Stat::make('Total Revenue', '৳' . number_format($totalRevenue))
                ->description('From paid enrollments')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success')
                ->chart([1000, 2500, 4200, 6800, 9500, 12000, $totalRevenue]),

            Stat::make('Average Rating', number_format($avgRating ?? 0, 1) . ' ⭐')
                ->description('Course reviews')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),
        ];
    }
}
