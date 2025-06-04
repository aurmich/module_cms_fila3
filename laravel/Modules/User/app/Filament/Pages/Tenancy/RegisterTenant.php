<?php

declare(strict_types=1);

namespace Modules\User\Filament\Pages\Tenancy;

use Filament\Forms\Form;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Modules\Xot\Datas\XotData;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Modules\User\Contracts\TenantContract;
use Modules\Xot\Filament\Traits\TransTrait;
use Filament\Pages\Tenancy\RegisterTenant as BaseRegisterTenant;

class RegisterTenant extends BaseRegisterTenant
{
    use TransTrait;

    public string $resource;

    public static function getLabel(): string
    {
        $tenantClass = XotData::make()->getTenantClass();
        $func=Str::of(__FUNCTION__)->snake()->toString();
        if(Str::startsWith($func,'get_')){
            $func=Str::of($func)->after('get_')->toString();
        }
        $key=Str::of(class_basename(__CLASS__))->snake()->prepend('actions.')->append('.'.$func)->toString();
        $str= static::transClass($tenantClass,$key);

        return $str;
    }



    public function form(Form $form): Form
    {
        $tenantClass = XotData::make()->getTenantClass();
        $resource=Str::of($tenantClass)
            ->replace('\Models\\','\Filament\Resources\\')
            ->append('Resource')
            ->toString();
        $this->resource=$resource;
        return $form
            ->schema($this->getFormSchema());
    }

    public function getFormSchema(): array
    {
        return $this->resource::getFormSchema();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function handleRegistration(array $data): Model
    {
        $tenantClass = XotData::make()->getTenantClass();

        $tenant = $tenantClass::create($data);
        Assert::implementsInterface($tenant, TenantContract::class);

        $tenant->users()
            ->attach(auth()->user());

        return $tenant;
    }
}
