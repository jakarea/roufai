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
                // STEP 1: Course Information
                Forms\Components\Section::make('Course Information')
                    ->description('Step 1 of 3: Basic information about your course')
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

                // STEP 2: Modules with Lessons
                Forms\Components\Section::make('Modules')
                    ->description('Step 2 of 3: Create modules for your course (drag to reorder)')
                    ->schema([
                        Forms\Components\Repeater::make('course_modules')
                            ->label('Modules')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Module Title')
                                    ->required()
                                    ->placeholder('e.g., Introduction, Getting Started, Advanced Topics')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('description')
                                    ->label('Module Description')
                                    ->rows(2)
                                    ->placeholder('Brief description of what students will learn in this module')
                                    ->columnSpanFull(),
                                Forms\Components\Section::make('Lessons')
                                    ->description('Add lessons to this module')
                                    ->schema([
                                        Forms\Components\Repeater::make('lessons')
                                            ->label('Lessons')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Lesson Title')
                                                    ->required()
                                                    ->columnSpan(2),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Description')
                                                    ->rows(2)
                                                    ->columnSpanFull(),
                                                Forms\Components\Select::make('video_provider')
                                                    ->label('Video Platform')
                                                    ->options([
                                                        'youtube' => 'YouTube',
                                                        'vimeo' => 'Vimeo',
                                                    ])
                                                    ->required()
                                                    ->default('youtube')
                                                    ->columnSpan(1),
                                                Forms\Components\TextInput::make('video_id')
                                                    ->label('Video ID')
                                                    ->required()
                                                    ->columnSpan(2),
                                                Forms\Components\TextInput::make('duration_in_minutes')
                                                    ->label('Duration (minutes)')
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->default(0)
                                                    ->columnSpan(1),
                                                Forms\Components\Toggle::make('is_free_preview')
                                                    ->label('Free Preview')
                                                    ->default(false)
                                                    ->columnSpan(1),
                                                Forms\Components\FileUpload::make('attachment_path')
                                                    ->label('PDF Attachment')
                                                    ->acceptedFileTypes(['application/pdf'])
                                                    ->directory('lesson-attachments')
                                                    ->maxSize(10240)
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(2)
                                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                            ->collapsible()
                                            ->cloneable()
                                            ->default([])
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1),
                            ])
                            ->columns(1)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->collapsible()
                            ->cloneable()
                            ->orderable()
                            ->default([])
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
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

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['modules', 'lessons']);

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

        // Extract modules and lessons from form data
        $courseModules = $data['course_modules'] ?? [];
        unset($data['course_modules']);

        // Store for later use in afterCreate
        $data['_modules'] = $courseModules;

        return $data;
    }

    public static function afterCreate($record, array $data): void
    {
        // Handle modules and lessons creation
        $courseModules = $data['_modules'] ?? [];

        foreach ($courseModules as $index => $moduleData) {
            $lessons = $moduleData['lessons'] ?? [];
            unset($moduleData['lessons']);

            // Create module
            $module = new \App\Models\Module([
                'title' => $moduleData['title'],
                'description' => $moduleData['description'] ?? null,
                'course_id' => $record->id,
                'order' => $index,
            ]);
            $module->save();

            // Create lessons for this module
            foreach ($lessons as $lessonIndex => $lessonData) {
                $lesson = new \App\Models\Lesson([
                    'module_id' => $module->id,
                    'course_id' => $record->id,
                    'title' => $lessonData['title'],
                    'description' => $lessonData['description'] ?? null,
                    'video_provider' => $lessonData['video_provider'] ?? 'youtube',
                    'video_id' => $lessonData['video_id'],
                    'duration_in_minutes' => $lessonData['duration_in_minutes'] ?? 0,
                    'is_free_preview' => $lessonData['is_free_preview'] ?? false,
                    'attachment_path' => $lessonData['attachment_path'] ?? null,
                    'order_index' => $lessonIndex,
                ]);
                $lesson->save();
            }
        }
    }

    public static function mutateFormDataBeforeUpdate(array $data, $record): array
    {
        // Load existing modules and lessons if not being edited
        if (!isset($data['course_modules'])) {
            $data['course_modules'] = [];

            foreach ($record->modules()->orderBy('order')->get() as $module) {
                $moduleData = [
                    'title' => $module->title,
                    'description' => $module->description,
                ];

                // Load lessons for this module
                $moduleData['lessons'] = [];
                foreach ($module->lessons()->orderBy('order_index')->get() as $lesson) {
                    $moduleData['lessons'][] = [
                        'title' => $lesson->title,
                        'description' => $lesson->description,
                        'video_provider' => $lesson->video_provider,
                        'video_id' => $lesson->video_id,
                        'duration_in_minutes' => $lesson->duration_in_minutes,
                        'is_free_preview' => $lesson->is_free_preview,
                        'attachment_path' => $lesson->attachment_path,
                    ];
                }

                $data['course_modules'][] = $moduleData;
            }
        }

        // Extract modules and lessons from form data for saving
        $courseModules = $data['course_modules'] ?? [];
        unset($data['course_modules']);

        // Store for later use in afterUpdate
        $data['_modules'] = $courseModules;

        return $data;
    }

    public static function afterUpdate($record, array $data): void
    {
        // Delete existing modules and lessons (will be recreated)
        $record->modules()->delete();
        $record->lessons()->delete();

        // Handle modules and lessons recreation
        $courseModules = $data['_modules'] ?? [];

        foreach ($courseModules as $index => $moduleData) {
            $lessons = $moduleData['lessons'] ?? [];
            unset($moduleData['lessons']);

            // Create module
            $module = new \App\Models\Module([
                'title' => $moduleData['title'],
                'description' => $moduleData['description'] ?? null,
                'course_id' => $record->id,
                'order' => $index,
            ]);
            $module->save();

            // Create lessons for this module
            foreach ($lessons as $lessonIndex => $lessonData) {
                $lesson = new \App\Models\Lesson([
                    'module_id' => $module->id,
                    'course_id' => $record->id,
                    'title' => $lessonData['title'],
                    'description' => $lessonData['description'] ?? null,
                    'video_provider' => $lessonData['video_provider'] ?? 'youtube',
                    'video_id' => $lessonData['video_id'],
                    'duration_in_minutes' => $lessonData['duration_in_minutes'] ?? 0,
                    'is_free_preview' => $lessonData['is_free_preview'] ?? false,
                    'attachment_path' => $lessonData['attachment_path'] ?? null,
                    'order_index' => $lessonIndex,
                ]);
                $lesson->save();
            }
        }
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
}
