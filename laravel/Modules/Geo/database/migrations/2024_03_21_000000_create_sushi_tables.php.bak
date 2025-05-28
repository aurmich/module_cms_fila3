<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comuni', function (Blueprint $table) {
            $table->id();
            $table->string('regione');
            $table->string('provincia');
            $table->string('comune');
            $table->string('cap');
            $table->float('lat');
            $table->float('lng');
            $table->timestamps();

            $table->index('regione');
            $table->index('provincia');
            $table->index('comune');
            $table->index('cap');
            $table->index(['lat', 'lng']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comuni');
    }
}; 