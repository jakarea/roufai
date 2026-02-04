<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class PlatformRevenueWidget extends ChartWidget
{
    protected static ?string $heading = 'Platform Revenue Trend (Last 6 Months)';

    protected static ?int $sort = 3;

    protected static ?string $pollingInterval = '15s';

    protected function getData(): array
    {
        // Get revenue for the last 6 months
        $revenueData = \App\Models\EnrollmentRequest::select(
            \DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            \DB::raw('SUM(amount_paid) as total')
        )
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Prepare labels and data
        $months = [];
        $revenues = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months[] = now()->subMonths($i)->format('M Y');

            $revenue = $revenueData->firstWhere('month', $month);
            $revenues[] = $revenue ? (int) $revenue->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Revenue (BDT)',
                    'data' => $revenues,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                    'borderColor' => 'rgb(16, 185, 129)',
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
