<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\CourseResource\Pages;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'My Courses';

    protected static ?string $modelLabel = 'Course';

    protected static ?string $pluralModelLabel = 'Courses';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Course Management';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'instructor';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Course Information')
                    ->description('Basic information about your course')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(2),
                        Forms\Components\Select::make('type')
                            ->options([
                                'FREE' => 'FREE',
                                'PAID' => 'PAID',
                            ])
                            ->required()
                            ->default('FREE')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('price')
                            ->label('Price (BDT)')
                            ->numeric()
                            ->prefix('৳')
                            ->visible(fn (callable $get) => $get('type') === 'PAID')
                            ->required(fn (callable $get) => $get('type') === 'PAID')
                            ->columnSpan(2),
                        Forms\Components\FileUpload::make('thumbnail_path')
                            ->label('Course Thumbnail')
                            ->image()
                            ->imageEditor()
                            ->directory('course-thumbnails')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('is_published')
                            ->label('Publish Course')
                            ->helperText('Enable to make this course visible to students')
                            ->default(false)
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->square()
                    ->size(60)
                    ->defaultImageUrl(url('https://via.placeholder.com/60x60?text=No+Image')),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => $record->category->name ?? 'No category'),
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'success' => 'FREE',
                        'warning' => 'PAID',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price (BDT)')
                    ->money('bdt')
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => $state ? '৳' . number_format($state, 0) : 'FREE'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'FREE' => 'FREE',
                        'PAID' => 'PAID',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Published')
                    ->nullable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Only show current instructor's courses
        if (Auth::check() && Auth::user()->role === 'instructor') {
            $query->where('instructor_id', Auth::id());
        }

        return $query;
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        // Set instructor_id to current user
        $data['instructor_id'] = Auth::id();

        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data, $record): array
    {
        // Ensure instructor_id cannot be changed
        unset($data['instructor_id']);

        return $data;
    }
}
