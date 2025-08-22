#!/usr/bin/env bash
set -euo pipefail

PHP="php"
MODULE="SaluteOra"
ROOT="laravel/Modules/${MODULE}"
MODELS_DIR="${ROOT}/app/Models"
FACTORIES_DIR="${ROOT}/database/factories"
SEEDERS_DIR="${ROOT}/database/seeders"

mkdir -p "${SEEDERS_DIR}"

# Helper: normalize class name to seeder name
seeder_name_for() {
  local model="$1"
  echo "${model}Seeder"
}

# Track generated seeders for master registry
GENERATED_SEEDERS=()

# Scan models
while IFS= read -r -d '' modelFile; do
  model="$(basename "$modelFile" .php)"

  # Skip non-real models
  case "$model" in
    BaseModel|BasePivot) continue ;;
  esac
  # Skip policy classes
  if echo "$modelFile" | grep -q "/Policies/"; then continue; fi

  fqcn="Modules\\${MODULE}\\Models\\${model}"

  # 1) Ensure factory exists (one per model)
  factoryPath="${FACTORIES_DIR}/${model}Factory.php"
  if [[ ! -f "$factoryPath" ]]; then
    echo "[MAKE FACTORY] ${MODULE} -> ${model}Factory (model=${fqcn})"
    ${PHP} laravel/artisan module:make-factory "${model}Factory" "${MODULE}" --model="${fqcn}" || {
      echo "[WARN] Failed factory create for ${fqcn}"
    }
  else
    echo "[SKIP FACTORY EXISTS] ${factoryPath}"
  fi

  # 2) Ensure seeder exists (one per model)
  seederName="$(seeder_name_for "$model")"
  seederPath="${SEEDERS_DIR}/${seederName}.php"
  if [[ ! -f "$seederPath" ]]; then
    echo "[MAKE SEEDER] ${seederName}"
    ${PHP} laravel/artisan module:make-seed "${seederName}" "${MODULE}" >/dev/null 2>&1 || true

    # Overwrite content with robust template
    cat > "${seederPath}" <<PHP
<?php

declare(strict_types=1);

namespace Modules\\${MODULE}\\Database\\Seeders;

use Illuminate\\Database\\Seeder;
use Illuminate\\Database\\Console\\Seeds\\WithoutModelEvents;
use Illuminate\\Support\\Facades\\DB;
use Modules\\${MODULE}\\Models\\${model};

class ${seederName} extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Use FK off only for heavy inserts (MySQL); harmless elsewhere.
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } catch (\Throwable $e) {}

        // If factory exists, seed many records; otherwise skip silently.
        if (method_exists(${model}::class, 'factory')) {
            // Default counts; tune below per model if needed.
            $count = match ('${model}') {
                // Heavier entities
                'Appointment' => 1000,
                'User' => 500,
                'Studio' => 120,
                // Pivot-like or lighter
                'DoctorStudio', 'PatientStudio', 'StudioUser', 'TeamUser', 'AdminStudio', 'AdminTeam', 'DoctorTeam', 'PatientTeam' => 300,
                default => 200,
            };

            // Wrap to avoid stopping whole seeding on a single failure
            try {
                ${model}::factory()->count($count)->create();
                $this->command?->info("\xE2\x9C\x93 Seeded ${model} x{$count}");
            } catch (\Throwable $e) {
                $this->command?->warn("Skip ${model}: " . $e->getMessage());
            }
        } else {
            $this->command?->warn("No factory for ${model}, seeding skipped.");
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } catch (\Throwable $e) {}
    }
}
PHP
  else
    echo "[SKIP SEEDER EXISTS] ${seederPath}"
  fi

  GENERATED_SEEDERS+=("${seederName}")

done < <(find "${MODELS_DIR}" -type f -name "*.php" -print0)

# 3) Create a master models seeder that calls all model seeders
MASTER="${SEEDERS_DIR}/SaluteOraModelsSeeder.php"
echo "[WRITE MASTER] ${MASTER}"
cat > "${MASTER}" <<PHP
<?php

declare(strict_types=1);

namespace Modules\\${MODULE}\\Database\\Seeders;

use Illuminate\\Database\\Seeder;
use Illuminate\\Database\\Console\\Seeds\\WithoutModelEvents;

class SaluteOraModelsSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
$(for s in "${GENERATED_SEEDERS[@]}"; do echo "            \\Modules\\${MODULE}\\Database\\Seeders\\${s}::class,"; done)
        ]);
    }
}
PHP

echo "[DONE] Factories + per-model seeders + master SaluteOraModelsSeeder generated."
