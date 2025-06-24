<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Exception;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\View;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Throwable;

class LogoutWidget extends XotBaseWidget
{
    protected static string $view = 'user::widgets.logout';

    public ?array $data = [];
    public bool $isLoggingOut = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function getFormSchema(): array
    {
        return [
            View::make('filament.widgets.auth.logout-message')
                ->columnSpanFull(),
        ];
    }

    public function logout(): void
    {
        try {
            $this->isLoggingOut = true;
            $user = Auth::user();

            if (!$user) {
                $this->handleNoUserScenario();
                return;
            }

            $this->dispatchPreLogoutEvent($user);
            $this->performLogout();
            $this->dispatchPostLogoutEvent();
            $this->logLogoutSuccess($user);
            $this->redirectAfterLogout();
        } catch (Throwable $e) {
            $this->handleLogoutError($e);
        }
    }

    public function getFormActions(): array
    {
        return [
            $this->getLogoutAction(),
            $this->getCancelAction(),
        ];
    }

    protected function getLogoutAction(): Action
    {
        return Action::make('logout')
            ->translateLabel()
            ->color('danger')
            ->size('lg')
            ->extraAttributes(['class' => 'w-full justify-center'])
            ->action(fn () => $this->logout());
    }

    protected function getCancelAction(): Action
    {
        return Action::make('cancel')
            ->translateLabel()
            ->color('gray')
            ->size('lg')
            ->extraAttributes(['class' => 'w-full justify-center mt-2'])
            ->url($this->getLocalizedHomeUrl());
    }

    protected function getLocalizedHomeUrl(): string
    {
        return '/' . App::getLocale();
    }

    protected function handleNoUserScenario(): void
    {
        $this->isLoggingOut = false;
        Log::warning('Logout attempted with no authenticated user');
    }

    protected function dispatchPreLogoutEvent(Authenticatable $user): void
    {
        Event::dispatch('auth.logout.attempting', [$user]);
    }

    protected function performLogout(): void
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    protected function dispatchPostLogoutEvent(): void
    {
        Event::dispatch('auth.logout.successful');
    }

    protected function logLogoutSuccess(Authenticatable $user): void
    {
        Log::info('User logged out', [
            'user_id' => $user->getAuthIdentifier(),
            'timestamp' => now()->toDateTimeString(),
        ]);
    }

    protected function redirectAfterLogout(): void
    {
        redirect($this->getLocalizedHomeUrl())
            ->with('success', __('user::auth.logout_success'))
            ->send();
        exit;
    }

    protected function handleLogoutError(Throwable $e): void
    {
        Log::error('Logout error: ' . $e->getMessage(), [
            'exception' => get_class($e),
            'trace' => $e->getTraceAsString(),
        ]);

        $this->isLoggingOut = false;
        Session::flash('error', __('user::auth.logout_error'));
    }

    protected function getViewData(): array
    {
        return [
            'title' => __('user::auth.logout_title'),
            'description' => __('user::auth.logout_confirmation'),
        ];
    }
}