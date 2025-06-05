<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * This migration removes the duplicate geographical tables from the SaluteOra module
 * after the data has been migrated to the Geo module.
 * 
 * WARNING: This migration will drop the tables. Make sure to back up your data
 * and run the GeoDataMigrator seeder before running this migration.
 */
class DropDuplicateGeoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Only drop the tables if they exist and we're not in production
        if (!app()->environment('production')) {
            Schema::dropIfExists('caps');
            Schema::dropIfExists('cities');
            Schema::dropIfExists('provinces');
            Schema::dropIfExists('regions');
        } else {
            // In production, we'll just log that these tables should be removed
            // after verifying the data has been migrated
            \Illuminate\Support\Facades\Log::info('Geographical tables should be removed after verifying data migration to Geo module');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // We don't want to recreate these tables as they should be managed by the Geo module
        // This is a one-way migration
        
        // However, for testing purposes, we can add the table creation code here
        // but it's commented out by default
        
        /*
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 3)->unique();
            $table->timestamps();
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('regions');
            $table->string('name');
            $table->string('code', 3)->unique();
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained('provinces');
            $table->string('name');
            $table->string('code', 6)->unique();
            $table->timestamps();
        });

        Schema::create('caps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('cities');
            $table->string('code', 5);
            $table->timestamps();
        });
        */
    }
}
