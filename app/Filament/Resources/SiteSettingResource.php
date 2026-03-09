<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Site Settings';

    protected static ?string $modelLabel = 'Site Setting';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Hero Section')
                    ->description('Configure how the homepage hero section is displayed')
                    ->schema([
                        Forms\Components\Select::make('hero_display_mode')
                            ->label('Hero Display Mode')
                            ->options([
                                'slider' => 'Image Slider Mode',
                                'video' => 'Video Mode',
                            ])
                            ->required()
                            ->default('slider')
                            ->reactive()
                            ->helperText('Choose how the hero section appears on the homepage')
                            ->afterStateUpdated(function ($state, $set, $get, $record) {
                                // When mode changes, activate/deactivate slides accordingly
                                if ($record && $record->exists) {
                                    $oldMode = $record->getOriginal('hero_display_mode');
                                    $newMode = $state;

                                    if ($oldMode !== $newMode) {
                                        if ($newMode === 'video') {
                                            // Switch to video mode
                                            HeroSlide::where('type', 'image')->update(['is_active' => false]);
                                            $firstVideo = HeroSlide::where('type', 'video')->orderBy('order_index')->first();
                                            if ($firstVideo) {
                                                HeroSlide::where('type', 'video')->update(['is_active' => false]);
                                                $firstVideo->is_active = true;
                                                $firstVideo->save();
                                            }

                                            \Filament\Notifications\Notification::make()
                                                ->title('Switched to Video Mode')
                                                ->body('One video is now active. All image slides have been deactivated.')
                                                ->warning()
                                                ->send();
                                        } else {
                                            // Switch to image slider mode
                                            HeroSlide::where('type', 'video')->update(['is_active' => false]);
                                            HeroSlide::where('type', 'image')->update(['is_active' => true]);

                                            \Filament\Notifications\Notification::make()
                                                ->title('Switched to Image Slider Mode')
                                                ->body('All image slides are now active. Video slides have been deactivated.')
                                                ->success()
                                                ->send();
                                        }
                                    }
                                }
                            })
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Brand Identity')
                    ->description('Upload your logo to use across the entire platform')
                    ->schema([
                        Forms\Components\FileUpload::make('logo')
                            ->label('Website Logo')
                            ->image()
                            ->imageEditor()
                            ->directory('logos')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                            ->helperText('Upload your logo (max 2MB). Supported formats: PNG, JPG, WEBP. If no logo is uploaded, the default logo will be used.')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Company Information')
                    ->description('Manage your company information that appears on the website')
                    ->schema([
                        Forms\Components\TextInput::make('company_tagline')
                            ->label('Company Tagline')
                            ->placeholder('বাংলাদেশের শীর্ষ এআই ক্রিয়েটিভ ট্রেনিং প্ল্যাটফর্ম')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('company_description')
                            ->label('Company Description')
                            ->rows(3)
                            ->placeholder('Detailed description about your company')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Contact Information')
                    ->description('Contact details shown in the footer')
                    ->schema([
                        Forms\Components\TextInput::make('contact_phone')
                            ->label('Phone Number')
                            ->placeholder('+880 1712-345678')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_email')
                            ->label('Email Address')
                            ->placeholder('info@roufai.com')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contact_address')
                            ->label('Address')
                            ->placeholder('ঢাকা, বাংলাদেশ')
                            ->maxLength(255),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Social Media Links')
                    ->description('Your social media profiles')
                    ->schema([
                        Forms\Components\TextInput::make('facebook_url')
                            ->label('Facebook URL')
                            ->url()
                            ->placeholder('https://facebook.com/...')
                            ->prefixIcon('heroicon-o-arrow-top-right-on-square'),
                        Forms\Components\TextInput::make('youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->placeholder('https://youtube.com/@...')
                            ->prefixIcon('heroicon-o-arrow-top-right-on-square'),
                        Forms\Components\TextInput::make('linkedin_url')
                            ->label('LinkedIn URL')
                            ->url()
                            ->placeholder('https://linkedin.com/in/...')
                            ->prefixIcon('heroicon-o-arrow-top-right-on-square'),
                        Forms\Components\TextInput::make('twitter_url')
                            ->label('Twitter/X URL')
                            ->url()
                            ->placeholder('https://twitter.com/...')
                            ->prefixIcon('heroicon-o-arrow-top-right-on-square'),
                        Forms\Components\TextInput::make('instagram_url')
                            ->label('Instagram URL')
                            ->url()
                            ->placeholder('https://instagram.com/...')
                            ->prefixIcon('heroicon-o-arrow-top-right-on-square'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Footer Links')
                    ->schema([
                        Forms\Components\TextInput::make('about_us_url')
                            ->label('About Us Page URL')
                            ->placeholder('https://your-site.com/about')
                            ->helperText('Leave empty to use default route')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('CTA Section')
                    ->description('Configure the Call-to-Action section on the homepage')
                    ->schema([
                        Forms\Components\TextInput::make('cta_outer_title')
                            ->label('Outer Title')
                            ->placeholder('আপনার আইডিয়াকে বদলে দিন এআই ক্রিয়েশনে')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('cta_outer_subtitle')
                            ->label('Outer Subtitle')
                            ->rows(2)
                            ->placeholder('সঠিক পদ্ধতিতে, ধাপে ধাপে এবং কৌশল ব্যবহার করে আপনার স্কিলকে দ্রুত দক্ষ করে তুলুন')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('cta_inner_title')
                            ->label('Inner Title')
                            ->placeholder('ক্রিয়েটিভিটির ভবিষ্যৎ এখন আপনার হাতে')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('cta_inner_subtitle')
                            ->label('Inner Subtitle')
                            ->rows(2)
                            ->placeholder('RoufAI প্ল্যাটফর্মে এখনই যুক্ত হোন, হয়ে উঠুন এআই-চালিত ক্রিয়েটিভ প্রফেশনাল।')
                            ->columnSpanFull(),
                        Forms\Components\Section::make('Buttons')
                            ->schema([
                                Forms\Components\TextInput::make('cta_button1_text')
                                    ->label('Button 1 Text')
                                    ->placeholder('এখনই এনরোল করুন')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('cta_button1_url')
                                    ->label('Button 1 URL')
                                    ->placeholder('/courses or https://example.com')
                                    ->helperText('Enter a URL (e.g., https://example.com) or a path (e.g., /courses)')
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('cta_button2_text')
                                    ->label('Button 2 Text')
                                    ->placeholder('সার্টিফিকেট পান')
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('cta_button2_url')
                                    ->label('Button 2 URL')
                                    ->placeholder('/courses or https://example.com')
                                    ->helperText('Enter a URL (e.g., https://example.com) or a path (e.g., /courses)')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Copyright & Credits')
                    ->schema([
                        Forms\Components\TextInput::make('copyright_text')
                            ->label('Copyright Text')
                            ->placeholder('© 2025 Rouf AI - সর্বস্বত্ব সংরক্ষিত।')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('developer_credit_text')
                            ->label('Developer Credit Text')
                            ->placeholder('Developed with ❤️ by Giopio')
                            ->maxLength(255),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company_tagline')
                    ->label('Tagline')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->limit(50),
                Tables\Columns\TextColumn::make('contact_phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('contact_email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('updated_at', 'desc');
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
            'index' => Pages\ListSiteSettings::route('/'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        // Prevent creation if settings already exist
        return \App\Models\SiteSetting::count() === 0;
    }
}
