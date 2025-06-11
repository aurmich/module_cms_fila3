<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class CreateUserAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $provider, SocialiteUserContract $oauthUser): UserContract
    {
        // Resolve `users` table required attributes
        // from the identity provider
        $userAttributes = app(GetUserModelAttributesFromSocialiteAction::class, [
            'provider' => $provider,
            'oauthUser' => $oauthUser,
        ], );
        // Store the new entity into `users` table
        $userClass = XotData::make()->getUserClass();
        $newlyCreatedUser = $userClass::create([
            'name' => $userAttributes->name,
            'first_name' => $userAttributes->name,
            'last_name' => $userAttributes->last_name,
            'email' => $userAttributes->email,
        ]);
        Assert::implementsInterface($newlyCreatedUser, UserContract::class);
        // Finally, assign the default set of roles
        app(SetDefaultRolesBySocialiteUserAction::class, [
            'provider' => $provider,
            'userModel' => $newlyCreatedUser,
        ])->execute(userModel: $newlyCreatedUser, oauthUser: $oauthUser);
        /** @var UserContract */
        $res = $newlyCreatedUser->refresh();

        return $res;
    }
}
