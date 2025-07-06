<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\LatestOrdersTable;
use App\Filament\Widgets\OrderChart;
use App\Filament\Widgets\StatsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\Auth;
use Filament\Pages\Dashboard;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\MasalahKerusakanResource;
use App\Filament\Resources\KurirResource;
use App\Filament\Resources\RiwayatResource;
use App\Filament\Resources\UserResource;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $user = Auth::user();

        return $panel
            ->default()
            ->sidebarCollapsibleOnDesktop(true)
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Blue,
            ])
            ->resources(
                $user && $user->role === 'teknisi'
                    ? [OrderResource::class] // Teknisi hanya OrderResource
                    : [ // Role lain boleh semua resource
                        OrderResource::class,
                        MasalahKerusakanResource::class,
                        KurirResource::class,
                        RiwayatResource::class,
                        UserResource::class,
                        // Tambahkan resource lain di sini jika ada
                    ]
            )
            ->pages([
                Dashboard::class,
                // Bisa tambahkan custom page jika kamu punya
            ])
            ->widgets([
                StatsOverview::class,
                OrderChart::class,
                LatestOrdersTable::class,
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
            ]);
    }
}
// class AdminPanelProvider extends PanelProvider
// {

//     public function panel(Panel $panel): Panel
//     {
//         return $panel

//             ->default()
//             ->sidebarCollapsibleOnDesktop(true)
//             ->id('admin')
//             ->path('admin')
//             ->login()
//             ->colors([
//                 'primary' => Color::Blue,
//             ])
//             ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
//             ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
//             ->pages([
//                 Pages\Dashboard::class,
//             ])
//             // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
//             ->widgets([
//                 // Widgets\AccountWidget::class,
//                 // Widgets\FilamentInfoWidget::class,

//                 // Daftarkan widget custom Anda di sini
//                 StatsOverview::class,
//                 OrderChart::class,
//                 LatestOrdersTable::class,
//             ])
//             ->middleware([
//                 EncryptCookies::class,
//                 AddQueuedCookiesToResponse::class,
//                 StartSession::class,
//                 AuthenticateSession::class,
//                 ShareErrorsFromSession::class,
//                 VerifyCsrfToken::class,
//                 SubstituteBindings::class,
//                 DisableBladeIconComponents::class,
//                 DispatchServingFilamentEvent::class,
//             ])
//             ->authMiddleware([
//                 Authenticate::class,
//             ]);
//     }
// }
