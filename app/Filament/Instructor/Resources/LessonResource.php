<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\LessonResource\Pages;
use App\Models\Lesson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-play-circle';

    protected static ?string $navigationLabel = 'Lessons';

    protected static ?string $modelLabel = 'Lesson';

    protected static ?string $pluralModelLabel = 'Lessons';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Course Management';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'instructor';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Lesson Information')
                    ->description('Add a new lesson to a module')
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->options(function () {
                                return \App\Models\Course::where('instructor_id', Auth::id())
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->disabled(fn ($record) => $record !== null) // Disable when editing
                            ->columnSpan(2),
                        Forms\Components\Select::make('module_id')
                            ->label('Module')
                            ->options(function (callable $get) {
                                $courseId = $get('course_id');

                                if (!$courseId) {
                                    return [];
                                }

                                return \App\Models\Module::where('course_id', $courseId)
                                    ->orderBy('order_index')
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Auto-set course_id when module is selected
                                if ($state) {
                                    $module = \App\Models\Module::find($state);
                                    if ($module) {
                                        $set('course_id', $module->course_id);
                                    }
                                }
                            })
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('order_index')
                            ->label('Order')
                            ->helperText('The order in which this lesson appears in the module')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('duration_in_minutes')
                            ->label('Duration (minutes)')
                            ->helperText('Estimated duration of this lesson')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(0)
                            ->columnSpan(1),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->placeholder('Brief description of this lesson')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Video Content')
                    ->description('Embed a video from YouTube or Vimeo')
                    ->schema([
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
                            ->placeholder(fn (callable $get) => $get('video_provider') === 'youtube'
                                ? 'YouTube Video ID (e.g., dQw4w9WgXcQ)'
                                : 'Vimeo Video ID (e.g., 123456789)')
                            ->helperText(fn (callable $get) => $get('video_provider') === 'youtube'
                                ? 'Paste the YouTube video ID only (from https://youtube.com/watch?v=VIDEO_ID)'
                                : 'Paste the Vimeo video ID only (from https://vimeo.com/VIDEO_ID)')
                            ->columnSpan(2),
                        Forms\Components\Toggle::make('is_free_preview')
                            ->label('Free Preview')
                            ->helperText('Allow students to watch this lesson without enrolling')
                            ->default(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Lesson Attachment')
                    ->description('Attach a PDF file for this lesson (optional)')
                    ->schema([
                        Forms\Components\FileUpload::make('attachment_path')
                            ->label('PDF Attachment')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('lesson-attachments')
                            ->maxSize(10240),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('module.course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('module.title')
                    ->label('Module')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record): string => "Lesson #{$record->order_index}"),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\BadgeColumn::make('video_provider')
                    ->label('Platform')
                    ->colors([
                        'danger' => 'youtube',
                        'primary' => 'vimeo',
                    ]),
                Tables\Columns\IconColumn::make('is_free_preview')
                    ->label('Preview')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('duration_in_minutes')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state) => $state . ' min')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('order_index')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('module')
                    ->label('Module')
                    ->relationship(
                        'module',
                        'title',
                        modifyQueryUsing: function (Builder $query) {
                            $query->whereHas('course', function (Builder $q) {
                                $q->where('instructor_id', Auth::id());
                            });
                        }
                    ),
                Tables\Filters\SelectFilter::make('video_provider')
                    ->label('Platform')
                    ->options([
                        'youtube' => 'YouTube',
                        'vimeo' => 'Vimeo',
                    ]),
                Tables\Filters\TernaryFilter::make('is_free_preview')
                    ->label('Free Preview')
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
            ->defaultSort('module_id')
            ->defaultSort('order_index');
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['module.course']);

        // Only show lessons from current instructor's courses
        if (Auth::check() && Auth::user()->role === 'instructor') {
            $query->whereHas('module.course', function (Builder $query) {
                $query->where('instructor_id', Auth::id());
            });
        }

        return $query;
    }
}
