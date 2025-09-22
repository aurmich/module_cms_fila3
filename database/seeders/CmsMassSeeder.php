<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

<<<<<<< HEAD
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Cms\Models\Conf;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Module;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;
=======
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Module;
use Modules\Cms\Models\Conf;
>>>>>>> bc33217 (.)

/**
 * Seeder per creare grandi quantità di dati per il modulo Cms.
 */
class CmsMassSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Inizializzazione seeding di massa per modulo Cms...');
<<<<<<< HEAD

        $startTime = microtime(true);

        try {
            // 1. Creazione moduli CMS
            $this->createCmsModules();

            // 2. Creazione sezioni
            $this->createSections();

            // 3. Creazione pagine
            $this->createPages();

            // 4. Creazione contenuti delle pagine
            $this->createPageContents();

            // 5. Creazione menu
            $this->createMenus();

            // 6. Creazione configurazioni
            $this->createConfigurations();

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            $this->command->info("🎉 Seeding modulo Cms completato in {$executionTime} secondi!");
            $this->displaySummary();
        } catch (\Exception $e) {
            $this->command->error('❌ Errore durante il seeding: ' . $e->getMessage());
            throw $e;
        }
    }

=======
        
        $startTime = microtime(true);
        
        try {
            // 1. Creazione moduli CMS
            $this->createCmsModules();
            
            // 2. Creazione sezioni
            $this->createSections();
            
            // 3. Creazione pagine
            $this->createPages();
            
            // 4. Creazione contenuti delle pagine
            $this->createPageContents();
            
            // 5. Creazione menu
            $this->createMenus();
            
            // 6. Creazione configurazioni
            $this->createConfigurations();
            
            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);
            
            $this->command->info("🎉 Seeding modulo Cms completato in {$executionTime} secondi!");
            $this->displaySummary();
            
        } catch (\Exception $e) {
            $this->command->error("❌ Errore durante il seeding: " . $e->getMessage());
            throw $e;
        }
    }
    
