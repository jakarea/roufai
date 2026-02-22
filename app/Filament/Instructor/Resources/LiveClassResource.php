<?php

namespace App\Filament\Instructor\Resources;

use App\Filament\Instructor\Resources\LiveClassResource\Pages;
use App\Models\LiveClass;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class LiveClassResource extends Resource
{
    protected static ?string $model = LiveClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationLabel = 'Live Classes';

    protected static ?string $modelLabel = 'Live Class';

    protected static ?string $pluralModelLabel = 'Live Classes';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Course Management';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'instructor';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('instructor_id')
                    ->default(fn () => Auth::id()),
                Forms\Components\Section::make('Live Class Information')
                    ->description('Create a new live class for your students')
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('Course (Optional)')
                            ->helperText('Leave empty to make this live class available to ALL students')
                            ->options(function () {
                                return \App\Models\Course::where('instructor_id', Auth::id())
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('topic')
                            ->label('Class Topic')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Advanced React Hooks Tutorial')
                            ->columnSpan(2),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->placeholder('Brief description of what will be covered in this live class')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('meeting_link')
                            ->label('Meeting Link (Zoom/Google Meet)')
                            ->required()
                            ->url()
                            ->placeholder('https://meet.google.com/xxx-xxxx-xxx or https://zoom.us/j/123456789')
                            ->columnSpan(2),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'scheduled' => 'Scheduled',
                                'completed' => 'Completed',
                            ])
                            ->default('scheduled')
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Schedule')
                    ->description('Set the date, time, and duration for this live class')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required()
                            ->minDate(now())
                            ->displayFormat('d-m-Y')
                            ->reactive()
                            ->helperText('Select the date for the live class')
                            ->columnSpan(1),
                        Forms\Components\TimePicker::make('start_time')
                            ->label('Start Time')
                            ->required()
                            ->seconds(false)
                            ->reactive()
                            ->helperText('Select the start time')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('Duration (minutes)')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(60)
                            ->suffix('minutes')
                            ->helperText('Enter duration in minutes (e.g., 60 for 1 hour)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Thumbnail')
                    ->description('Add an optional thumbnail image for the live class')
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail_path')
                            ->label('Thumbnail Image')
                            ->image()
                            ->imageEditor()
                            ->directory('live-class-thumbnails')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/webp'])
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('topic')
                    ->label('Topic')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => $record->course_id ? $record->course->title : 'Public - Available to All Students'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Date')
                    ->date('d-m-Y')
                    ->sortable()
                    ->description(fn ($record): string => $record->start_time?->format('H:i') . ' • ' . $record->duration_minutes . ' min'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('course_access')
                    ->label('Access Type')
                    ->options([
                        'public' => 'Public (All Students)',
                        'course' => 'Course Specific',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['value']) && $data['value'] === 'public') {
                            return $query->whereNull('course_id');
                        } elseif (isset($data['value']) && $data['value'] === 'course') {
                            return $query->whereNotNull('course_id');
                        }
                        return $query;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['course', 'instructor'])
            ->orderByDesc('start_date')
            ->orderByDesc('start_time');

        // Only show live classes for current instructor
        if (Auth::check() && Auth::user()->role === 'instructor') {
            $query->where('instructor_id', Auth::id());
        }

        return $query;
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
            'index' => Pages\ListLiveClasses::route('/'),
            'create' => Pages\CreateLiveClass::route('/create'),
            'edit' => Pages\EditLiveClass::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['instructor_id'] = Auth::id();
        return $data;
    }

    public static function mutateFormDataBeforeUpdate(array $data, $record): array
    {
        // Don't allow changing instructor_id on update
        unset($data['instructor_id']);
        return $data;
    }
}
