<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class UserDistributionWidget extends ChartWidget
{
    protected static ?string $heading = 'User Distribution by Role';

    protected static ?int $sort = 2;

    protected static ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        $students = \App\Models\User::where('role', 'student')->count();
        $instructors = \App\Models\User::where('role', 'instructor')->count();
        $admins = \App\Models\User::where('role', 'admin')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Users',
                    'data' => [$students, $instructors, $admins],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)',  // Blue for students
                        'rgba(245, 158, 11, 0.8)',  // Amber for instructors
                        'rgba(16, 185, 129, 0.8)',  // Emerald for admins
                    ],
                    'borderColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(245, 158, 11)',
                        'rgb(16, 185, 129)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Students', 'Instructors', 'Admins'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
