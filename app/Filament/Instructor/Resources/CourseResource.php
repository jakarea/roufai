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
                    ->description('Step 1 of 2: Basic information about your course')
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
                            ->live()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('price')
                            ->label('Price (BDT)')
                            ->numeric()
                            ->prefix('৳')
                            ->visible(fn (callable $get) => $get('type') === 'PAID')
                            ->required(fn (callable $get) => $get('type') === 'PAID')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('short_description')
                            ->label('Short Description')
                            ->helperText('Brief summary for course cards (recommended: 150-200 characters)')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('description')
                            ->label('Course Description')
                            ->helperText('Full detailed description with rich formatting')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'media',
                                'numberedList',
                                'redo',
                                'strike',
                                'undo',
                            ]),
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

                // STEP 2: Modules & Lessons
                Forms\Components\Section::make('Modules & Lessons')
                    ->description('Step 2 of 2: Add modules and lessons to your course')
                    ->schema([
                        Forms\Components\Repeater::make('modules')
                            ->relationship()
                            ->schema([
                                Forms\Components\Section::make('Module Information')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Module Title')
                                            ->required()
                                            ->columnSpanFull(),
                                        Forms\Components\Textarea::make('description')
                                            ->label('Description')
                                            ->rows(2)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Lessons')
                                    ->description('Add lessons to this module')
                                    ->schema([
                                        Forms\Components\Repeater::make('lessons')
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label('Lesson Title')
                                                    ->required()
                                                    ->columnSpan(2),
                                                Forms\Components\TextInput::make('duration_in_minutes')
                                                    ->label('Duration (min)')
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->default(0)
                                                    ->columnSpan(1),
                                                Forms\Components\Select::make('video_provider')
                                                    ->label('Video Platform')
                                                    ->options([
                                                        'youtube' => 'YouTube',
                                                        'vimeo' => 'Vimeo',
                                                    ])
                                                    ->required()
                                                    ->default('youtube')
                                                    ->live()
                                                    ->columnSpan(1),
                                                Forms\Components\TextInput::make('video_id')
                                                    ->label('Video ID')
                                                    ->required()
                                                    ->placeholder(fn (callable $get) => $get('../../video_provider') === 'youtube'
                                                        ? 'YouTube Video ID (e.g., dQw4w9WgXcQ)'
                                                        : 'Vimeo Video ID (e.g., 123456789)')
                                                    ->helperText(fn (callable $get) => $get('../../video_provider') === 'youtube'
                                                        ? 'Paste the YouTube video ID only (from https://youtube.com/watch?v=VIDEO_ID)'
                                                        : 'Paste the Vimeo video ID only (from https://vimeo.com/VIDEO_ID)')
                                                    ->columnSpan(2),
                                                Forms\Components\Textarea::make('description')
                                                    ->label('Description')
                                                    ->rows(2)
                                                    ->columnSpanFull(),
                                                Forms\Components\Toggle::make('is_free_preview')
                                                    ->label('Free Preview')
                                                    ->helperText('Allow students to watch this lesson without enrolling')
                                                    ->default(false)
                                                    ->columnSpan(1),
                                                Forms\Components\FileUpload::make('attachment_path')
                                                    ->label('PDF Attachment')
                                                    ->acceptedFileTypes(['application/pdf'])
                                                    ->directory('lesson-attachments')
                                                    ->maxSize(10240)
                                                    ->columnSpan(1),
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
                            ->columns(2)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->collapsible()
                            ->cloneable()
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
        return parent::getEloquentQuery()->with(['modules.lessons'])
            ->where('instructor_id', Auth::id());
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
