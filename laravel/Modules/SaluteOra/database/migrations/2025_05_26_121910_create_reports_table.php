<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\SaluteOra\Models\Studio;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('patient_id',36)->index()->nullable();
                $table->boolean('has_mouth_or_teeth_pain')->comment('Ha sofferto di dolore a bocca o denti negli ultimi 12 mesi');
                $table->unsignedTinyInteger('pregnancy_month')->nullable()->comment('Mese Gravidanza');
                $table->unsignedTinyInteger('pregnancy_week')->nullable()->comment('Settimana Gravidanza');
                $table->string('teeth_brushing_frequency')->nullable()->comment('Numero di volte in cui si lava i denti');
                $table->boolean('smokes')->comment('Fuma');
                $table->boolean('visits_dentist_yearly')->comment('Si reca dal dentista almeno una volta l\'anno');
                $table->boolean('has_diseases')->comment('È affetta da qualche malattia');
                $table->string('specify_diseases')->nullable()->comment('Se sì, specificare');
                $table->boolean('follows_diet_rules')->comment('Segue regole di alimentazione');
                $table->boolean('uses_asl_clinic_for_dental_care')->comment('In caso di necessità si rivolge ad ambulatorio ASL?');
                $table->boolean('missing_teeth')->comment('Ha denti mancanti?');
                $table->string('specify_missing_teeth')->nullable()->comment('Se sì, specificare');
                $table->text('more_info_missing_teeth')->nullable()->comment('Specifica ulteriore');
                $table->boolean('decayed_teeth')->comment('Ha denti cariati?');
                $table->string('specify_decayed_teeth')->nullable()->comment('Se sì, specificare');
                $table->text('more_info_decayed_teeth')->nullable()->comment('Specifica ulteriore');
                $table->boolean('has_fixed_prosthesis_or_implants')->comment('Ha protesi fissa o impianti?');
                $table->string('specify_prosthesis_or_implants')->nullable()->comment('Se sì, specificare');
                $table->text('more_info_prosthesis')->nullable()->comment('Specifica ulteriore');
                $table->boolean('has_tartar')->comment('Ha tartaro?');
                $table->string('specify_tartar')->nullable()->comment('Se sì, specificare');
                $table->text('more_info_tartar')->nullable()->comment('Specifica ulteriore');
                $table->boolean('has_plaque')->comment('Ha placca?');
                $table->string('specify_plaque')->nullable()->comment('Se sì, specificare');
                $table->text('more_info_plaque')->nullable()->comment('Specifica ulteriore');
                $table->boolean('needs_more_dental_care')->comment('La Paziente necessita di ulteriori cure odontoiatriche?');
                $table->text('further_notes')->nullable()->comment('Inserisci ulteriori specifiche');
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if(!$this->hasColumn('appointment_id')){
                    $table->integer('appointment_id')->index()->nullable();
                }
                if(!$this->hasColumn('patient_id')){
                    $table->string('patient_id',36)->index()->nullable();
                }

                if(!$this->hasColumn('mouth_teeth_pain_frequency')){
                    $table->string('mouth_teeth_pain_frequency'); //quanto spesso
                }
               
                if(!$this->hasColumn('has_mouth_or_teeth_pain')){
                    $table->boolean('has_mouth_or_teeth_pain')->comment('Ha sofferto di dolore a bocca o denti negli ultimi 12 mesi');
                }
                if(!$this->hasColumn('pregnancy_month')){
                $table->unsignedTinyInteger('pregnancy_month')->nullable()->comment('Mese Gravidanza');
                }
                if(!$this->hasColumn('pregnancy_week')){
                    $table->unsignedTinyInteger('pregnancy_week')->nullable()->comment('Settimana Gravidanza');
                }
                if(!$this->hasColumn('teeth_brushing_frequency')){
                $table->string('teeth_brushing_frequency')->nullable()->comment('Numero di volte in cui si lava i denti');
                }
                if(!$this->hasColumn('smokes')){
                $table->boolean('smokes')->comment('Fuma');
                }
                if(!$this->hasColumn('visits_dentist_yearly')){
                $table->boolean('visits_dentist_yearly')->comment('Si reca dal dentista almeno una volta l\'anno');
                }
                if(!$this->hasColumn('has_diseases')){
                    $table->boolean('has_diseases')->comment('È affetta da qualche malattia');
                }
                if(!$this->hasColumn('specify_diseases')){
                    $table->string('specify_diseases')->nullable()->comment('Se sì, specificare');
                }
                if(!$this->hasColumn('follows_diet_rules')){
                    $table->boolean('follows_diet_rules')->comment('Segue regole di alimentazione');
                }
                if(!$this->hasColumn('uses_asl_clinic_for_dental_care')){
                    $table->boolean('uses_asl_clinic_for_dental_care')->comment('In caso di necessità si rivolge ad ambulatorio ASL?');
                }
                if(!$this->hasColumn('missing_teeth')){
                    $table->boolean('missing_teeth')->comment('Ha denti mancanti?');
                }
                if(!$this->hasColumn('specify_missing_teeth')){
                    $table->string('specify_missing_teeth')->nullable()->comment('Se sì, specificare');
                }
                if(!$this->hasColumn('more_info_missing_teeth')){
                    $table->text('more_info_missing_teeth')->nullable()->comment('Specifica ulteriore');
                }
                if(!$this->hasColumn('decayed_teeth')){
                    $table->boolean('decayed_teeth')->comment('Ha denti cariati?');
                }
                if(!$this->hasColumn('specify_decayed_teeth')){
                    $table->string('specify_decayed_teeth')->nullable()->comment('Se sì, specificare');
                }
                if(!$this->hasColumn('more_info_decayed_teeth')){
                    $table->text('more_info_decayed_teeth')->nullable()->comment('Specifica ulteriore');
                }
                if(!$this->hasColumn('has_fixed_prosthesis_or_implants')){
                    $table->boolean('has_fixed_prosthesis_or_implants')->comment('Ha protesi fissa o impianti?');
                }
                if(!$this->hasColumn('specify_prosthesis_or_implants')){
                    $table->string('specify_prosthesis_or_implants')->nullable()->comment('Se sì, specificare');
                }
                if(!$this->hasColumn('more_info_prosthesis')){
                    $table->text('more_info_prosthesis')->nullable()->comment('Specifica ulteriore');
                }
                if(!$this->hasColumn('has_tartar')){
                    $table->boolean('has_tartar')->comment('Ha tartaro?');
                }
                if(!$this->hasColumn('specify_tartar')){
                    $table->string('specify_tartar')->nullable()->comment('Se sì, specificare');
                }
                if(!$this->hasColumn('more_info_tartar')){
                    $table->text('more_info_tartar')->nullable()->comment('Specifica ulteriore');
                }
                if(!$this->hasColumn('has_plaque')){
                    $table->boolean('has_plaque')->comment('Ha placca?');
                }
                if(!$this->hasColumn('specify_plaque')){
                    $table->string('specify_plaque')->nullable()->comment('Se sì, specificare');
                }
                if(!$this->hasColumn('more_info_plaque')){
                    $table->text('more_info_plaque')->nullable()->comment('Specifica ulteriore');
                }
                if(!$this->hasColumn('needs_more_dental_care')){
                    $table->boolean('needs_more_dental_care')->comment('La Paziente necessita di ulteriori cure odontoiatriche?');
                }
                if(!$this->hasColumn('further_notes')){
                    $table->text('further_notes')->nullable()->comment('Inserisci ulteriori specifiche');
                }
                
                if(!$this->hasColumn('invoice')){
                    $table->string('invoice')->nullable()->comment('File fattura');
                }
                
                // Aggiunta dei timestamp e soft delete
                $this->updateTimestamps($table, true);
            }
        );
    }
};