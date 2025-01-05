<?php

namespace App\Providers\Filament;

use App\Filament\Auth\CustomLogin;
use App\Filament\Auth\RegistrationPage;
use App\Filament\Resources\FormulirResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use App\Filament\Widgets\AccountWidget;
use App\Filament\Widgets\WelcomeSiswa;
use Filament\Navigation\MenuItem;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;

class SiswaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('siswa')
            ->path('/')
            ->login(CustomLogin::class)
            ->brandLogo('/smp.png')
            ->darkMode(false)
            ->passwordReset()
            ->databaseNotifications()
            ->registration(RegistrationPage::class)
            ->colors([
                'primary' => Color::Teal,
            ])
            ->discoverResources(in: app_path('Filament/Siswa/Resources'), for: 'App\\Filament\\Siswa\\Resources')
            ->discoverPages(in: app_path('Filament/Siswa/Pages'), for: 'App\\Filament\\Siswa\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->topNavigation(true)
            ->discoverWidgets(in: app_path('Filament/Siswa/Widgets'), for: 'App\\Filament\\Siswa\\Widgets')
            ->widgets([
                WelcomeSiswa::class,
                AccountWidget::class,
            ])

            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label(fn() => auth()->user()->name)
                    ->url(fn(): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
                    //If you are using tenancy need to check with the visible method where ->company() is the relation between the user and tenancy model as you called
                    ->visible(function (): bool {
                        return true;
                    }),
            ])
            ->plugins([
                FilamentBackgroundsPlugin::make(),

                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->shouldRegisterNavigation(false)
                    ->canAccess(fn() => true)
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowAvatarForm(
                        value: true,
                        directory: 'avatars', // image will be stored in 'storage/app/public/avatars
                        rules: 'mimes:jpeg,png|max:' . 1024 * 3 //only accept jpeg and png files with a maximum size of 3MB
                    ),
            ])
            ->navigationItems([
                // NavigationItem::make('Formulir')
                //     ->url(fn(): string => route('filament.admin.resources.formulirs.register'))
                //     ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.formulirs.register'))
                //     ->sort(3)
                //     ->label('Formulir Pendaftaran'),

            ])
            ->spa()
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