>>>>>>> bc33217 (.)
    /**
     * Crea moduli CMS.
     */
    private function createCmsModules(): void
    {
        $this->command->info('🔧 Creazione moduli CMS...');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        // Crea 20 moduli CMS
        $modules = Module::factory(20)->create([
            'is_active' => true,
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
<<<<<<< HEAD

        $this->command->info('✅ Creati ' . $modules->count() . ' moduli CMS');
    }

=======
        
        $this->command->info("✅ Creati " . $modules->count() . " moduli CMS");
    }
    
>>>>>>> bc33217 (.)
    /**
     * Crea sezioni.
     */
    private function createSections(): void
    {
        $this->command->info('📑 Creazione sezioni...');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        // Crea 100 sezioni
        $sections = Section::factory(100)->create([
            'is_active' => true,
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
<<<<<<< HEAD

        $this->command->info('✅ Create ' . $sections->count() . ' sezioni');
    }

=======
        
        $this->command->info("✅ Create " . $sections->count() . " sezioni");
    }
    
>>>>>>> bc33217 (.)
    /**
     * Crea pagine.
     */
    private function createPages(): void
    {
        $this->command->info('📄 Creazione pagine...');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        // Crea 500 pagine
        $pages = Page::factory(500)->create([
            'is_active' => true,
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
<<<<<<< HEAD

        $this->command->info('✅ Create ' . $pages->count() . ' pagine');
    }

=======
        
        $this->command->info("✅ Create " . $pages->count() . " pagine");
    }
    
>>>>>>> bc33217 (.)
    /**
     * Crea contenuti delle pagine.
     */
    private function createPageContents(): void
    {
        $this->command->info('📝 Creazione contenuti delle pagine...');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        // Crea 1000 contenuti di pagina
        $contents = PageContent::factory(1000)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
<<<<<<< HEAD

        $this->command->info('✅ Creati ' . $contents->count() . ' contenuti di pagina');
    }

=======
        
        $this->command->info("✅ Creati " . $contents->count() . " contenuti di pagina");
    }
    
>>>>>>> bc33217 (.)
    /**
     * Crea menu.
     */
    private function createMenus(): void
    {
        $this->command->info('🍽️ Creazione menu...');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        // Crea 50 menu
        $menus = Menu::factory(50)->create([
            'is_active' => true,
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
<<<<<<< HEAD

        $this->command->info('✅ Creati ' . $menus->count() . ' menu');
    }

=======
        
        $this->command->info("✅ Creati " . $menus->count() . " menu");
    }
    
>>>>>>> bc33217 (.)
    /**
     * Crea configurazioni.
     */
    private function createConfigurations(): void
    {
        $this->command->info('⚙️ Creazione configurazioni...');
<<<<<<< HEAD

        // Conf è un modello Sushi che ottiene i dati da TenantService::getConfigNames()
        // Non supporta factories, i dati sono caricati dinamicamente
        $configs = Conf::all();

        $this->command->info('✅ Caricati ' . $configs->count() . ' configurazioni da Sushi');
    }

=======
        
        // Conf è un modello Sushi che ottiene i dati da TenantService::getConfigNames()
        // Non supporta factories, i dati sono caricati dinamicamente
        $configs = Conf::all();
        
        $this->command->info("✅ Caricati " . $configs->count() . " configurazioni da Sushi");
    }
    
>>>>>>> bc33217 (.)
    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        $this->command->info('📊 RIASSUNTO DATI CREATI PER MODULO CMS:');
        $this->command->info('┌─────────────────────────────────────┐');
<<<<<<< HEAD

=======
        
>>>>>>> bc33217 (.)
        try {
            // Conta moduli
            $totalModules = Module::count();
            $activeModules = Module::where('is_active', true)->count();
<<<<<<< HEAD

            $this->command->info('│ 🔧 Moduli totali:             ' .
            str_pad((string) $totalModules, 6, ' ', STR_PAD_LEFT) .
                ' │');
            $this->command->info('│    - Attivi:                  ' .
            str_pad((string) $activeModules, 6, ' ', STR_PAD_LEFT) .
                ' │');

            // Conta sezioni
            $totalSections = Section::count();
            $activeSections = Section::where('is_active', true)->count();

            $this->command->info('│ 📑 Sezioni totali:            ' .
            str_pad((string) $totalSections, 6, ' ', STR_PAD_LEFT) .
                ' │');
            $this->command->info('│    - Attive:                  ' .
            str_pad((string) $activeSections, 6, ' ', STR_PAD_LEFT) .
                ' │');

            // Conta pagine
            $totalPages = Page::count();
            $activePages = Page::where('is_active', true)->count();

            $this->command->info('│ 📄 Pagine totali:             ' .
            str_pad((string) $totalPages, 6, ' ', STR_PAD_LEFT) .
                ' │');
            $this->command->info('│    - Attive:                  ' .
            str_pad((string) $activePages, 6, ' ', STR_PAD_LEFT) .
                ' │');

            // Conta contenuti
            $totalContents = PageContent::count();

            $this->command->info('│ 📝 Contenuti totali:          ' .
            str_pad((string) $totalContents, 6, ' ', STR_PAD_LEFT) .
                ' │');

            // Conta menu
            $totalMenus = Menu::count();
            $activeMenus = Menu::where('is_active', true)->count();

            $this->command->info('│ 🍽️ Menu totali:               ' .
            str_pad((string) $totalMenus, 6, ' ', STR_PAD_LEFT) .
                ' │');
            $this->command->info('│    - Attivi:                  ' .
            str_pad((string) $activeMenus, 6, ' ', STR_PAD_LEFT) .
                ' │');

            // Conta configurazioni
            $totalConfigs = Conf::count();

            $this->command->info('│ ⚙️ Configurazioni totali:     ' .
            str_pad((string) $totalConfigs, 6, ' ', STR_PAD_LEFT) .
                ' │');
        } catch (\Exception $e) {
            $this->command->info('│ ❌ Errore nel conteggio: ' . $e->getMessage());
        }

=======
            
            $this->command->info("│ 🔧 Moduli totali:             " . str_pad((string)$totalModules, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Attivi:                  " . str_pad((string)$activeModules, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta sezioni
            $totalSections = Section::count();
            $activeSections = Section::where('is_active', true)->count();
            
            $this->command->info("│ 📑 Sezioni totali:            " . str_pad((string)$totalSections, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Attive:                  " . str_pad((string)$activeSections, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta pagine
            $totalPages = Page::count();
            $activePages = Page::where('is_active', true)->count();
            
            $this->command->info("│ 📄 Pagine totali:             " . str_pad((string)$totalPages, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Attive:                  " . str_pad((string)$activePages, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta contenuti
            $totalContents = PageContent::count();
            
            $this->command->info("│ 📝 Contenuti totali:          " . str_pad((string)$totalContents, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta menu
            $totalMenus = Menu::count();
            $activeMenus = Menu::where('is_active', true)->count();
            
            $this->command->info("│ 🍽️ Menu totali:               " . str_pad((string)$totalMenus, 6, ' ', STR_PAD_LEFT) . " │");
            $this->command->info("│    - Attivi:                  " . str_pad((string)$activeMenus, 6, ' ', STR_PAD_LEFT) . " │");
            
            // Conta configurazioni
            $totalConfigs = Conf::count();
            
            $this->command->info("│ ⚙️ Configurazioni totali:     " . str_pad((string)$totalConfigs, 6, ' ', STR_PAD_LEFT) . " │");
            
        } catch (\Exception $e) {
            $this->command->info("│ ❌ Errore nel conteggio: " . $e->getMessage());
        }
        
>>>>>>> bc33217 (.)
        $this->command->info('└─────────────────────────────────────┘');
        $this->command->info('');
    }
}
