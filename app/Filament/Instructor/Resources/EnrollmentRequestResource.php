<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\EnrollmentRequestResource\Pages;
use App\Models\EnrollmentRequest;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EnrollmentRequestResource extends Resource
{
    protected static ?string $model = EnrollmentRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Enrollment Requests';

    protected static ?string $modelLabel = 'Enrollment Request';

    protected static ?string $pluralModelLabel = 'Enrollment Requests';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationGroup = 'Student Management';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'instructor';
    }

    // No create/edit - only view and approve/reject
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Request Details')
                    ->description('Student enrollment request details')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')
                            ->label('Student Name')
                            ->disabled()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('user.email')
                            ->label('Student Email')
                            ->disabled()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('course.title')
                            ->label('Course')
                            ->disabled()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('course.type')
                            ->label('Course Type')
                            ->disabled()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('amount_paid')
                            ->label('Amount Paid (BDT)')
                            ->disabled()
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Payment Information')
                    ->description('Payment details provided by student')
                    ->schema([
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->disabled()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('payment_method')
                            ->label('Payment Method')
                            ->disabled()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('payment_number')
                            ->label('Payment Number')
                            ->disabled()
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('note')
                            ->label('Student Note')
                            ->disabled()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Request Status')
                    ->description('Current status of this request')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->disabled()
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->rows(3)
                            ->placeholder('Reason for rejection (if applicable)')
                            ->visible(fn (callable $get) => $get('status') === 'rejected')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                    ->sortable()
                    ->description(fn ($record): string => '৳' . number_format($record->amount_paid ?? 0)),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'pending' => 'heroicon-o-clock',
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                    ]),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable()
                    ->toggleable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Request Date')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->tooltip('When the student requested enrollment'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                Tables\Filters\SelectFilter::make('course')
                    ->label('Course')
                    ->relationship(
                        'course',
                        'title',
                        modifyQueryUsing: fn (Builder $query) => $query->where('instructor_id', Auth::id())
                    ),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record) {
                        // Create enrollment
                        Enrollment::updateOrCreate(
                            [
                                'user_id' => $record->user_id,
                                'course_id' => $record->course_id,
                            ],
                            [
                                'enrolled_at' => now(),
                            ]
                        );

                        // Update request status
                        $record->update(['status' => 'approved']);

                        Notification::make()
                            ->title('Request Approved')
                            ->body('Student has been enrolled in the course.')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Reason for Rejection')
                            ->required()
                            ->rows(3)
                            ->placeholder('Please explain why you are rejecting this request...'),
                    ])
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['rejection_reason'],
                        ]);

                        Notification::make()
                            ->title('Request Rejected')
                            ->body('The enrollment request has been rejected.')
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrollmentRequests::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['user', 'course']);

        // Only show enrollment requests for current instructor's courses
        if (Auth::check() && Auth::user()->role === 'instructor') {
            $query->whereHas('course', function (Builder $query) {
                $query->where('instructor_id', Auth::id());
            });
        }

        return $query;
    }
}
