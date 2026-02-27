<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpertResource\Pages;
use App\Models\Expert;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExpertResource extends Resource
{
    protected static ?string $model = Expert::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Experts';

    protected static ?string $modelLabel = 'Expert';

    protected static ?string $pluralModelLabel = 'Experts';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Expert Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title')
                            ->label('Professional Title')
                            ->required()
                            ->placeholder('e.g., Visual Artist | Senior Visualizer')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('bio')
                            ->label('Short Biography')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('image')
                            ->label('Upload Image')
                            ->image()
                            ->directory('experts')
                            ->maxSize(2048)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('image_url')
                            ->label('Or Use External Image URL')
                            ->url()
                            ->placeholder('https://example.com/image.jpg')
                            ->columnSpanFull(),

                        Forms\Components\Section::make('Social Links')
                            ->schema([
                                Forms\Components\TextInput::make('facebook_url')
                                    ->url()
                                    ->prefix('https://facebook.com/')
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('instagram_url')
                                    ->url()
                                    ->prefix('https://instagram.com/')
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('linkedin_url')
                                    ->url()
                                    ->prefix('https://linkedin.com/in/')
                                    ->columnSpan(2),

                                Forms\Components\TextInput::make('twitter_url')
                                    ->url()
                                    ->prefix('https://twitter.com/')
                                    ->columnSpan(2),
                            ])
                            ->columns(4),

                        Forms\Components\Section::make('Settings')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('order_column')
                                    ->label('Display Order')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Lower numbers appear first')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->square()
                    ->size(60),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('bio')
                    ->searchable()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('order_column')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->placeholder('All experts')
                    ->trueLabel('Active experts')
                    ->falseLabel('Inactive experts'),
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
            ->defaultSort('order_column', 'asc')
            ->reorderable('order_column');
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
            'index' => Pages\ListExperts::route('/'),
            'create' => Pages\CreateExpert::route('/create'),
            'view' => Pages\ViewExpert::route('/{record}'),
            'edit' => Pages\EditExpert::route('/{record}/edit'),
        ];
    }
}
