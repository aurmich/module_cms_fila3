<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Support\Arr;
use Modules\User\Models\BaseProfile;
use Illuminate\Database\Eloquent\Builder;
use Modules\SaluteOra\Enums\DayFrequencyEnum;
use Modules\SaluteOra\Enums\MedicalConditionEnum;
use Modules\SaluteOra\Enums\OccurrenceFrequencyEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;


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
 * @property-read \Modules\SaluteOra\Models\Studio|null $studio
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property string|null $period_start
 * @property string|null $period_end
 * @property string|null $parameters
 * @property string|null $last_generated_at
 * @property string|null $created_by
 * @property string|null $tenant_id
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Modules\Media\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Modules\SaluteOra\Database\Factories\ReportFactory factory($count = null, $state = [])
 * @method static Builder<static>|Report newModelQuery()
 * @method static Builder<static>|Report newQuery()
 * @method static Builder<static>|Report query()
 * @method static Builder<static>|Report whereAppointmentId($value)
 * @method static Builder<static>|Report whereCreatedAt($value)
 * @method static Builder<static>|Report whereCreatedBy($value)
 * @method static Builder<static>|Report whereDecayedTeeth($value)
 * @method static Builder<static>|Report whereDeletedAt($value)
 * @method static Builder<static>|Report whereDeletedBy($value)
 * @method static Builder<static>|Report whereDescription($value)
 * @method static Builder<static>|Report whereFollowsDietRules($value)
 * @method static Builder<static>|Report whereFurtherNotes($value)
 * @method static Builder<static>|Report whereHasDiseases($value)
 * @method static Builder<static>|Report whereHasFixedProsthesisOrImplants($value)
 * @method static Builder<static>|Report whereHasMouthOrTeethPain($value)
 * @method static Builder<static>|Report whereHasPlaque($value)
 * @method static Builder<static>|Report whereHasTartar($value)
 * @method static Builder<static>|Report whereId($value)
 * @method static Builder<static>|Report whereInvoice($value)
 * @method static Builder<static>|Report whereLastGeneratedAt($value)
 * @method static Builder<static>|Report whereMissingTeeth($value)
 * @method static Builder<static>|Report whereMoreInfoDecayedTeeth($value)
 * @method static Builder<static>|Report whereMoreInfoMissingTeeth($value)
 * @method static Builder<static>|Report whereMoreInfoPlaque($value)
 * @method static Builder<static>|Report whereMoreInfoProsthesis($value)
 * @method static Builder<static>|Report whereMoreInfoTartar($value)
 * @method static Builder<static>|Report whereMouthTeethPainFrequency($value)
 * @method static Builder<static>|Report whereName($value)
 * @method static Builder<static>|Report whereNeedsMoreDentalCare($value)
 * @method static Builder<static>|Report whereParameters($value)
 * @method static Builder<static>|Report wherePatientId($value)
 * @method static Builder<static>|Report wherePeriodEnd($value)
 * @method static Builder<static>|Report wherePeriodStart($value)
 * @method static Builder<static>|Report wherePregnancyMonth($value)
 * @method static Builder<static>|Report wherePregnancyWeek($value)
 * @method static Builder<static>|Report whereSmokes($value)
 * @method static Builder<static>|Report whereSpecifyDecayedTeeth($value)
 * @method static Builder<static>|Report whereSpecifyDiseases($value)
 * @method static Builder<static>|Report whereSpecifyMissingTeeth($value)
 * @method static Builder<static>|Report whereSpecifyPlaque($value)
 * @method static Builder<static>|Report whereSpecifyProsthesisOrImplants($value)
 * @method static Builder<static>|Report whereSpecifyTartar($value)
 * @method static Builder<static>|Report whereStatus($value)
 * @method static Builder<static>|Report whereTeethBrushingFrequency($value)
 * @method static Builder<static>|Report whereTenantId($value)
 * @method static Builder<static>|Report whereType($value)
 * @method static Builder<static>|Report whereUpdatedAt($value)
 * @method static Builder<static>|Report whereUpdatedBy($value)
 * @method static Builder<static>|Report whereUsesAslClinicForDentalCare($value)
 * @method static Builder<static>|Report whereVisitsDentistYearly($value)
 * @mixin \Eloquent
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
            //'mouth_teeth_pain_frequency' => OccurrenceFrequencyEnum::class,
            //'teeth_brushing_frequency' => DayFrequencyEnum::class,
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


    /**
     * @return array<int, MedicalConditionEnum|null>
     */
    public function getSpecifyDiseases(): array
    {
        return Arr::map($this->specify_diseases, function($disease){
            return MedicalConditionEnum::tryFrom($disease);
        });
    }

    /**
     * @param null|string|OccurrenceFrequencyEnum $value
     * @return null|OccurrenceFrequencyEnum
     */
    public function getMouthTeethPainFrequencyAttribute($value)
    {
        if($value instanceof OccurrenceFrequencyEnum){
            return $value;
        }
        if(is_string($value)){
            return OccurrenceFrequencyEnum::tryFrom($value);
        }
        return null;
    }
    
    /**
     * @param null|string|DayFrequencyEnum $value
     * @return null|DayFrequencyEnum
     */
    public function getTeethBrushingFrequencyAttribute($value)
    {
        if($value instanceof DayFrequencyEnum){
            return $value;
        }
        if(is_string($value)){
            return DayFrequencyEnum::tryFrom($value);
        }
        return null;
    }

    /**
     * Appuntamento a cui è associato il report.
     *
     * @return BelongsTo<Appointment, $this>
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    /**
     * Paziente a cui è associato il report.
     *
     * @return BelongsTo<Patient, $this>
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * Dottore che ha redatto il report.
     *
     * @return BelongsTo<Doctor, $this>
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /*
     * Studio dove è stato generato il report (attraverso l'appuntamento).
     * Relazione indiretta attraverso l'appuntamento.
     *
     * @return HasOneThrough<Studio, Appointment, $this>
     
    public function studio(): HasOneThrough
    {
        return $this->hasOneThrough(Studio::class, Appointment::class, 'id', 'id', 'appointment_id', 'studio_id');
    }
    */
    /*
     * Studio dove è stato generato il report (accessor per backward compatibility).
     * 
     * @return Studio|null
     
    public function getStudioAttribute(): ?Studio
    {
        return $this->appointment?->studio;
    }
        */
}
