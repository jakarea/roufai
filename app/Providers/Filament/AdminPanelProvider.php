<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Profile;
use App\Filament\Widgets;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Navigation\MenuItem;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets as FilamentWidgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('/admin')
            ->brandName('Rouf AI LMS')
            ->brandLogo(asset('images/logo.webp'))
            ->darkModeBrandLogo(asset('images/logo-white.webp'))
            ->brandLogoHeight('3.25rem')
            ->favicon(asset('images/favicon.ico'))
            ->unsavedChangesAlerts()
            ->font('Lato')
            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('4rem')
            ->sidebarWidth('17rem')
            ->authGuard('web')
            ->darkMode(true)
            ->maxContentWidth('full') // Full width container
            ->colors([
                'primary' => '#e850ff',
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AdminStatsWidget::class,
                Widgets\UserDistributionWidget::class,
                Widgets\PlatformRevenueWidget::class,
                Widgets\TopCoursesWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Profile')
                    ->url(fn (): string => Profile::getUrl())
                    ->icon('heroicon-o-user-circle'),
            ]);
    }
}
