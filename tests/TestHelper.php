<?php

declare(strict_types=1);

namespace Modules\Cms\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Cms\Models\Module;
<<<<<<< HEAD
use Modules\User\Models\User;
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;
=======
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;
use Modules\User\Models\User;
>>>>>>> bc33217 (.)
use Tests\CreatesApplication;

abstract class TestHelper extends BaseTestCase
{
    //use CreatesApplication;

    // in User
    public function getSuperAdminUser()
    {
        return User::role('super-admin')->first();
    }

    // in User
    public function getNoSuperAdminUser()
    {
        return User::all()
            ->map(function ($item) {
<<<<<<< HEAD
                if (!$item->hasRole('super-admin')) {
                    return $item;
                }
            })
            ->first();
=======
                if (! $item->hasRole('super-admin')) {
                    return $item;
                }
            })->first();
>>>>>>> bc33217 (.)
    }

    // in Tenant o Cms
    public function getModuleNameLists()
    {
<<<<<<< HEAD
        return collect(app(Module::class)->getRows())->pluck('name')->all();
=======
        return collect(app(Module::class)
            ->getRows())
            ->pluck('name')
            ->all();
>>>>>>> bc33217 (.)
    }

    // in Tenant o Cms
    public function getMainAdminNavigationUrlItems()
    {
        return $item_navs = collect(app(GetModulesNavigationItems::class)->execute())
<<<<<<< HEAD
            ->map(fn($item) => $item->getUrl());
=======
            ->map(fn ($item) => $item->getUrl());
>>>>>>> bc33217 (.)
    }

    // in Tenant o Cms
    public function getUserNavigationItemUrlRoles($user)
    {
<<<<<<< HEAD
        return $role_names = $user
            ->getRoleNames()
            ->map(function ($item) {
                if ('super-admin' !== $item) {
                    return '/' . mb_substr($item, 0, -7) . '/admin';
                }
            })
            ->filter(fn($value): bool => !is_null($value));
=======
        return $role_names = $user->getRoleNames()->map(function ($item) {
            if ('super-admin' !== $item) {
                return '/'.mb_substr($item, 0, -7).'/admin';
            }
        })->filter(fn ($value): bool => ! is_null($value));
>>>>>>> bc33217 (.)
    }
}
