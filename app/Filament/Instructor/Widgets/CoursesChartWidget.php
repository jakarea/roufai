<?php

namespace App\Filament\Instructor\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class CoursesChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Course Overview';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        $instructorId = Auth::id();

        // Get courses by type and status
        $paidPublished = \App\Models\Course::where('instructor_id', $instructorId)
            ->where('type', 'PAID')
            ->where('is_published', true)
            ->count();

        $paidDrafts = \App\Models\Course::where('instructor_id', $instructorId)
            ->where('type', 'PAID')
            ->where('is_published', false)
            ->count();

        $freePublished = \App\Models\Course::where('instructor_id', $instructorId)
            ->where('type', 'FREE')
            ->where('is_published', true)
            ->count();

        $freeDrafts = \App\Models\Course::where('instructor_id', $instructorId)
            ->where('type', 'FREE')
            ->where('is_published', false)
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Published Courses',
                    'data' => [$paidPublished, $freePublished],
                    'backgroundColor' => [
                        'rgba(16, 185, 129, 0.8)',  // Emerald for paid
                        'rgba(59, 130, 246, 0.8)',  // Blue for free
                    ],
                    'borderColor' => [
                        'rgb(16, 185, 129)',
                        'rgb(59, 130, 246)',
                    ],
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Draft Courses',
                    'data' => [$paidDrafts, $freeDrafts],
                    'backgroundColor' => [
                        'rgba(245, 158, 11, 0.8)',  // Amber for paid drafts
                        'rgba(156, 163, 175, 0.8)', // Gray for free drafts
                    ],
                    'borderColor' => [
                        'rgb(245, 158, 11)',
                        'rgb(156, 163, 175)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Paid Courses', 'Free Courses'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
