<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopCoursesWidget extends BaseWidget
{
    protected static ?string $heading = 'Top Enrolled Courses';

    protected static ?int $sort = 4;

    protected static ?string $pollingInterval = '15s';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                \App\Models\Course::withCount('enrollments')
                    ->withAvg('reviews', 'rating')
                    ->orderBy('enrollments_count', 'desc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->wrap(),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Students')
                    ->sortable()
                    ->badge()
                    ->color('success')
                    ->formatStateUsing(fn ($state): string => (string) ($state ?? 0)),
                Tables\Columns\TextColumn::make('reviews_avg_rating')
                    ->label('Rating')
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn ($state): string => $state && floatval($state) > 0
                        ? number_format(floatval($state), 1) . ' ★'
                        : 'N/A')
                    ->default('N/A'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('bdt')
                    ->formatStateUsing(fn ($state): string => $state && floatval($state) > 0
                        ? '৳' . number_format(floatval($state))
                        : 'Free')
                    ->badge()
                    ->color(fn ($state): string => $state && floatval($state) > 0 ? 'success' : 'primary'),
            ])
            ->defaultSort('enrollments_count', 'desc')
            ->paginated(false);
    }
}
