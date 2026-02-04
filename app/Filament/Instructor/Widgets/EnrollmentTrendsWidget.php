<?php

namespace App\Filament\Instructor\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class EnrollmentTrendsWidget extends ChartWidget
{
    protected static ?string $heading = 'Enrollment Trend (Last 6 Months)';

    protected static ?int $sort = 4;

    protected static ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        $instructorId = Auth::id();

        // Get enrollments for the last 6 months
        $enrollmentData = \App\Models\Enrollment::select(
            \DB::raw('DATE_FORMAT(enrolled_at, "%Y-%m") as month'),
            \DB::raw('COUNT(*) as total')
        )
            ->whereHas('course', function ($query) use ($instructorId) {
                $query->where('instructor_id', $instructorId);
            })
            ->where('enrolled_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare labels and data
        $months = [];
        $enrollments = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months[] = now()->subMonths($i)->format('M Y');

            $enrollment = $enrollmentData->firstWhere('month', $month);
            $enrollments[] = $enrollment ? (int) $enrollment->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Students Enrolled',
                    'data' => $enrollments,
                    'backgroundColor' => 'rgba(232, 80, 255, 0.2)',
                    'borderColor' => 'rgb(232, 80, 255)',
                    'borderWidth' => 3,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
