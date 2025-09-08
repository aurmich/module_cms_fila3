<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
<<<<<<< HEAD
namespace Modules\Cms\Tests\Unit\Models;

=======
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
use Modules\Cms\Models\PageContent;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Spatie\Translatable\HasTranslations;

test('page content model uses required traits', function () {
<<<<<<< HEAD
    $pageContent = new PageContent();
    
=======
<<<<<<< HEAD
    $pageContent = new PageContent;

=======
    $pageContent = new PageContent();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent)->toBeInstanceOf(SushiToJsons::class);
    expect(in_array(HasTranslations::class, class_uses($pageContent)))->toBeTrue();
});

test('page content has correct translatable attributes', function () {
<<<<<<< HEAD
    $pageContent = new PageContent();
    
=======
<<<<<<< HEAD
    $pageContent = new PageContent;

=======
    $pageContent = new PageContent();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $expectedTranslatable = [
        'name',
        'blocks',
    ];
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->translatable)->toBe($expectedTranslatable);
});

test('page content has correct fillable attributes', function () {
<<<<<<< HEAD
    $pageContent = new PageContent();
    
=======
<<<<<<< HEAD
    $pageContent = new PageContent;

=======
    $pageContent = new PageContent();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $expectedFillable = [
        'name',
        'slug',
        'blocks',
    ];
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->getFillable())->toBe($expectedFillable);
});

test('page content has correct schema definition', function () {
<<<<<<< HEAD
    $pageContent = new PageContent();
    
=======
<<<<<<< HEAD
    $pageContent = new PageContent;

=======
    $pageContent = new PageContent();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $expectedSchema = [
        'id' => 'integer',
        'name' => 'json',
        'slug' => 'string',
        'blocks' => 'json',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'string',
        'updated_by' => 'string',
    ];
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->schema)->toBe($expectedSchema);
});

test('page content has correct casts', function () {
<<<<<<< HEAD
    $pageContent = new PageContent();
    
=======
<<<<<<< HEAD
    $pageContent = new PageContent;

=======
    $pageContent = new PageContent();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $expectedCasts = [
        'id' => 'string',
        'uuid' => 'string',
        'name' => 'string',
        'slug' => 'string',
        'blocks' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->casts())->toBe($expectedCasts);
});

test('page content can be created with basic data', function () {
    $pageContent = PageContent::factory()->create([
        'slug' => 'test-content',
        'name' => ['en' => 'Test Content', 'it' => 'Contenuto di Test'],
<<<<<<< HEAD
        'blocks' => [['type' => 'text', 'content' => 'Test content']]
    ]);
    
=======
<<<<<<< HEAD
        'blocks' => [['type' => 'text', 'content' => 'Test content']],
    ]);

=======
        'blocks' => [['type' => 'text', 'content' => 'Test content']]
    ]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent)
        ->slug->toBe('test-content')
        ->name->toBe(['en' => 'Test Content', 'it' => 'Contenuto di Test'])
        ->blocks->toBe([['type' => 'text', 'content' => 'Test content']]);
});

test('page content blocks support complex structures', function () {
    $blocks = [
        [
            'type' => 'hero',
            'title' => 'Welcome Banner',
            'content' => 'Hero section content',
            'image' => 'hero.jpg',
<<<<<<< HEAD
            'cta' => ['text' => 'Get Started', 'link' => '/start']
=======
<<<<<<< HEAD
            'cta' => ['text' => 'Get Started', 'link' => '/start'],
=======
            'cta' => ['text' => 'Get Started', 'link' => '/start']
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        ],
        [
            'type' => 'features',
            'title' => 'Our Features',
            'items' => [
                ['title' => 'Fast', 'description' => 'Lightning fast performance'],
                ['title' => 'Secure', 'description' => 'Bank-level security'],
<<<<<<< HEAD
                ['title' => 'Reliable', 'description' => '99.9% uptime guarantee']
            ]
=======
<<<<<<< HEAD
                ['title' => 'Reliable', 'description' => '99.9% uptime guarantee'],
            ],
=======
                ['title' => 'Reliable', 'description' => '99.9% uptime guarantee']
            ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        ],
        [
            'type' => 'testimonial',
            'quote' => 'Amazing service!',
            'author' => 'John Doe',
            'company' => 'ABC Corp',
<<<<<<< HEAD
            'image' => 'john.jpg'
        ]
=======
<<<<<<< HEAD
            'image' => 'john.jpg',
        ],
>>>>>>> 681ae6a (.)
    ];
    
    $pageContent = PageContent::factory()->create(['blocks' => $blocks]);
