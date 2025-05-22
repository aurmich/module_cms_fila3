<?php

declare(strict_types=1);

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SaluteOra\Models\User;
use Parental\HasParent;

/**
 * Class Patient
 *
 * @property string $id
 * @property string $user_id
 * @property string|null $date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read \Modules\SaluteOra\Models\User|null $user
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
class Patient extends User
{
    use HasFactory;
    use HasParent;

   

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'address',
        'phone',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            ...parent::casts(),
            'date_of_birth' => 'date',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return parent::belongsTo(User::class, 'user_id');
    }

    /**
     * Verifica se il paziente ha dati validi per la transizione di stato.
     *
     * @return bool
     */
    public function hasValidData(): bool
    {
        return parent::hasValidData() &&
            !empty($this->date_of_birth) &&
            !empty($this->gender);
    }
}
