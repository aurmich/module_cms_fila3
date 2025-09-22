<?php

/**
 * Tinker commands to generate 100 records for each business model
 * Run with: php artisan tinker < tinker_commands.php
 */

// Module: SaluteOra
echo "Generating Patient...";
\Modules\SaluteOra\Models\Patient::factory()->count(100)->create();
echo "✅ Patient completed\n";

echo "Generating Doctor...";
\Modules\SaluteOra\Models\Doctor::factory()->count(100)->create();
echo "✅ Doctor completed\n";

echo "Generating Studio...";
\Modules\SaluteOra\Models\Studio::factory()->count(100)->create();
echo "✅ Studio completed\n";

echo "Generating Appointment...";
\Modules\SaluteOra\Models\Appointment::factory()->count(100)->create();
echo "✅ Appointment completed\n";

echo "Generating Report...";
\Modules\SaluteOra\Models\Report::factory()->count(100)->create();
echo "✅ Report completed\n";

echo "Generating Profile...";
\Modules\SaluteOra\Models\Profile::factory()->count(100)->create();
echo "✅ Profile completed\n";

echo "Generating User...";
\Modules\SaluteOra\Models\User::factory()->count(100)->create();
echo "✅ User completed\n";

