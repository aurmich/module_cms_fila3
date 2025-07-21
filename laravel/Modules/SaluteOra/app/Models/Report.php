<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Modules\User\Models\BaseProfile;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Enums\OccurrenceFrequencyEnum;
use Modules\SaluteOra\Enums\DayFrequencyEnum;


/**
 * Modello Report.
 *
 * @property array<int, MedicalConditionEnum> $specify_diseases
 */
class Report extends BaseModel{
    
     /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id', // ID
        'patient_id', // ID Paziente
        'appointment_id', // ID Appuntamento
        'has_mouth_or_teeth_pain', // Ha sofferto di dolore a bocca o denti negli ultimi 12 mesi
        'mouth_teeth_pain_frequency', // Quanto spesso
        'pregnancy_month', // Mese Gravidanza
        'pregnancy_week', // Settimana Gravidanza
        'teeth_brushing_frequency', // Numero di volte in cui si lava i denti
        'smokes', // Fuma
        'visits_dentist_yearly', // Si reca dal dentista almeno una volta l'anno
        'has_diseases', // È affetta da qualche malattia
        'specify_diseases', // Se sì, specificare
        'follows_diet_rules', // Segue regole di alimentazione
        'uses_asl_clinic_for_dental_care', // In caso di necessità si rivolge ad ambulatorio ASL?
        'missing_teeth', // Ha denti mancanti?
        'specify_missing_teeth', // Se sì, specificare
        'more_info_missing_teeth', // Specifica ulteriore
        'decayed_teeth', // Ha denti cariati?
        'specify_decayed_teeth', // Se sì, specificare
        'more_info_decayed_teeth', // Specifica ulteriore
        'has_fixed_prosthesis_or_implants', // Ha protesi fissa o impianti?
        'specify_prosthesis_or_implants', // Se sì, specificare
        'more_info_prosthesis', // Specifica ulteriore
        'has_tartar', // Ha tartaro?
        'specify_tartar', // Se sì, specificare
        'more_info_tartar', // Specifica ulteriore
        'has_plaque', // Ha placca?
        'specify_plaque', // Se sì, specificare
        'more_info_plaque', // Specifica ulteriore
        'needs_more_dental_care', // La Paziente necessita di ulteriori cure odontoiatriche?
        'further_notes', // Inserisci ulteriori specifiche

        'invoice', //file fattura
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string|class-string>
     */
    public function casts(): array 
    {
        return [
            // Boolean casts
            'has_mouth_or_teeth_pain' => 'boolean',
            'smokes' => 'boolean',
            'visits_dentist_yearly' => 'boolean',
            'has_diseases' => 'boolean',
            'follows_diet_rules' => 'boolean',
            'uses_asl_clinic_for_dental_care' => 'boolean',
            'missing_teeth' => 'boolean',
            'decayed_teeth' => 'boolean',
            'has_fixed_prosthesis_or_implants' => 'boolean',
            'has_tartar' => 'boolean',
            'has_plaque' => 'boolean',
            'needs_more_dental_care' => 'boolean',
            
            // Enum casts - these use PHP 8.1+ backed enums (string-based)
            'mouth_teeth_pain_frequency' => OccurrenceFrequencyEnum::class,
            'teeth_brushing_frequency' => DayFrequencyEnum::class,
            'specify_prosthesis_or_implants' => 'array', // Stored as JSON array of ToothFDIEnum values
            'specify_diseases' => 'array', // Array of MedicalConditionEnum values
            'specify_missing_teeth' => 'array', // Array of ToothFDIEnum values
            'specify_decayed_teeth' => 'array', // Array of ToothFDIEnum values
            'specify_prosthesis_or_implants' => 'array', // Array of ToothFDIEnum values
            'specify_tartar' => 'array', // Array of ToothFDIEnum values
            'specify_plaque' => 'array', // Array of ToothFDIEnum values
            
            // Integer casts
            'pregnancy_month' => 'integer',
            'pregnancy_week' => 'integer',
        ];
    }
}