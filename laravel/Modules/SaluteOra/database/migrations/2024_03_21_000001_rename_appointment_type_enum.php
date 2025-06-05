<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rinominare il file
        $oldPath = base_path('laravel/Modules/SaluteOra/app/Enums/AppointmentType.php');
        $newPath = base_path('laravel/Modules/SaluteOra/app/Enums/AppointmentTypeEnum.php');
        
        if (File::exists($oldPath)) {
            File::move($oldPath, $newPath);
        }
        
        // 2. Aggiornare il contenuto del file
        if (File::exists($newPath)) {
            $content = File::get($newPath);
            $content = str_replace('enum AppointmentType', 'enum AppointmentTypeEnum', $content);
            File::put($newPath, $content);
        }
        
        // 3. Aggiungere l'alias per mantenere la compatibilità
        $aliasPath = base_path('laravel/Modules/SaluteOra/app/Enums/AppointmentType.php');
        File::put($aliasPath, <<<'PHP'
<?php

namespace Modules\SaluteOra\App\Enums;

class_alias(AppointmentTypeEnum::class, 'Modules\\SaluteOra\\App\\Enums\\AppointmentType');
PHP
        );
        
        // 4. Pulire la cache
        Artisan::call('optimize:clear');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Rimuovere l'alias
        $aliasPath = base_path('laravel/Modules/SaluteOra/app/Enums/AppointmentType.php');
        if (File::exists($aliasPath)) {
            File::delete($aliasPath);
        }
        
        // 2. Rinominare il file
        $newPath = base_path('laravel/Modules/SaluteOra/app/Enums/AppointmentTypeEnum.php');
        $oldPath = base_path('laravel/Modules/SaluteOra/app/Enums/AppointmentType.php');
        
        if (File::exists($newPath)) {
            File::move($newPath, $oldPath);
        }
        
        // 3. Aggiornare il contenuto del file
        if (File::exists($oldPath)) {
            $content = File::get($oldPath);
            $content = str_replace('enum AppointmentTypeEnum', 'enum AppointmentType', $content);
            File::put($oldPath, $content);
        }
        
        // 4. Pulire la cache
        Artisan::call('optimize:clear');
    }
}; 