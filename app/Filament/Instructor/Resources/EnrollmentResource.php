<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\EnrollmentResource\Pages;
use App\Models\Enrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class EnrollmentResource extends Resource
{
    protected static ?string $model = Enrollment::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Enrolled Students';

    protected static ?string $modelLabel = 'Enrolled Student';

    protected static ?string $pluralModelLabel = 'Enrolled Students';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Student Management';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'instructor';
    }

    // Allow instructors to manually enroll students
    public static function canCreate(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Enrollment Information')
                    ->description('Select student and course')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Student')
                            ->helperText('Select the student to enroll')
                            ->options(function () {
                                return \App\Models\User::where('role', 'student')
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->helperText('Select one of your courses')
                            ->options(function () {
                                return \App\Models\Course::where('instructor_id', Auth::id())
                                    ->orderBy('title')
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->columnSpan(2),
                        Forms\Components\DateTimePicker::make('enrolled_at')
                            ->label('Enrollment Date')
                            ->helperText('When was the student enrolled?')
                            ->default(now())
                            ->required()
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Payment Information')
                    ->description('Record payment details for this paid course')
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'bkash' => 'Bkash',
                                'nagad' => 'Nagad',
                                'cash' => 'Cash',
                                'bank' => 'Bank Transfer',
                                'other' => 'Other',
                            ])
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->placeholder('e.g., TXN123456')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('payment_number')
                            ->label('Student Payment Number')
                            ->tel()
                            ->placeholder('e.g., 01712345678')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('amount')
                            ->label('Amount Paid (BDT)')
                            ->numeric()
                            ->prefix('৳')
                            ->placeholder('e.g., 1000')
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->rows(2)
                            ->placeholder('Any additional notes about this enrollment...')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn (callable $get) => $get('course_id') ? \App\Models\Course::find($get('course_id'))?->type === 'PAID' : false),
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
                    ->description(fn ($record): string => $record->course->type ?? 'N/A'),
                Tables\Columns\BadgeColumn::make('course.type')
                    ->label('Type')
                    ->colors([
                        'success' => 'FREE',
                        'warning' => 'PAID',
                    ]),
                Tables\Columns\TextColumn::make('enrolled_at')
                    ->label('Enrolled Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->description(fn ($record): string => $record->enrolled_at?->diffForHumans() ?? 'N/A'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course')
                    ->label('Course')
                    ->relationship(
                        'course',
                        'title',
                        modifyQueryUsing: fn (Builder $query) => $query->where('instructor_id', Auth::id())
                    ),
                Tables\Filters\SelectFilter::make('course_type')
                    ->label('Course Type')
                    ->options([
                        'FREE' => 'FREE',
                        'PAID' => 'PAID',
                    ]),
                Tables\Filters\Filter::make('recent')
                    ->label('Enrolled in last 30 days')
                    ->query(fn (Builder $query): Builder => $query->where('enrolled_at', '>=', now()->subDays(30)))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('enrolled_at', 'desc');
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
            'index' => Pages\ListEnrollments::route('/'),
            'create' => Pages\CreateEnrollment::route('/create'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['user', 'course']);

        // Only show enrollments for current instructor's courses
        if (Auth::check() && Auth::user()->role === 'instructor') {
            $query->whereHas('course', function (Builder $query) {
                $query->where('instructor_id', Auth::id());
            });
        }

        return $query;
    }
}
