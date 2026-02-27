<?php

namespace App\Providers\Filament;

use App\Filament\Instructor\Pages\InstructorProfile;
use App\Filament\Instructor\Widgets;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\MenuItem;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class InstructorPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('instructor')
            ->path('instructor')
            ->brandName('Rouf AI Academy - Instructor')
            ->brandLogo(asset('website-images/logo.webp'))
            ->darkModeBrandLogo(asset('website-images/logo-white.webp'))
            ->brandLogoHeight('3.25rem')
            ->unsavedChangesAlerts()
            ->font('Lato')
            ->sidebarCollapsibleOnDesktop()
            ->collapsedSidebarWidth('4rem')
            ->sidebarWidth('17rem')
            ->authGuard('web')
            ->darkMode(true)
            ->maxContentWidth('full')
            ->colors([
                'primary' => '#e850ff',
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Instructor/Resources'), for: 'App\\Filament\\Instructor\\Resources')
            ->discoverPages(in: app_path('Filament/Instructor/Pages'), for: 'App\\Filament\\Instructor\\Pages')
            ->pages([
                Pages\Dashboard::class,
                InstructorProfile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Instructor/Widgets'), for: 'App\\Filament\\Instructor\\Widgets')
            ->widgets([
                Widgets\InstructorStatsWidget::class,
                Widgets\CoursesChartWidget::class,
                Widgets\RevenueChartWidget::class,
                Widgets\EnrollmentTrendsWidget::class,
                Widgets\RecentEnrollmentsWidget::class,
                Widgets\PendingRequestsWidget::class,
                Widgets\RecentReviewsWidget::class,
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
                    ->url(fn (): string => InstructorProfile::getUrl())
                    ->icon('heroicon-o-user-circle'),
            ]);
    }
}
