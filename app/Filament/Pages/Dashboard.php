<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Pages;

<<<<<<< HEAD
use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Panel;
use Filament\Support\Facades\FilamentIcon;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Route;
=======
use Filament\Panel;
use Filament\Pages\Page;
use Filament\Widgets\Widget;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
use Filament\Widgets\WidgetConfiguration;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Contracts\Support\Htmlable;
>>>>>>> bc33217 (.)
use Modules\Xot\Filament\Pages\XotBaseDashboard;

class Dashboard extends XotBaseDashboard
{
<<<<<<< HEAD
    
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static null|string $navigationIcon = 'heroicon-o-home';

    protected static null|string $navigationGroup = 'Dashboards';
=======
    //
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Dashboards';
>>>>>>> bc33217 (.)

    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::pages.dashboard';

    public static function getNavigationLabel(): string
    {
<<<<<<< HEAD
        return static::$navigationLabel ?? static::$title ?? __('filament-panels::pages/dashboard.title');
    }

    public static function getNavigationIcon(): null|string
    {
        return (
            static::$navigationIcon ??
            FilamentIcon::resolve('panels::pages.dashboard.navigation-item') ??
                (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home')
        );
=======
        return static::$navigationLabel ??
            static::$title ??
            __('filament-panels::pages/dashboard.title');
    }

    public static function getNavigationIcon(): ?string
    {
        return static::$navigationIcon
            ?? FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home');
>>>>>>> bc33217 (.)
    }

    public static function routes(Panel $panel): void
    {
        Route::get('/', static::class)
            ->middleware(static::getRouteMiddleware($panel))
            ->withoutMiddleware(static::getWithoutRouteMiddleware($panel))
            ->name(static::getSlug());
    }

    public function mount(): void
    {
        // $user = auth()->user();
        // if (1 === $user->roles->count()) {
        //    redirect('/blog/admin/dashboard');
        // }
<<<<<<< HEAD
=======

>>>>>>> bc33217 (.)
        // if (! $user->hasRole('super-admin')) {
        //     redirect('/admin');
        // }
    }

    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getWidgets(): array
    {
        /**
         * @var array<class-string<Widget>|WidgetConfiguration>
         */
        $widgets = Filament::getWidgets();

        return $widgets;
    }

    /**
     * @return array<class-string<Widget>|WidgetConfiguration>
     */
    public function getVisibleWidgets(): array
    {
        return $this->filterVisibleWidgets($this->getWidgets());
    }

    /**
     * @return int|string|array<string, int|string|null>
     */
    public function getColumns(): int|string|array
    {
        return 2;
    }

    public function getTitle(): string|Htmlable
    {
        return static::$title ?? __('filament-panels::pages/dashboard.title');
    }
}