<<<<<<< HEAD
    
=======

=======
            'image' => 'john.jpg'
        ]
    ];
    
    $pageContent = PageContent::factory()->create(['blocks' => $blocks]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->blocks)
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
<<<<<<< HEAD
            fn($block) => $block->type->toBe('hero'),
            fn($block) => $block->type->toBe('features'),
            fn($block) => $block->type->toBe('testimonial')
=======
<<<<<<< HEAD
            fn ($block) => $block->type->toBe('hero'),
            fn ($block) => $block->type->toBe('features'),
            fn ($block) => $block->type->toBe('testimonial')
=======
            fn($block) => $block->type->toBe('hero'),
            fn($block) => $block->type->toBe('features'),
            fn($block) => $block->type->toBe('testimonial')
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        );
});

test('page content supports multilingual name', function () {
    $pageContent = PageContent::factory()->create([
        'name' => [
            'en' => 'Home Content',
            'it' => 'Contenuto Home',
            'es' => 'Contenido Principal',
<<<<<<< HEAD
            'fr' => 'Contenu Principal'
        ]
    ]);
    
=======
<<<<<<< HEAD
            'fr' => 'Contenu Principal',
        ],
    ]);

=======
            'fr' => 'Contenu Principal'
        ]
    ]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->name)
        ->toBeArray()
        ->toHaveKey('en', 'Home Content')
        ->toHaveKey('it', 'Contenuto Home')
        ->toHaveKey('es', 'Contenido Principal')
        ->toHaveKey('fr', 'Contenu Principal');
});

test('page content supports multilingual blocks', function () {
    $blocks = [
        'en' => [
<<<<<<< HEAD
            ['type' => 'text', 'content' => 'English content']
=======
<<<<<<< HEAD
            ['type' => 'text', 'content' => 'English content'],
>>>>>>> 681ae6a (.)
        ],
        'it' => [
            ['type' => 'text', 'content' => 'Contenuto italiano']
        ],
        'es' => [
            ['type' => 'text', 'content' => 'Contenido español']
        ]
    ];
    
    $pageContent = PageContent::factory()->create(['blocks' => $blocks]);
<<<<<<< HEAD
    
=======

=======
            ['type' => 'text', 'content' => 'English content']
        ],
        'it' => [
            ['type' => 'text', 'content' => 'Contenuto italiano']
        ],
        'es' => [
            ['type' => 'text', 'content' => 'Contenido español']
        ]
    ];
    
    $pageContent = PageContent::factory()->create(['blocks' => $blocks]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->blocks)
        ->toBeArray()
        ->toHaveKeys(['en', 'it', 'es'])
        ->en->toBeArray()->toHaveCount(1)
        ->it->toBeArray()->toHaveCount(1)
        ->es->toBeArray()->toHaveCount(1);
});

test('page content factory creates valid instances', function () {
    $pageContent = PageContent::factory()->make();
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent)
        ->slug->toBeString()->not->toBeEmpty()
        ->name->toBeArray()->not->toBeEmpty()
        ->blocks->toBeArray();
});

test('page content slug must be unique', function () {
    $pageContent1 = PageContent::factory()->create(['slug' => 'unique-content']);
<<<<<<< HEAD
    
    expect(fn() => PageContent::factory()->create(['slug' => 'unique-content']))
=======
<<<<<<< HEAD

    expect(fn () => PageContent::factory()->create(['slug' => 'unique-content']))
=======
    
    expect(fn() => PageContent::factory()->create(['slug' => 'unique-content']))
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        ->toThrow(\Illuminate\Database\QueryException::class);
});

