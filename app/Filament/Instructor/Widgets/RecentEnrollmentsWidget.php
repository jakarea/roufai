<?php

namespace App\Filament\Instructor\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentEnrollmentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Enrollments';

    protected static ?int $sort = 5;

    protected static ?string $pollingInterval = '15s';

    public function table(Table $table): Table
    {
        $instructorId = Auth::id();

        return $table
            ->query(
                \App\Models\Enrollment::whereHas('course', function ($query) use ($instructorId) {
                    $query->where('instructor_id', $instructorId);
                })
                ->with(['user', 'course'])
                ->latest('enrolled_at')
                ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => $record->user->email ?? 'N/A'),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('course.type')
                    ->label('Type')
                    ->colors([
                        'success' => 'FREE',
                        'warning' => 'PAID',
                    ]),
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label('Enrolled')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->description(fn ($record): string => $record->enrolled_at?->diffForHumans() ?? 'N/A'),
            ])
            ->defaultSort('enrolled_at', 'desc')
            ->paginated(false);
    }
}
