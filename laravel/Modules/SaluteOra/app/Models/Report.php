<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Modules\User\Models\BaseProfile;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Enums\DayFrequencyEnum;
use Modules\SaluteOra\Enums\MedicalConditionEnum;
use Modules\SaluteOra\Enums\OccurrenceFrequencyEnum;


/**
 * Modello Report.
 *
 * @property int $id
 * @property int $patient_id
 * @property int $appointment_id
 * @property int $doctor_id
 * @property string $status
 * @property bool $has_mouth_or_teeth_pain
 * @property string $mouth_teeth_pain_frequency
 * @property int $pregnancy_month
 * @property int $pregnancy_week
 * @property string $teeth_brushing_frequency
 * @property bool $smokes
 * @property bool $visits_dentist_yearly
 * @property bool $has_diseases
 * @property array<int, MedicalConditionEnum> $specify_diseases
 * @property bool $follows_diet_rules
 * @property bool $uses_asl_clinic_for_dental_care
 * @property bool $missing_teeth
 * @property array $specify_missing_teeth
 * @property string|null $more_info_missing_teeth
 * @property bool $decayed_teeth
 * @property array $specify_decayed_teeth
 * @property string|null $more_info_decayed_teeth
 * @property bool $has_fixed_prosthesis_or_implants
 * @property array $specify_prosthesis_or_implants
 * @property string|null $more_info_prosthesis
 * @property bool $has_tartar
 * @property array $specify_tartar
 * @property string|null $more_info_tartar
 * @property bool $has_plaque
 * @property array $specify_plaque
 * @property string|null $more_info_plaque
 * @property bool $needs_more_dental_care
 * @property string|null $further_notes
 * @property string|null $invoice
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Modules\SaluteOra\Models\Patient|null $patient
 * @property-read \Modules\SaluteOra\Models\Doctor|null $doctor
 * @property-read \Modules\SaluteOra\Models\Appointment|null $appointment
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