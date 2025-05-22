<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form as FilamentForm;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Widgets\Widget;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Modules\User\Datas\PasswordData;
use Modules\User\Events\NewPasswordSet;
use Modules\User\Http\Response\PasswordResetResponse;
use Modules\User\Rules\CheckOtpExpiredRule;
use Modules\Xot\Filament\Traits\TransTrait;
use Webmozart\Assert\Assert;
use Filament\Facades\Filament;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Illuminate\Auth\Events\PasswordReset as PasswordResetResponseEvent;

/**
 * @property ComponentContainer $form
 */
class PasswordExpiredWidget extends XotBaseWidget implements HasForms
{
    use InteractsWithForms;

    // use InteractsWithFormActions;
    use TransTrait;

    public ?string $current_password = '';

    public ?string $password = '';

    public ?string $passwordConfirmation = '';

    public ?array $data = [];

    /**
     * @var view-string
     */
    protected static string $view = 'user::filament.widgets.password-expired';

    protected static bool $shouldRegisterNavigation = false;

    

    /**
     * @return array<Component>
     */
    public function getFormSchema(): array
    {
        return [
            $this->getCurrentPasswordFormComponent(),
            ...PasswordData::make()->getPasswordFormComponents('password'),
        ];
    }

    public function getResetPasswordFormAction(): Action
    {
        return Action::make('resetPassword')
            ->submit('resetPassword');
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function resetPassword(): ?PasswordResetResponse
    {
        $this->validate();

        if (! Hash::check($this->data['current_password'], auth()->user()->password)) {
            $this->addError('current_password', __('user::auth.password_current_incorrect'));
            return null;
        }

        $user = auth()->user();
        $user->password = Hash::make($this->data['password']);
        $user->save();

        return new PasswordResetResponse($user);
    }

    protected function getCurrentPasswordFormComponent(): Component
    {
        $authUser = Filament::auth()->user();

        if ($authUser instanceof \Modules\User\Models\User) {
            return TextInput::make('current_password')
                ->password()
                ->revealable()
                ->required()
                ->rule(new CheckOtpExpiredRule($authUser))
                ->validationAttribute(static::trans('fields.current_password.validation_attribute'));
        }

        // Fallback nel caso l'utente non sia del tipo corretto
        return TextInput::make('current_password')
            ->password()
            ->revealable()
            ->required()
            ->validationAttribute(static::trans('fields.current_password.validation_attribute'));
    }

    /*
    protected function getPasswordFormComponent(): Component
    {
        $validation_messages = __('user::validation');

        return TextInput::make('password')
            ->password()
            // ->revealable(filament()->arePasswordsRevealable())
            ->revealable()
            ->required()
            ->rule(PasswordRule::default())
            ->same('passwordConfirmation')
            ->validationMessages($validation_messages)
            ->validationAttribute(static::trans('fields.password.validation_attribute'));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->password()
            // ->revealable(filament()->arePasswordsRevealable())
            ->revealable()
            ->required()
            ->dehydrated(false);
    }
    */

    /**
     * @return array<Action|ActionGroup>
     */
    protected function getFormActions(): array
    {
        return [
            $this->getResetPasswordFormAction(),
        ];
    }
}
