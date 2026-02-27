<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BootcampConfigResource\Pages;
use App\Filament\Resources\BootcampConfigResource\RelationManagers;
use App\Models\BootcampConfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BootcampConfigResource extends Resource
{
    protected static ?string $model = BootcampConfig::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Bootcamp Settings';

    protected static ?string $modelLabel = 'Bootcamp Config';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Course & Instructor Selection')
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('Select Course')
                            ->options(function () {
                                return \App\Models\Course::where('is_published', true)
                                    ->with('instructor')
                                    ->get()
                                    ->mapWithKeys(function ($course) {
                                        $price = $course->type === 'FREE' ? 'ফ্রি' : '৳' . number_format($course->price);
                                        $instructor = $course->instructor ? $course->instructor->name : 'Unknown';
                                        return [$course->id => "{$course->title} ({$price}) - {$instructor}"];
                                    });
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, $set, $get) {
                                if ($state) {
                                    $course = \App\Models\Course::find($state);
                                    if ($course) {
                                        // Set price if not already set
                                        if (!$get('price')) {
                                            $set('price', $course->type === 'FREE' ? 'ফ্রি' : '৳' . number_format($course->price));
                                        }

                                        // Set video URL if course has one and bootcamp doesn't
                                        if (!$get('video_url') && $course->video_url) {
                                            $set('video_url', $course->video_url);
                                        }

                                        // Set instructor if course has one and bootcamp doesn't
                                        if (!$get('instructor_id') && $course->instructor_id) {
                                            $set('instructor_id', $course->instructor_id);
                                        }
                                    }
                                }
                            })
                            ->helperText('Select a course to auto-fill details. You can override them below.'),
                        Forms\Components\Select::make('instructor_id')
                            ->label('Select Instructor')
                            ->relationship(name: 'instructor', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->helperText('Select an instructor (auto-filled from course if available)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('General Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Bootcamp Title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., AI Creative Bootcamp - 25'),
                        Forms\Components\TextInput::make('subtitle')
                            ->label('Subtitle')
                            ->maxLength(255)
                            ->placeholder('e.g., Learn AI in 3 Days'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->placeholder('Enter bootcamp description...'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Schedule & Dates')
                    ->schema([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Bootcamp Start Date')
                            ->required()
                            ->native(false),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('Bootcamp End Date')
                            ->native(false),
                        Forms\Components\DateTimePicker::make('countdown_target_date')
                            ->label('Countdown Target Date (When countdown reaches zero)')
                            ->required()
                            ->native(false)
                            ->helperText('This is the date the countdown will count to. Usually the same as start date or a future date.'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Video & Media')
                    ->schema([
                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('Enter YouTube video URL for the bootcamp.'),
                        Forms\Components\FileUpload::make('thumbnail_image')
                            ->label('Bootcamp Thumbnail Image (Optional)')
                            ->image()
                            ->directory('bootcamp-thumbnails')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->maxSize(5120)
                            ->helperText('Upload custom bootcamp thumbnail. Leave empty to use course thumbnail as default.'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Display Information')
                    ->schema([
                        Forms\Components\TextInput::make('bootcamp_name')
                            ->label('Bootcamp Display Name')
                            ->maxLength(255)
                            ->placeholder('e.g., Ai Advertising Bootcamp - 25')
                            ->helperText('HTML supported: e.g., Ai <span class="text-gradient">বুটক্যাম্প - ২৫</span>'),
                        Forms\Components\TextInput::make('price')
                            ->label('Price Override (Optional)')
                            ->helperText('Leave empty to use course price. Enter "ফ্রি" for free or custom price like "৳৫,৩২০"')
                            ->placeholder('e.g., ৳৫,৩২০ or ফ্রি'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Visibility')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Show Bootcamp Section')
                            ->helperText('When enabled, the bootcamp section will be visible on the homepage')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                Tables\Columns\TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Start Date')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->since(),
                Tables\Columns\ImageColumn::make('thumbnail_image')
                    ->label('Thumbnail')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->display_price;
                    })
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
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
            'index' => Pages\ListBootcampConfigs::route('/'),
            'create' => Pages\CreateBootcampConfig::route('/create'),
            'edit' => Pages\EditBootcampConfig::route('/{record}/edit'),
        ];
    }
}
