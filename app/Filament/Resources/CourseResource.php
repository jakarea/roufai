<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Courses';

    protected static ?string $modelLabel = 'Course';

    protected static ?string $pluralModelLabel = 'Courses';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Course Management';

    // Read-only for admins - no create/edit pages
    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Course Information')
                    ->schema([
                        Forms\Components\Select::make('instructor_id')
                            ->relationship('instructor', 'name')
                            ->disabled()
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->disabled()
                            ->required(),
                        Forms\Components\TextInput::make('title')
                            ->disabled()
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->disabled()
                            ->required()
                            ->columnSpanFull()
                            ->rows(4),
                        Forms\Components\TextInput::make('price')
                            ->disabled()
                            ->numeric()
                            ->prefix('৳'),
                        Forms\Components\TextInput::make('thumbnail_url')
                            ->disabled()
                            ->maxLength(255)
                            ->url(),
                        Forms\Components\Toggle::make('is_published')
                            ->disabled()
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder-course.png'))
                    ->size(60),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Title')
                    ->weight('bold')
                    ->description(fn (Course $record): string => $record->category->name)
                    ->wrap(),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('BDT')
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => $state ? '৳' . number_format($state) : 'Free')
                    ->badge()
                    ->color(fn ($state): string => $state > 0 ? 'success' : 'primary'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
                    ->label(fn ($state): string => $state ? 'Published' : 'Draft'),
                Tables\Columns\TextColumn::make('enrollments_count')
                    ->label('Students')
                    ->counts('enrollments')
                    ->sortable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('reviews_avg_rating')
                    ->label('Rating')
                    ->sortable()
                    ->badge()
                    ->color('warning')
                    ->formatStateUsing(fn ($record): string => $record->reviews()->avg('rating')
                        ? number_format($record->reviews()->avg('rating'), 1) . ' ★'
                        : 'N/A'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('instructor')
                    ->relationship('instructor', 'name')
                    ->label('Filter by Instructor')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Filter by Category')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published Status')
                    ->placeholder('All courses')
                    ->trueLabel('Published only')
                    ->falseLabel('Drafts only'),
                Tables\Filters\SelectFilter::make('price_type')
                    ->label('Price Type')
                    ->options([
                        'free' => 'Free',
                        'paid' => 'Paid',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['value']) && $data['value'] === 'free') {
                            $query->whereNull('price');
                        } elseif (isset($data['value']) && $data['value'] === 'paid') {
                            $query->whereNotNull('price')->where('price', '>', 0);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('unpublish')
                    ->label('Unpublish')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Course $record): bool => $record->is_published)
                    ->action(function (Course $record) {
                        $record->update(['is_published' => false]);
                        \Filament\Notifications\Notification::make()
                            ->title('Course Unpublished')
                            ->body('The course has been unpublished successfully.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('unpublish')
                        ->label('Unpublish Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update(['is_published' => false]);
                            }
                            \Filament\Notifications\Notification::make()
                                ->title('Courses Unpublished')
                                ->body('The selected courses have been unpublished.')
                                ->success()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'view' => Pages\ViewCourse::route('/{record}'),
        ];
    }
}
