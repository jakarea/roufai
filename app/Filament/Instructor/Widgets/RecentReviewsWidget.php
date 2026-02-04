<?php

namespace App\Filament\Instructor\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class RecentReviewsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Reviews';

    protected static ?int $sort = 7;

    protected static ?string $pollingInterval = '15s';

    public function table(Table $table): Table
    {
        $instructorId = Auth::id();

        return $table
            ->query(
                \App\Models\Review::whereHas('course', function ($query) use ($instructorId) {
                    $query->where('instructor_id', $instructorId);
                })
                ->with(['user', 'course'])
                ->latest('created_at')
                ->limit(5)
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
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state): string => '⭐ ' . $state . '/5')
                    ->sortable()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->description(fn ($record): string => $record->created_at?->diffForHumans() ?? 'N/A'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }
}
