<?php

namespace Modules\Cms\Tests;

use Modules\User\Models\User;
use Tests\CreatesApplication;
use Modules\Cms\Models\Module;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Actions\Filament\GetModulesNavigationItems;

abstract class TestHelper extends BaseTestCase
{
    use CreatesApplication;

    public function getSuperAdminUser(){
        return User::role('super-admin')->first();
    }

    public function getNoSuperAdminUser(){
        return User::all()
            ->map(function($item){
                if(!$item->hasRole('super-admin')){
                    return $item;
                }
            })->first();
    }

    public function getModuleNameLists(){
        return collect(app(Module::class)
            ->getRows())
            ->pluck('name')
            ->all();
    }

    public function getMainAdminNavigationItems(){
        return $item_navs = collect(app(GetModulesNavigationItems::class)->execute())
                ->map(function($item){
                    return $item->getLabel();
                });
    }

    public function getUserNavigationItem($user){
        return $role_names = $user->getRoleNames()->map(function($item){
            if($item != 'super-admin'){
                // dddx(substr(ucfirst($item), 0, -7));
                return substr(ucfirst($item), 0, -7);
            }
        })->filter(function ($value) { return !is_null($value); });
    }
}