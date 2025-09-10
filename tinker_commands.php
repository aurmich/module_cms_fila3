<?php

/**
 * Tinker commands to generate 100 records for each business model
 * Run with: php artisan tinker < tinker_commands.php
 */

// Module: TechPlanner
echo "Generating Patient...";
if (class_exists('\Modules\TechPlanner\Models\Patient')) {
    \Modules\TechPlanner\Models\Patient::factory()->count(100)->create();
    echo "✅ Patient completed\n";
} else {
    echo "❌ Patient class not found\n";
}

echo "Generating Doctor...";
if (class_exists('\Modules\TechPlanner\Models\Doctor')) {
    \Modules\TechPlanner\Models\Doctor::factory()->count(100)->create();
    echo "✅ Doctor completed\n";
} else {
    echo "❌ Doctor class not found\n";
}

echo "Generating Studio...";
if (class_exists('\Modules\TechPlanner\Models\Studio')) {
    \Modules\TechPlanner\Models\Studio::factory()->count(100)->create();
    echo "✅ Studio completed\n";
} else {
    echo "❌ Studio class not found\n";
}

echo "Generating Appointment...";
if (class_exists('\Modules\TechPlanner\Models\Appointment') && method_exists('\Modules\TechPlanner\Models\Appointment', 'factory')) {
    \Modules\TechPlanner\Models\Appointment::factory()->count(100)->create();
    echo "✅ Appointment completed\n";
} else {
    echo "❌ Appointment class or factory method not found\n";
}

echo "Generating Report...";
if (class_exists('\Modules\TechPlanner\Models\Report')) {
    \Modules\TechPlanner\Models\Report::factory()->count(100)->create();
    echo "✅ Report completed\n";
} else {
    echo "❌ Report class not found\n";
}

echo "Generating Profile...";
if (class_exists('\Modules\TechPlanner\Models\Profile')) {
    \Modules\TechPlanner\Models\Profile::factory()->count(100)->create();
    echo "✅ Profile completed\n";
} else {
    echo "❌ Profile class not found\n";
}

echo "Generating User...";
if (class_exists('\Modules\TechPlanner\Models\User')) {
    \Modules\TechPlanner\Models\User::factory()->count(100)->create();
    echo "✅ User completed\n";
} else {
    echo "❌ User class not found\n";
}

