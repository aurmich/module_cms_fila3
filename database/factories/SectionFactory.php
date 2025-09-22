<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Factories;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Cms\Models\Section;
use Webmozart\Assert\Assert;
=======
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;
use Modules\Cms\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;
>>>>>>> bc33217 (.)

/**
 * @extends Factory<Section>
 */
class SectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Section>
     */
    protected $model = Section::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = [
            'it' => $this->faker->words(2, true),
            'en' => $this->faker->words(2, true),
        ];
<<<<<<< HEAD
        Assert::string($name_en = $name['en'], __FILE__ . ':' . __LINE__ . ' - ' . class_basename(__CLASS__));
=======
        Assert::string($name_en=$name['en']);
>>>>>>> bc33217 (.)
        $slug = Str::slug($name_en);
        return [
            'name' => $name,
            'slug' => $slug,
            'blocks' => [], // Puoi popolare con dati fittizi se necessario
        ];
    }
<<<<<<< HEAD
}
=======
} 
>>>>>>> bc33217 (.)
