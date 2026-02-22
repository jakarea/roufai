<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateSettingResource\Pages;
use App\Models\CertificateSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class CertificateSettingResource extends Resource
{
    protected static ?string $model = CertificateSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Certificate Settings';

    protected static ?string $modelLabel = 'Certificate Setting';

    protected static ?string $pluralModelLabel = 'Certificate Settings';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = 'Settings';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Certificate Design')
                    ->description('Customize the appearance of certificates')
                    ->schema([
                        Forms\Components\ColorPicker::make('background_color')
                            ->label('Background Color')
                            ->required()
                            ->default('#ffffff'),
                        Forms\Components\ColorPicker::make('text_color')
                            ->label('Text Color')
                            ->required()
                            ->default('#333333'),
                        Forms\Components\ColorPicker::make('accent_color')
                            ->label('Accent Color')
                            ->helperText('Used for borders, highlights, and important elements')
                            ->required()
                            ->default('#6366f1'),
                        Forms\Components\FileUpload::make('background_image')
                            ->label('Background Image')
                            ->image()
                            ->directory('certificate-backgrounds')
                            ->visibility('public')
                            ->helperText('Optional: Upload a custom background image'),
                        Forms\Components\Select::make('template_layout')
                            ->label('Template Layout')
                            ->options([
                                'classic' => 'Classic',
                                'modern' => 'Modern',
                                'elegant' => 'Elegant',
                            ])
                            ->required()
                            ->default('classic'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('background_color')
                    ->label('Background'),
                Tables\Columns\ColorColumn::make('text_color')
                    ->label('Text'),
                Tables\Columns\ColorColumn::make('accent_color')
                    ->label('Accent'),
                Tables\Columns\TextColumn::make('template_layout')
                    ->label('Layout')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListCertificateSettings::route('/'),
            'edit' => Pages\EditCertificateSetting::route('/{record}/edit'),
        ];
    }
}