test('page content blocks validation', function () {
    $pageContent = PageContent::factory()->make(['blocks' => 'invalid-string']);
<<<<<<< HEAD
    
    expect(fn() => $pageContent->save())->toThrow(\Illuminate\Database\QueryException::class);
});

test('page content handles large blocks efficiently', function () {
    $largeBlocks = array_map(fn($i) => [
=======
<<<<<<< HEAD

    expect(fn () => $pageContent->save())->toThrow(\Illuminate\Database\QueryException::class);
});

test('page content handles large blocks efficiently', function () {
    $largeBlocks = array_map(fn ($i) => [
=======
    
    expect(fn() => $pageContent->save())->toThrow(\Illuminate\Database\QueryException::class);
});

test('page content handles large blocks efficiently', function () {
    $largeBlocks = array_map(fn($i) => [
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        'type' => 'card',
        'title' => "Card {$i}",
        'content' => "Content for card {$i} with detailed description.",
        'image' => "card{$i}.jpg",
<<<<<<< HEAD
        'metadata' => ['index' => $i, 'category' => 'test']
=======
<<<<<<< HEAD
        'metadata' => ['index' => $i, 'category' => 'test'],
>>>>>>> 681ae6a (.)
    ], range(1, 50));
    
    $pageContent = PageContent::factory()->create(['blocks' => $largeBlocks]);
<<<<<<< HEAD
    
=======

=======
        'metadata' => ['index' => $i, 'category' => 'test']
    ], range(1, 50));
    
    $pageContent = PageContent::factory()->create(['blocks' => $largeBlocks]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->fresh()->blocks)
        ->toBeArray()
        ->toHaveCount(50);
});

test('page content name validation for multilingual support', function () {
    $pageContent = PageContent::factory()->make(['name' => 'invalid-string']);
<<<<<<< HEAD
    
    expect(fn() => $pageContent->save())->toThrow(\Illuminate\Database\QueryException::class);
=======
<<<<<<< HEAD

    expect(fn () => $pageContent->save())->toThrow(\Illuminate\Database\QueryException::class);
>>>>>>> 681ae6a (.)
});

test('page content getRows method returns sushi rows', function () {
    $pageContent = new PageContent();
    
    $rows = $pageContent->getRows();
<<<<<<< HEAD
    
=======

=======
    
    expect(fn() => $pageContent->save())->toThrow(\Illuminate\Database\QueryException::class);
});

test('page content getRows method returns sushi rows', function () {
    $pageContent = new PageContent();
    
    $rows = $pageContent->getRows();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($rows)->toBeArray();
});

test('page content sluggable configuration', function () {
<<<<<<< HEAD
    $pageContent = new PageContent();
    
    $sluggable = $pageContent->sluggable();
    
=======
<<<<<<< HEAD
    $pageContent = new PageContent;

    $sluggable = $pageContent->sluggable();

=======
    $pageContent = new PageContent();
    
    $sluggable = $pageContent->sluggable();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($sluggable)
        ->toBeArray()
        ->toHaveKey('slug')
        ->slug->toBeArray()->toHaveKey('source', 'title');
});

test('page content with complex nested block structures', function () {
    $complexBlocks = [
        [
            'type' => 'accordion',
            'title' => 'FAQ Section',
<<<<<<< HEAD
            'items' => array_map(fn($i) => [
                'question' => "Question {$i}",
                'answer' => "Answer to question {$i} with detailed explanation.",
                'expanded' => $i === 0
            ], range(1, 20))
=======
<<<<<<< HEAD
            'items' => array_map(fn ($i) => [
                'question' => "Question {$i}",
                'answer' => "Answer to question {$i} with detailed explanation.",
                'expanded' => $i === 0,
            ], range(1, 20)),
=======
            'items' => array_map(fn($i) => [
                'question' => "Question {$i}",
                'answer' => "Answer to question {$i} with detailed explanation.",
                'expanded' => $i === 0
            ], range(1, 20))
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        ],
        [
            'type' => 'gallery',
            'title' => 'Image Gallery',
<<<<<<< HEAD
            'images' => array_map(fn($i) => [
                'src' => "gallery/image{$i}.jpg",
                'alt' => "Image {$i}",
                'caption' => "Caption for image {$i}",
                'thumbnail' => "gallery/thumb{$i}.jpg"
            ], range(1, 15))
=======
<<<<<<< HEAD
            'images' => array_map(fn ($i) => [
                'src' => "gallery/image{$i}.jpg",
                'alt' => "Image {$i}",
                'caption' => "Caption for image {$i}",
                'thumbnail' => "gallery/thumb{$i}.jpg",
            ], range(1, 15)),
=======
            'images' => array_map(fn($i) => [
                'src' => "gallery/image{$i}.jpg",
                'alt' => "Image {$i}",
                'caption' => "Caption for image {$i}",
                'thumbnail' => "gallery/thumb{$i}.jpg"
            ], range(1, 15))
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        ],
        [
            'type' => 'pricing',
            'title' => 'Pricing Plans',
            'plans' => [
                [
                    'name' => 'Basic',
                    'price' => '$9.99',
                    'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
<<<<<<< HEAD
                    'button' => ['text' => 'Get Basic', 'link' => '/buy/basic']
=======
<<<<<<< HEAD
                    'button' => ['text' => 'Get Basic', 'link' => '/buy/basic'],
=======
                    'button' => ['text' => 'Get Basic', 'link' => '/buy/basic']
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                [
                    'name' => 'Pro',
                    'price' => '$19.99',
                    'features' => ['All Basic features', 'Priority Support', 'Advanced Analytics'],
<<<<<<< HEAD
                    'button' => ['text' => 'Get Pro', 'link' => '/buy/pro']
=======
<<<<<<< HEAD
                    'button' => ['text' => 'Get Pro', 'link' => '/buy/pro'],
=======
                    'button' => ['text' => 'Get Pro', 'link' => '/buy/pro']
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                [
                    'name' => 'Enterprise',
                    'price' => '$49.99',
                    'features' => ['All Pro features', 'Dedicated Account Manager', 'Custom Solutions'],
<<<<<<< HEAD
                    'button' => ['text' => 'Contact Sales', 'link' => '/contact']
                ]
            ]
        ]
=======
<<<<<<< HEAD
                    'button' => ['text' => 'Contact Sales', 'link' => '/contact'],
                ],
            ],
        ],
>>>>>>> 681ae6a (.)
    ];
    
    $pageContent = PageContent::factory()->create(['blocks' => $complexBlocks]);
<<<<<<< HEAD
    
=======

=======
                    'button' => ['text' => 'Contact Sales', 'link' => '/contact']
                ]
            ]
        ]
    ];
    
    $pageContent = PageContent::factory()->create(['blocks' => $complexBlocks]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent->fresh()->blocks)
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
<<<<<<< HEAD
            fn($block) => $block->type->toBe('accordion')->items->toHaveCount(20),
            fn($block) => $block->type->toBe('gallery')->images->toHaveCount(15),
            fn($block) => $block->type->toBe('pricing')->plans->toHaveCount(3)
        );
});
=======
<<<<<<< HEAD
            fn ($block) => $block->type->toBe('accordion')->items->toHaveCount(20),
            fn ($block) => $block->type->toBe('gallery')->images->toHaveCount(15),
            fn ($block) => $block->type->toBe('pricing')->plans->toHaveCount(3)
        );
});
=======
            fn($block) => $block->type->toBe('accordion')->items->toHaveCount(20),
            fn($block) => $block->type->toBe('gallery')->images->toHaveCount(15),
            fn($block) => $block->type->toBe('pricing')->plans->toHaveCount(3)
        );
});
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
