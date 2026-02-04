<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '15s';

    protected function getStats(): array
    {
        // Total users
        $totalUsers = \App\Models\User::count();
        $totalStudents = \App\Models\User::where('role', 'student')->count();
        $totalInstructors = \App\Models\User::where('role', 'instructor')->count();
        $totalAdmins = \App\Models\User::where('role', 'admin')->count();

        // Total courses
        $totalCourses = \App\Models\Course::count();
        $publishedCourses = \App\Models\Course::where('is_published', true)->count();
        $paidCourses = \App\Models\Course::where('type', 'PAID')->count();
        $freeCourses = \App\Models\Course::where('type', 'FREE')->count();

        // Total enrollments
        $totalEnrollments = \App\Models\Enrollment::count();

        // Total reviews
        $totalReviews = \App\Models\Review::count();
        $avgRating = \App\Models\Review::avg('rating');

        // Total revenue
        $totalRevenue = \App\Models\EnrollmentRequest::where('status', 'approved')->sum('amount_paid');

        // Pending requests
        $pendingRequests = \App\Models\EnrollmentRequest::where('status', 'pending')->count();

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description("{$totalStudents} Students • {$totalInstructors} Instructors")
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([10, 20, 30, 40, 50, 60, $totalUsers]),

            Stat::make('Total Courses', number_format($totalCourses))
                ->description("{$publishedCourses} Published • {$paidCourses} Paid")
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('info')
                ->chart([5, 10, 15, 20, 25, 30, $totalCourses]),

            Stat::make('Total Enrollments', number_format($totalEnrollments))
                ->description('Across all courses')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary')
                ->chart([20, 40, 60, 80, 100, 120, $totalEnrollments]),

            Stat::make('Total Revenue', '৳' . number_format($totalRevenue))
                ->description('Platform earnings')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('success')
                ->chart([1000, 5000, 10000, 20000, 35000, 50000, $totalRevenue]),

            Stat::make('Pending Requests', number_format($pendingRequests))
                ->description('Awaiting approval')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendingRequests > 0 ? 'warning' : 'success'),

            Stat::make('Average Rating', number_format($avgRating ?? 0, 1) . ' ⭐')
                ->description('From ' . $totalReviews . ' reviews')
                ->descriptionIcon('heroicon-o-star')
                ->color('warning'),
        ];
    }
}
