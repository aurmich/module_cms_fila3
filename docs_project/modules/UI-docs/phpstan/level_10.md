# PHPStan Report - Livello 10

## Errori rilevati
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Actions/Icon/GetAllIconsAction.php: Method Modules\UI\Actions\Icon\GetAllIconsAction::execute() should return array<string, array<string>> but returns array. (line 43)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Enums/TableLayoutEnum.php: Method Modules\UI\Enums\TableLayoutEnum::getTableColumns() should return array<Filament\Tables\Columns\Column|Filament\Tables\Columns\ColumnGroup|Filament\Tables\Columns\Layout\Component> but returns array. (line 101)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Filament/Blocks/Image.php: Parameter #1 $options of method Filament\Forms\Components\Select::options() expects array<array<string>|string>|Closure|Illuminate\Contracts\Support\Arrayable|string|null, array given. (line 26)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Filament/Blocks/Image.php: Trying to invoke mixed but it's not a callable. (line 27)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Filament/Blocks/Title.php: Trying to invoke mixed but it's not a callable. (line 39)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Filament/Forms/Components/AddressField.php: Cannot call method first() on mixed. (line 79)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Filament/Forms/Components/AddressField.php: Cannot call method update() on mixed. (line 80)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Filament/Forms/Components/AddressField.php: Cannot call method updateOrCreate() on mixed. (line 82)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Filament/Forms/Components/IconPicker.php: Parameter #1 $keys of function array_combine expects array<int|string>, array given. (line 45)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Http/Livewire/DarkModeSwitcher.php: Parameter #1 $view of function view expects view-string|null, string given. (line 29)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/Providers/UIServiceProvider.php: Parameter #1 $path of static method Illuminate\Support\Facades\Blade::anonymousComponentPath() expects string, mixed given. (line 36)
* /var/www/html/_bases/base_quaeris_fila3_mono/laravel/Modules/UI/app/View/Components/Render/Block.php: Parameter #2 $data of function view expects array<string, mixed>|Illuminate\Contracts\Support\Arrayable<(int|string), mixed>, mixed given. (line 56)

## Soluzioni proposte

> TODO: descrivere soluzioni architetturali e funzionali

## Collegamenti tra versioni di level_10.md
* [level_10.md](laravel/Modules/Gdpr/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/Notify/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/Xot/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/User/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/UI/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/Lang/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/Job/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/Media/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/Tenant/docs/phpstan/level_10.md)
* [level_10.md](laravel/Modules/Activity/docs/phpstan/level_10.md)

