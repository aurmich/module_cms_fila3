<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Parental\HasParent;
use Spatie\MediaLibrary\HasMedia;
use Modules\SaluteOra\Models\User;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;

/**
 * Class Patient
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $date_of_birth
 * @property \Carbon\Carbon|null $birth_date Alias for date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $fiscal_code
 * @property string|null $pregnancy_status
 * @property int|null $tenant_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \Modules\SaluteOra\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\SaluteOra\Models\Appointment> $appointments
 * @property-read \Modules\SaluteOra\Models\PatientIsee|null $isee
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUserId($value)
 * @mixin \Eloquent
 */
class Patient extends User implements HasMedia
{
    use HasParent;
    use InteractsWithMedia;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'address',
        'phone',
        'last_dental_visit',
        'dental_problems',

    ];
    protected $appends = [
        //'health_card',
        //'identity_document',
        //'isee_certificate',
        //'pregnancy_certificate',
    ];

    public static array $attachments = [
        'health_card',
        'identity_document',
        'isee_certificate',
        'pregnancy_certificate',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'date_of_birth' => 'date',
        ];
    }

    /**
     * Registra le conversioni per i media
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Conversione per le anteprime dei documenti
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();

        // Conversione per le immagini dei documenti
        $this
            ->addMediaConversion('document')
            ->fit(Fit::Contain, 800, 800)
            ->nonQueued();
    }

    /**
     * Registra le collezioni di media
     */
    public function registerMediaCollections(): void
    {
        foreach (self::$attachments as $attachment) {
            $this
                ->addMediaCollection($attachment)
                ->singleFile()
                ->useDisk('local');
        }
    }

        /**
     * Verifica se un allegato specifico esiste
     */
    public function hasAttachment(string $type): bool
    {
        return $this->getFirstMedia($type) !== null;
    }

    /**
     * Ottiene l'URL sicuro per visualizzare un allegato
     */
    public function getAttachmentUrl(string $type): ?string
    {
        $media = $this->getFirstMedia($type);
        if (!$media) {
            return null;
        }

        return route('patients.view-pdf', [
            'patient' => $this->id,
            'type' => $type,
            'token' => encrypt([
                'patient_id' => $this->id,
                'type' => $type,
                'user_id' => auth()->id(),
                'expires_at' => now()->addHour()
            ])
        ]);
    }

    /**
     * Conta il numero di allegati presenti
     */
    public function getAttachmentsCount(): int
    {
        $count = 0;
        foreach (self::$attachments as $type) {
            if ($this->hasAttachment($type)) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Verifica se tutti gli allegati obbligatori sono presenti
     */
    public function hasRequiredAttachments(): bool
    {
        $required = ['health_card', 'identity_document'];
        foreach ($required as $type) {
            if (!$this->hasAttachment($type)) {
                return false;
            }
        }
        return true;
    }
}