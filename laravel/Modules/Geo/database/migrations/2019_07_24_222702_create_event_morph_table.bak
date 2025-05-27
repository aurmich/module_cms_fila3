<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- models -----
use Modules\Geo\Models\EventMorph as MyModel;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateEventMorphTable.
 */
class CreateEventMorphTable extends XotBaseMigration {
    /*
    public function getTable(): string {
        return with(new MyModel())->getTable();
    }
    */
    /**
     * db up.
     *
     * @return void
     */
    public function up() {
        // ----- create -----
        $this->tableCreate(
            function (Blueprint $table) {
                $table->increments('id');
                $table->nullableMorphs('post');
                $table->nullableMorphs('related');
                $table->integer('user_id')->nullable()->index();

                $table->string('note')->nullable();

                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->string('deleted_by')->nullable();
                $table->timestamps();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table) {
                if ($this->hasColumn('related_id')) {
                    $table->renameColumn('related_id', 'event_id');
                }
                if ($this->hasColumn('auth_user_id')) {
                    $table->renameColumn('auth_user_id', 'user_id');
                }
            }
        );
    }
}
