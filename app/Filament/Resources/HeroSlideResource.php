<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Filament\Resources\HeroSlideResource\RelationManagers;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Hero Slides';

    protected static ?string $modelLabel = 'Hero Slide';

    protected static ?string $pluralModelLabel = 'Hero Slides';

    protected static ?string $navigationGroup = 'Website Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Slide Content')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('button_text')
                            ->label('Button Text')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('button_url')
                            ->label('Button URL')
                            ->url()
                            ->columnSpan(1),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Media & Settings')
                    ->schema([
                        Forms\Components\FileUpload::make('background_image')
                            ->label('Background Image')
                            ->image()
                            ->imageEditor()
                            ->directory('hero-slides')
                            ->visibility('public')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('order_index')
                            ->label('Display Order')
                            ->helperText('Lower numbers appear first')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->columnSpan(1),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Only active slides will be displayed')
                            ->default(true)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('background_image')
                    ->label('Image')
                    ->square()
                    ->size(80),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record): string => \Illuminate\Support\Str::limit($record->description, 100)),
                Tables\Columns\TextColumn::make('button_text')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('button_url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('order_index')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('order_index')
            ->defaultSort('order_index')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All slides')
                    ->trueLabel('Active slides')
                    ->falseLabel('Inactive slides')
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
            ]);
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
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
