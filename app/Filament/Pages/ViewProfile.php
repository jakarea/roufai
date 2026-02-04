<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Infolists\Components\TextEntry as InfoTextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;

class ViewProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'My Profile';

    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.view-profile';

    protected static bool $isLazy = false;

    public static function getRoute(): string
    {
        return '/profile/view';
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Personal Information')
                    ->description('Your account details and information')
                    ->schema([
                        InfoTextEntry::make('name')
                            ->label('Full Name')
                            ->size('lg')
                            ->weight('bold')
                            ->icon('heroicon-o-user'),
                        InfoTextEntry::make('email')
                            ->label('Email Address')
                            ->icon('heroicon-o-envelope')
                            ->copyable(),
                        IconEntry::make('email_verified_at')
                            ->label('Email Verified')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),
                        InfoTextEntry::make('role')
                            ->label('Role')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'admin' => 'success',
                                'instructor' => 'warning',
                                'student' => 'primary',
                                default => 'gray',
                            })
                            ->icon(fn (string $state): string => match ($state) {
                                'admin' => 'heroicon-o-shield-check',
                                'instructor' => 'heroicon-o-academic-cap',
                                'student' => 'heroicon-o-user',
                                default => 'heroicon-o-question-mark-circle',
                            }),
                    ])
                    ->columns(2),

                \Filament\Infolists\Components\Section::make('Additional Information')
                    ->description('Extra details based on your role')
                    ->schema([
                        InfoTextEntry::make('bio')
                            ->label('Bio')
                            ->placeholder('No bio provided')
                            ->markdown()
                            ->visible(fn () => Auth::user()->role === 'instructor' || Auth::user()->role === 'admin'),
                        InfoTextEntry::make('payment_details')
                            ->label('Payment Details')
                            ->placeholder('No payment details provided')
                            ->visible(fn () => Auth::user()->role === 'instructor'),
                    ])
                    ->columns(1)
                    ->visible(fn () => Auth::user()->role !== 'student'),

                \Filament\Infolists\Components\Section::make('Account Information')
                    ->description('Technical details about your account')
                    ->schema([
                        InfoTextEntry::make('created_at')
                            ->label('Member Since')
                            ->dateTime('M d, Y')
                            ->icon('heroicon-o-calendar'),
                        InfoTextEntry::make('updated_at')
                            ->label('Last Updated')
                            ->dateTime('M d, Y \a\t g:i A')
                            ->icon('heroicon-o-clock'),
                    ])
                    ->columns(2),
            ]);
    }
}
