<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Sushi\Sushi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToJson;

/**
 * Modello per i comuni italiani con Sushi.
 * 
 * Implementa il pattern Facade per fornire un'interfaccia unificata a tutti i dati geografici:
 * regioni, province, città, CAP, codici ISTAT, ecc.
 * Tutti i dati sono estratti da file JSON e gestiti tramite Sushi.
 *
 * @property int $id
 * @property string $nome
 * @property string $codice
 * @property string $regione
 * @property string $provincia
 * @property string $sigla_provincia
 * @property string $cap
 * @property string $codice_catastale
 * @property int $popolazione
 * @property string $zona_altimetrica
 * @property int $altitudine
 * @property float $superficie
 * @property float $lat
 * @property float $lng
 * @property array<array-key, mixed>|null $zona
 * @property string|null $sigla
 * @property string|null $codiceCatastale
 * @property-read \Modules\SaluteOra\Models\Profile|null $creator
 * @property-read \Modules\SaluteOra\Models\Profile|null $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereCap($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereCodice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereCodiceCatastale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereNome($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune wherePopolazione($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereProvincia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereRegione($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereSigla($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comune whereZona($value)
 * @mixin \Eloquent
 */
class Comune extends BaseModel
{
    use SushiToJson;


    /** @var array<int, string> */
    public $translatable = [
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'codice',
        'nome',
        'regione',
        'provincia',
        'sigla_provincia',
        'cap',
        'codice_catastale',
        'popolazione',
        'zona_altimetrica',
        'altitudine',
        'superficie',
        'lat',
        'lng',
    ];

    protected array $schema = [
        'id' => 'integer',
        'title' => 'json',
        'slug' => 'string',
        'content' => 'string',

        'zona' => 'json',
        'provincia' => 'json',
        'regione' => 'json',
        'cap' => 'json',

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

        'created_by' => 'string',
        'updated_by' => 'string',
    ];

    public function getJsonFile(): string
    {
        return module_path('Geo', 'resources/json/comuni.json');
    }

    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /** @return array<string, string>     */
    protected function casts(): array
    {
        return [
            'regione' => 'array',
            'zona' => 'array',
            'provincia' => 'array',
            'cap' => 'array',
        ];
    }

    /**
     * Get all regions
     *
     * @return Collection<string>
     */
    public static function getRegioni(): Collection
    {
        return static::all()->pluck('regione')->unique()->sort()->values();
    }

    /**
     * Get all provinces for a region
     *
     * @param string $regione
     * @return Collection<string>
     */
    public static function getProvinceByRegione(string $regione): Collection
    {
        return static::where('regione', $regione)
            ->pluck('provincia')
            ->unique()
            ->sort()
            ->values();
    }

    /**
     * Get all comuni for a province
     *
     * @param string $provincia
     * @return Collection<static>
     */
    public static function getComuniByProvincia(string $provincia): Collection
    {
        return static::where('provincia', $provincia)
            ->orderBy('nome')
            ->get();
    }

    /**
     * Find a comune by name (case insensitive)
     *
     * @param string $nome The name of the comune to find (case insensitive)
     * @return static|null The found comune or null if not found
     */
    public static function findByNome(string $nome): ?self
    {
        return static::all()->first(function ($comune) use ($nome) {
            return strtolower($comune->nome) === strtolower($nome);
        });
    }

    /**
     * Find comuni by CAP code (partial match supported)
     *
     * @param string $cap The CAP code to search for
     * @return Collection<static> Collection of matching comuni
     */
    public static function findByCap(string $cap): Collection
    {
        return static::where('cap', 'like', "%{$cap}%")->get();
    }

    /**
     * Find a city by ID
     * 
     * @param int $id
     * @return array{id: int, nome: string, provincia: string, regione: string, cap: string, codice_catastale: string, popolazione: int, altitudine: int, superficie: float, lat: float, lng: float, zona_altimetrica: string}|null
     */
    public static function findComune(int $id): ?array
    {
        $comune = static::query()->where('id', $id)->first();
        return $comune ? $comune->toArray() : null;
    }

    /**
     * Get the directory where Comune JSON files are stored.
     *
     * @return string
     */
    public function getJsonDirectory(): string
    {
        return $this->jsonDirectory;
    }

    /**
     * Set the directory where Comune JSON files are stored.
     *
     * @param string $directory
     * @return void
     */
    public function setJsonDirectory(string $directory): void
    {
        $this->jsonDirectory = $directory;
    }
}
