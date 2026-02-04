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
                        Forms\Components\Select::make('video_type')
                            ->label('Video Platform')
                            ->options([
                                'youtube' => 'YouTube',
                                'vimeo' => 'Vimeo',
                            ])
                            ->required()
                            ->default('youtube')
                            ->live()
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->required()
                            ->placeholder(fn (callable $get) => $get('video_type') === 'youtube'
                                ? 'https://www.youtube.com/watch?v=...'
                                : 'https://vimeo.com/...')
                            ->helperText('Paste the full video URL here')
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('video_embed_code')
                            ->label('Embed Code (Optional)')
                            ->rows(3)
                            ->placeholder('<iframe>...</iframe>')
                            ->helperText('Or paste custom embed code here (overrides video URL)')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('Duration (minutes)')
                            ->numeric()
                            ->minValue(1)
                            ->placeholder('e.g., 15')
                            ->helperText('Approximate video duration in minutes')
                            ->columnSpan(1),
                        Forms\Components\Toggle::make('is_preview')
                            ->label('Free Preview')
                            ->helperText('Allow students to watch this lesson without enrolling')
                            ->default(false)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
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
                Tables\Columns\BadgeColumn::make('video_type')
                    ->colors([
                        'danger' => 'youtube',
                        'primary' => 'vimeo',
                    ]),
                Tables\Columns\IconColumn::make('is_preview')
                    ->label('Preview')
                    ->boolean()
                    ->trueIcon('heroicon-o-eye')
                    ->falseIcon('heroicon-o-eye-slash')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Duration')
                    ->formatStateUsing(fn ($state): string => $state ? "{$state} min" : '-')
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
                Tables\Filters\SelectFilter::make('video_type')
                    ->options([
                        'youtube' => 'YouTube',
                        'vimeo' => 'Vimeo',
                    ]),
                Tables\Filters\TernaryFilter::make('is_preview')
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
