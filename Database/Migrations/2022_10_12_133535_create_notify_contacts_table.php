<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Notify\Models\Contact;
use Modules\Xot\Database\Migrations\XotBaseMigration;

<<<<<<< HEAD
return new class() extends XotBaseMigration
{
=======
return new class () extends XotBaseMigration {
>>>>>>> 5547ac5 (up)
    protected ?string $model_class = Contact::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->increments('id');
                $table->uuidMorphs('model');
                $table->string('contact_type')->nullable();
                $table->string('value')->nullable();
                $table->integer('user_id')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
                $table->string('updated_by')->nullable();
                $table->string('created_by')->nullable();
            }
        );
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('token')) {
                    $table->string('token')->nullable();
                }
            }
        );
    }
};
