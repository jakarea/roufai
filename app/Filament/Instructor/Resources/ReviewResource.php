<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationLabel = 'Reviews';

    protected static ?string $modelLabel = 'Review';

    protected static ?string $pluralModelLabel = 'Reviews';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Student Management';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'instructor';
    }

    // No create/edit - students create reviews
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Review Details')
                    ->description('Student review for your course')
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
                        Forms\Components\TextInput::make('rating')
                            ->label('Rating')
                            ->disabled()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('created_at')
                            ->label('Review Date')
                            ->disabled()
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('comment')
                            ->label('Comment')
                            ->rows(6)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state): string => '⭐ ' . $state . '/5')
                    ->sortable()
                    ->description(fn ($record): string => self::getRatingText($record->rating)),
                Tables\Columns\TextColumn::make('comment')
                    ->label('Comment')
                    ->limit(100)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->description(fn ($record): string => $record->created_at?->diffForHumans() ?? 'N/A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course')
                    ->label('Course')
                    ->relationship(
                        'course',
                        'title',
                        modifyQueryUsing: fn (Builder $query) => $query->where('instructor_id', Auth::id())
                    ),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Rating')
                    ->options([
                        '5' => '⭐⭐⭐⭐⭐ (5 stars)',
                        '4' => '⭐⭐⭐⭐ (4 stars)',
                        '3' => '⭐⭐⭐ (3 stars)',
                        '2' => '⭐⭐ (2 stars)',
                        '1' => '⭐ (1 star)',
                    ]),
                Tables\Filters\Filter::make('recent')
                    ->label('Reviews in last 30 days')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(30)))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->modalHeading('Delete Review')
                    ->modalDescription('Are you sure you want to delete this review? This action cannot be undone.'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListReviews::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['user', 'course']);

        // Only show reviews for current instructor's courses
        if (Auth::check() && Auth::user()->role === 'instructor') {
            $query->whereHas('course', function (Builder $query) {
                $query->where('instructor_id', Auth::id());
            });
        }

        return $query;
    }

    protected static function getRatingText($rating): string
    {
        return match($rating) {
            5 => 'Excellent',
            4 => 'Good',
            3 => 'Average',
            2 => 'Poor',
            1 => 'Terrible',
            default => 'N/A',
        };
    }
}
