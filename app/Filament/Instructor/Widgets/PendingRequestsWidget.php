<?php

namespace App\Filament\Instructor\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class PendingRequestsWidget extends BaseWidget
{
    protected static ?string $heading = 'Pending Enrollment Requests';

    protected static ?int $sort = 6;

    protected static ?string $pollingInterval = '15s';

    public function table(Table $table): Table
    {
        $instructorId = Auth::id();

        return $table
            ->query(
                \App\Models\EnrollmentRequest::whereHas('course', function ($query) use ($instructorId) {
                    $query->where('instructor_id', $instructorId);
                })
                ->where('status', 'pending')
                ->with(['user', 'course'])
                ->latest('created_at')
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
                Tables\Columns\TextColumn::make('amount_paid')
                    ->label('Amount')
                    ->money('bdt')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment')
                    ->badge()
                    ->colors([
                        'success' => 'bkash',
                        'info' => 'nagad',
                        'gray' => 'cash',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Request Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->description(fn ($record): string => $record->created_at?->diffForHumans() ?? 'N/A'),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated(false);
    }

    public function isTableQueryable(): bool
    {
        $instructorId = Auth::id();
        return \App\Models\EnrollmentRequest::whereHas('course', function ($query) use ($instructorId) {
            $query->where('instructor_id', $instructorId);
        })->where('status', 'pending')->exists();
    }
}
