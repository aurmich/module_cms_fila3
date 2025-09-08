<?php

declare(strict_types=1);

<<<<<<< HEAD
=======
<<<<<<< HEAD
namespace Modules\Cms\Tests\Feature;

=======
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;

test('cms module models work together in content management', function () {
    $page = Page::factory()->create([
        'slug' => 'home-page',
        'title' => ['en' => 'Home Page', 'it' => 'Pagina Home'],
        'content' => 'Welcome to our website',
        'content_blocks' => [
<<<<<<< HEAD
            ['type' => 'hero', 'title' => 'Welcome', 'content' => 'Hero section']
        ]
    ]);
    
=======
<<<<<<< HEAD
            ['type' => 'hero', 'title' => 'Welcome', 'content' => 'Hero section'],
        ],
    ]);

=======
            ['type' => 'hero', 'title' => 'Welcome', 'content' => 'Hero section']
        ]
    ]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $pageContent = PageContent::factory()->create([
        'slug' => 'home-content',
        'name' => ['en' => 'Home Content', 'it' => 'Contenuto Home'],
        'blocks' => [
<<<<<<< HEAD
            ['type' => 'features', 'title' => 'Our Features', 'items' => []]
        ]
    ]);
    
=======
<<<<<<< HEAD
            ['type' => 'features', 'title' => 'Our Features', 'items' => []],
        ],
    ]);

=======
            ['type' => 'features', 'title' => 'Our Features', 'items' => []]
        ]
    ]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $section = Section::factory()->create([
        'slug' => 'hero-section',
        'name' => ['en' => 'Hero Section', 'it' => 'Sezione Hero'],
        'blocks' => [
<<<<<<< HEAD
            ['type' => 'banner', 'title' => 'Main Banner']
        ]
    ]);
    
=======
<<<<<<< HEAD
            ['type' => 'banner', 'title' => 'Main Banner'],
        ],
    ]);

=======
            ['type' => 'banner', 'title' => 'Main Banner']
        ]
    ]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($page)
        ->slug->toBe('home-page')
        ->title->toBe(['en' => 'Home Page', 'it' => 'Pagina Home'])
        ->content_blocks->toHaveCount(1);
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pageContent)
        ->slug->toBe('home-content')
        ->name->toBe(['en' => 'Home Content', 'it' => 'Contenuto Home'])
        ->blocks->toHaveCount(1);
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($section)
        ->slug->toBe('hero-section')
        ->name->toBe(['en' => 'Hero Section', 'it' => 'Sezione Hero'])
        ->blocks->toHaveCount(1);
<<<<<<< HEAD
    
    $pages = Page::where('slug', 'home-page')->get();
    $pageContents = PageContent::where('slug', 'home-content')->get();
    $sections = Section::where('slug', 'hero-section')->get();
    
=======
<<<<<<< HEAD

    $pages = Page::where('slug', 'home-page')->get();
    $pageContents = PageContent::where('slug', 'home-content')->get();
    $sections = Section::where('slug', 'hero-section')->get();

=======
    
    $pages = Page::where('slug', 'home-page')->get();
    $pageContents = PageContent::where('slug', 'home-content')->get();
    $sections = Section::where('slug', 'hero-section')->get();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($pages)->toHaveCount(1)->first()->id->toBe($page->id);
    expect($pageContents)->toHaveCount(1)->first()->id->toBe($pageContent->id);
    expect($sections)->toHaveCount(1)->first()->id->toBe($section->id);
});

test('cms module handles multilingual content correctly', function () {
    $multilingualData = [
        'en' => 'English content',
        'it' => 'Contenuto italiano',
        'es' => 'Contenido español',
<<<<<<< HEAD
        'fr' => 'Contenu français'
    ];
    
=======
<<<<<<< HEAD
        'fr' => 'Contenu français',
    ];

=======
        'fr' => 'Contenu français'
    ];
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $page = Page::factory()->create([
        'title' => $multilingualData,
        'content_blocks' => [
            'en' => [['type' => 'text', 'content' => 'English text']],
            'it' => [['type' => 'text', 'content' => 'Testo italiano']],
            'es' => [['type' => 'text', 'content' => 'Texto español']],
<<<<<<< HEAD
            'fr' => [['type' => 'text', 'content' => 'Texte français']]
        ]
    ]);
    
=======
<<<<<<< HEAD
            'fr' => [['type' => 'text', 'content' => 'Texte français']],
        ],
    ]);

=======
            'fr' => [['type' => 'text', 'content' => 'Texte français']]
        ]
    ]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $pageContent = PageContent::factory()->create([
        'name' => $multilingualData,
        'blocks' => [
            'en' => [['type' => 'card', 'title' => 'English card']],
            'it' => [['type' => 'card', 'title' => 'Carta italiana']],
            'es' => [['type' => 'card', 'title' => 'Tarjeta española']],
<<<<<<< HEAD
            'fr' => [['type' => 'card', 'title' => 'Carte française']]
        ]
    ]);
    
=======
<<<<<<< HEAD
            'fr' => [['type' => 'card', 'title' => 'Carte française']],
        ],
    ]);

=======
            'fr' => [['type' => 'card', 'title' => 'Carte française']]
        ]
    ]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    $section = Section::factory()->create([
        'name' => $multilingualData,
        'blocks' => [
            'en' => [['type' => 'banner', 'title' => 'English banner']],
            'it' => [['type' => 'banner', 'title' => 'Banner italiano']],
            'es' => [['type' => 'banner', 'title' => 'Banner español']],
<<<<<<< HEAD
            'fr' => [['type' => 'banner', 'title' => 'Bannière française']]
        ]
=======
<<<<<<< HEAD
            'fr' => [['type' => 'banner', 'title' => 'Bannière française']],
        ],
>>>>>>> 681ae6a (.)
    ]);
    
    expect($page->title)->toBe($multilingualData);
    expect($pageContent->name)->toBe($multilingualData);
    expect($section->name)->toBe($multilingualData);
<<<<<<< HEAD
    
=======

=======
            'fr' => [['type' => 'banner', 'title' => 'Bannière française']]
        ]
    ]);
    
    expect($page->title)->toBe($multilingualData);
    expect($pageContent->name)->toBe($multilingualData);
    expect($section->name)->toBe($multilingualData);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($page->content_blocks)->toHaveKeys(['en', 'it', 'es', 'fr']);
    expect($pageContent->blocks)->toHaveKeys(['en', 'it', 'es', 'fr']);
    expect($section->blocks)->toHaveKeys(['en', 'it', 'es', 'fr']);
});

test('cms module handles complex block structures', function () {
    $complexBlocks = [
        [
            'type' => 'advanced_grid',
            'title' => 'Advanced Content Grid',
            'layout' => 'masonry',
            'columns' => [
                'desktop' => 4,
                'tablet' => 3,
<<<<<<< HEAD
                'mobile' => 1
            ],
            'items' => array_map(fn($i) => [
=======
<<<<<<< HEAD
                'mobile' => 1,
            ],
            'items' => array_map(fn ($i) => [
=======
                'mobile' => 1
            ],
            'items' => array_map(fn($i) => [
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                'id' => $i,
                'type' => 'content_card',
                'title' => "Card {$i}",
                'content' => "Detailed content for card {$i} with multiple paragraphs and rich text formatting.",
                'image' => [
                    'src' => "images/card{$i}.jpg",
                    'alt' => "Card {$i} Image",
                    'sizes' => [
                        'thumbnail' => "images/thumb/card{$i}.jpg",
                        'medium' => "images/medium/card{$i}.jpg",
<<<<<<< HEAD
                        'large' => "images/large/card{$i}.jpg"
                    ]
=======
<<<<<<< HEAD
                        'large' => "images/large/card{$i}.jpg",
                    ],
=======
                        'large' => "images/large/card{$i}.jpg"
                    ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'metadata' => [
                    'author' => "Author {$i}",
                    'published_at' => now()->subDays($i)->toISOString(),
<<<<<<< HEAD
                    'categories' => ['Category ' . ($i % 3 + 1), 'Category ' . (($i + 1) % 3 + 1)],
                    'tags' => array_map(fn($t) => "tag{$t}", range(1, 5)),
                    'reading_time' => rand(2, 10)
=======
<<<<<<< HEAD
                    'categories' => ['Category '.($i % 3 + 1), 'Category '.(($i + 1) % 3 + 1)],
                    'tags' => array_map(fn ($t) => "tag{$t}", range(1, 5)),
                    'reading_time' => rand(2, 10),
=======
                    'categories' => ['Category ' . ($i % 3 + 1), 'Category ' . (($i + 1) % 3 + 1)],
                    'tags' => array_map(fn($t) => "tag{$t}", range(1, 5)),
                    'reading_time' => rand(2, 10)
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'actions' => [
                    ['label' => 'Read More', 'url' => "/card/{$i}", 'style' => 'primary'],
                    ['label' => 'Share', 'url' => "/share/{$i}", 'style' => 'secondary'],
<<<<<<< HEAD
                    ['label' => 'Bookmark', 'url' => "/bookmark/{$i}", 'style' => 'outline']
=======
<<<<<<< HEAD
                    ['label' => 'Bookmark', 'url' => "/bookmark/{$i}", 'style' => 'outline'],
=======
                    ['label' => 'Bookmark', 'url' => "/bookmark/{$i}", 'style' => 'outline']
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'ratings' => [
                    'average' => rand(30, 50) / 10,
                    'count' => rand(10, 1000),
                    'distribution' => [
                        '5' => rand(10, 100),
                        '4' => rand(5, 80),
                        '3' => rand(3, 50),
                        '2' => rand(1, 20),
<<<<<<< HEAD
                        '1' => rand(0, 10)
                    ]
=======
<<<<<<< HEAD
                        '1' => rand(0, 10),
                    ],
=======
                        '1' => rand(0, 10)
                    ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'social' => [
                    'shares' => rand(10, 1000),
                    'likes' => rand(50, 5000),
<<<<<<< HEAD
                    'comments' => rand(5, 500)
=======
<<<<<<< HEAD
                    'comments' => rand(5, 500),
=======
                    'comments' => rand(5, 500)
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'accessibility' => [
                    'aria_label' => "Content Card {$i}",
                    'tab_index' => $i,
<<<<<<< HEAD
                    'keyboard_navigation' => true
=======
<<<<<<< HEAD
                    'keyboard_navigation' => true,
=======
                    'keyboard_navigation' => true
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'performance' => [
                    'lazy_load' => true,
                    'priority' => $i <= 3 ? 'high' : 'low',
<<<<<<< HEAD
                    'preload' => $i <= 6
                ]
            ], range(1, 12))
=======
<<<<<<< HEAD
                    'preload' => $i <= 6,
                ],
            ], range(1, 12)),
=======
                    'preload' => $i <= 6
                ]
            ], range(1, 12))
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        ],
        [
            'type' => 'interactive_chart',
            'title' => 'Performance Analytics',
            'chart_type' => 'line',
            'data' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'datasets' => [
                    [
                        'label' => 'Revenue',
<<<<<<< HEAD
                        'data' => array_map(fn() => rand(10000, 50000), range(1, 12)),
=======
<<<<<<< HEAD
                        'data' => array_map(fn () => rand(10000, 50000), range(1, 12)),
>>>>>>> 681ae6a (.)
                        'borderColor' => 'rgb(75, 192, 192)',
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'tension' => 0.1
                    ],
                    [
                        'label' => 'Users',
                        'data' => array_map(fn() => rand(1000, 10000), range(1, 12)),
                        'borderColor' => 'rgb(255, 99, 132)',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'tension' => 0.1
                    ],
                    [
                        'label' => 'Conversions',
                        'data' => array_map(fn() => rand(100, 1000), range(1, 12)),
                        'borderColor' => 'rgb(54, 162, 235)',
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
<<<<<<< HEAD
                        'tension' => 0.1
                    ]
                ]
=======
                        'tension' => 0.1,
                    ],
                ],
=======
                        'data' => array_map(fn() => rand(10000, 50000), range(1, 12)),
                        'borderColor' => 'rgb(75, 192, 192)',
                        'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                        'tension' => 0.1
                    ],
                    [
                        'label' => 'Users',
                        'data' => array_map(fn() => rand(1000, 10000), range(1, 12)),
                        'borderColor' => 'rgb(255, 99, 132)',
                        'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                        'tension' => 0.1
                    ],
                    [
                        'label' => 'Conversions',
                        'data' => array_map(fn() => rand(100, 1000), range(1, 12)),
                        'borderColor' => 'rgb(54, 162, 235)',
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'tension' => 0.1
                    ]
                ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'options' => [
                'responsive' => true,
                'interaction' => ['mode' => 'index', 'intersect' => false],
                'scales' => [
                    'y' => ['beginAtZero' => true],
<<<<<<< HEAD
                    'x' => ['display' => true]
=======
<<<<<<< HEAD
                    'x' => ['display' => true],
=======
                    'x' => ['display' => true]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'plugins' => [
                    'title' => ['display' => true, 'text' => 'Monthly Performance'],
                    'tooltip' => ['enabled' => true],
<<<<<<< HEAD
                    'legend' => ['position' => 'top']
                ]
=======
<<<<<<< HEAD
                    'legend' => ['position' => 'top'],
                ],
=======
                    'legend' => ['position' => 'top']
                ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'interactivity' => [
                'hover' => true,
                'click' => true,
                'tooltips' => true,
                'zoom' => true,
<<<<<<< HEAD
                'pan' => true
=======
<<<<<<< HEAD
                'pan' => true,
=======
                'pan' => true
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'export' => [
                'png' => true,
                'csv' => true,
<<<<<<< HEAD
                'json' => true
=======
<<<<<<< HEAD
                'json' => true,
=======
                'json' => true
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'accessibility' => [
                'aria_label' => 'Performance Analytics Chart',
                'keyboard_navigation' => true,
<<<<<<< HEAD
                'screen_reader' => true
            ]
=======
<<<<<<< HEAD
                'screen_reader' => true,
            ],
=======
                'screen_reader' => true
            ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        ],
        [
            'type' => 'real_time_updates',
            'title' => 'Live Data Feed',
            'source' => [
                'type' => 'websocket',
                'url' => 'wss://api.example.com/live',
                'protocol' => 'v1',
                'authentication' => ['type' => 'jwt', 'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9'],
<<<<<<< HEAD
                'reconnect' => ['enabled' => true, 'delay' => 3000, 'max_attempts' => 10]
=======
<<<<<<< HEAD
                'reconnect' => ['enabled' => true, 'delay' => 3000, 'max_attempts' => 10],
=======
                'reconnect' => ['enabled' => true, 'delay' => 3000, 'max_attempts' => 10]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'data_schema' => [
                'type' => 'object',
                'properties' => [
                    'timestamp' => ['type' => 'string', 'format' => 'date-time'],
                    'metric' => ['type' => 'string'],
                    'value' => ['type' => 'number'],
                    'unit' => ['type' => 'string'],
                    'trend' => ['type' => 'string', 'enum' => ['up', 'down', 'stable']],
<<<<<<< HEAD
                    'confidence' => ['type' => 'number', 'minimum' => 0, 'maximum' => 1]
                ],
                'required' => ['timestamp', 'metric', 'value']
=======
<<<<<<< HEAD
                    'confidence' => ['type' => 'number', 'minimum' => 0, 'maximum' => 1],
                ],
                'required' => ['timestamp', 'metric', 'value'],
=======
                    'confidence' => ['type' => 'number', 'minimum' => 0, 'maximum' => 1]
                ],
                'required' => ['timestamp', 'metric', 'value']
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'update_frequency' => 1000,
            'history' => [
                'enabled' => true,
                'limit' => 100,
<<<<<<< HEAD
                'persistence' => ['enabled' => true, 'strategy' => 'localStorage']
=======
<<<<<<< HEAD
                'persistence' => ['enabled' => true, 'strategy' => 'localStorage'],
=======
                'persistence' => ['enabled' => true, 'strategy' => 'localStorage']
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'visualization' => [
                'type' => 'sparkline',
                'animation' => ['duration' => 500, 'easing' => 'easeOutQuart'],
                'colors' => ['primary' => '#4f46e5', 'secondary' => '#10b981', 'accent' => '#f59e0b'],
                'thresholds' => [
                    ['value' => 100, 'color' => '#ef4444', 'label' => 'Critical'],
                    ['value' => 80, 'color' => '#f59e0b', 'label' => 'Warning'],
<<<<<<< HEAD
                    ['value' => 50, 'color' => '#10b981', 'label' => 'Normal']
                ]
=======
<<<<<<< HEAD
                    ['value' => 50, 'color' => '#10b981', 'label' => 'Normal'],
                ],
=======
                    ['value' => 50, 'color' => '#10b981', 'label' => 'Normal']
                ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'alerts' => [
                'enabled' => true,
                'conditions' => [
                    ['metric' => 'response_time', 'operator' => '>', 'value' => 1000, 'severity' => 'critical'],
                    ['metric' => 'error_rate', 'operator' => '>', 'value' => 5, 'severity' => 'warning'],
<<<<<<< HEAD
                    ['metric' => 'throughput', 'operator' => '<', 'value' => 10, 'severity' => 'info']
=======
<<<<<<< HEAD
                    ['metric' => 'throughput', 'operator' => '<', 'value' => 10, 'severity' => 'info'],
=======
                    ['metric' => 'throughput', 'operator' => '<', 'value' => 10, 'severity' => 'info']
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
                ],
                'notifications' => [
                    'email' => true,
                    'push' => true,
                    'sms' => false,
<<<<<<< HEAD
                    'webhook' => true
                ]
=======
<<<<<<< HEAD
                    'webhook' => true,
                ],
=======
                    'webhook' => true
                ]
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'performance' => [
                'debounce' => 200,
                'throttle' => 1000,
                'batch_size' => 10,
<<<<<<< HEAD
                'memory_limit' => '50MB'
=======
<<<<<<< HEAD
                'memory_limit' => '50MB',
=======
                'memory_limit' => '50MB'
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'fallback' => [
                'enabled' => true,
                'strategy' => 'polling',
                'interval' => 5000,
<<<<<<< HEAD
                'max_attempts' => 3
=======
<<<<<<< HEAD
                'max_attempts' => 3,
=======
                'max_attempts' => 3
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
            ],
            'accessibility' => [
                'aria_live' => 'polite',
                'aria_atomic' => true,
                'aria_relevant' => 'additions text',
                'keyboard_shortcuts' => [
                    ['key' => 'r', 'action' => 'refresh', 'description' => 'Refresh data'],
                    ['key' => 'p', 'action' => 'pause', 'description' => 'Pause updates'],
<<<<<<< HEAD
                    ['key' => 'f', 'action' => 'fullscreen', 'description' => 'Toggle fullscreen']
                ]
            ]
        ]
=======
<<<<<<< HEAD
                    ['key' => 'f', 'action' => 'fullscreen', 'description' => 'Toggle fullscreen'],
                ],
            ],
        ],
>>>>>>> 681ae6a (.)
    ];
    
    $page = Page::factory()->create(['content_blocks' => $complexBlocks]);
    $pageContent = PageContent::factory()->create(['blocks' => $complexBlocks]);
    $section = Section::factory()->create(['blocks' => $complexBlocks]);
<<<<<<< HEAD
    
=======

=======
                    ['key' => 'f', 'action' => 'fullscreen', 'description' => 'Toggle fullscreen']
                ]
            ]
        ]
    ];
    
    $page = Page::factory()->create(['content_blocks' => $complexBlocks]);
    $pageContent = PageContent::factory()->create(['blocks' => $complexBlocks]);
    $section = Section::factory()->create(['blocks' => $complexBlocks]);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($page->fresh()->content_blocks)
        ->toBeArray()
        ->toHaveCount(3)
        ->sequence(
<<<<<<< HEAD
            fn($block) => $block->type->toBe('advanced_grid')->items->toHaveCount(12),
            fn($block) => $block->type->toBe('interactive_chart')->data->datasets->toHaveCount(3),
            fn($block) => $block->type->toBe('real_time_updates')->source->type->toBe('websocket')
=======
<<<<<<< HEAD
            fn ($block) => $block->type->toBe('advanced_grid')->items->toHaveCount(12),
            fn ($block) => $block->type->toBe('interactive_chart')->data->datasets->toHaveCount(3),
            fn ($block) => $block->type->toBe('real_time_updates')->source->type->toBe('websocket')
>>>>>>> 681ae6a (.)
        );
    
    expect($pageContent->fresh()->blocks)
        ->toBeArray()
        ->toHaveCount(3);
<<<<<<< HEAD
    
=======

=======
            fn($block) => $block->type->toBe('advanced_grid')->items->toHaveCount(12),
            fn($block) => $block->type->toBe('interactive_chart')->data->datasets->toHaveCount(3),
            fn($block) => $block->type->toBe('real_time_updates')->source->type->toBe('websocket')
        );
    
    expect($pageContent->fresh()->blocks)
        ->toBeArray()
        ->toHaveCount(3);
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($section->fresh()->blocks)
        ->toBeArray()
        ->toHaveCount(3);
});

test('cms module handles bulk operations efficiently', function () {
    $pagesData = [];
    $pageContentsData = [];
    $sectionsData = [];
<<<<<<< HEAD
    
=======
<<<<<<< HEAD

=======
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    for ($i = 0; $i < 50; $i++) {
        $pagesData[] = [
            'slug' => "page-{$i}",
            'title' => ['en' => "Page {$i}", 'it' => "Pagina {$i}"],
            'content' => "Content for page {$i}",
            'content_blocks' => [['type' => 'text', 'content' => "Page {$i} content"]],
            'created_at' => now(),
<<<<<<< HEAD
            'updated_at' => now()
        ];
        
=======
<<<<<<< HEAD
            'updated_at' => now(),
        ];

=======
            'updated_at' => now()
        ];
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $pageContentsData[] = [
            'slug' => "content-{$i}",
            'name' => ['en' => "Content {$i}", 'it' => "Contenuto {$i}"],
            'blocks' => [['type' => 'card', 'title' => "Card {$i}"]],
            'created_at' => now(),
<<<<<<< HEAD
            'updated_at' => now()
        ];
        
=======
<<<<<<< HEAD
            'updated_at' => now(),
        ];

=======
            'updated_at' => now()
        ];
        
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
        $sectionsData[] = [
            'slug' => "section-{$i}",
            'name' => ['en' => "Section {$i}", 'it' => "Sezione {$i}"],
            'blocks' => [['type' => 'banner', 'title' => "Banner {$i}"]],
            'created_at' => now(),
<<<<<<< HEAD
            'updated_at' => now()
=======
<<<<<<< HEAD
            'updated_at' => now(),
>>>>>>> 681ae6a (.)
        ];
    }
    
    Page::insert($pagesData);
    PageContent::insert($pageContentsData);
    Section::insert($sectionsData);
    
    $pages = Page::where('slug', 'like', 'page-%')->get();
    $pageContents = PageContent::where('slug', 'like', 'content-%')->get();
    $sections = Section::where('slug', 'like', 'section-%')->get();
    
    expect($pages)->toHaveCount(50);
    expect($pageContents)->toHaveCount(50);
    expect($sections)->toHaveCount(50);
    
    $firstPage = $pages->first();
    $lastPage = $pages->last();
<<<<<<< HEAD
    
=======

=======
            'updated_at' => now()
        ];
    }
    
    Page::insert($pagesData);
    PageContent::insert($pageContentsData);
    Section::insert($sectionsData);
    
    $pages = Page::where('slug', 'like', 'page-%')->get();
    $pageContents = PageContent::where('slug', 'like', 'content-%')->get();
    $sections = Section::where('slug', 'like', 'section-%')->get();
    
    expect($pages)->toHaveCount(50);
    expect($pageContents)->toHaveCount(50);
    expect($sections)->toHaveCount(50);
    
    $firstPage = $pages->first();
    $lastPage = $pages->last();
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($firstPage->slug)->toBe('page-0');
    expect($lastPage->slug)->toBe('page-49');
});

test('cms module supports complex query patterns', function () {
    $pages = Page::factory()->count(10)->create([
<<<<<<< HEAD
        'content_blocks' => [['type' => 'hero', 'title' => 'Hero Section']]
=======
<<<<<<< HEAD
        'content_blocks' => [['type' => 'hero', 'title' => 'Hero Section']],
>>>>>>> 681ae6a (.)
    ]);
    
    $pageContents = PageContent::factory()->count(8)->create([
        'blocks' => [['type' => 'features', 'title' => 'Features']]
    ]);
    
    $sections = Section::factory()->count(6)->create([
        'blocks' => [['type' => 'testimonial', 'title' => 'Testimonials']]
    ]);
    
    $complexQuery = Page::query()
        ->whereJsonContains('content_blocks', [['type' => 'hero']])
        ->orderBy('created_at', 'desc');
    
    $results = $complexQuery->get();
    
    expect($results)->toHaveCount(10);
    
    $heroPages = $results->filter(fn($page) => 
        collect($page->content_blocks)->contains('type', 'hero')
    );
<<<<<<< HEAD
    
=======

=======
        'content_blocks' => [['type' => 'hero', 'title' => 'Hero Section']]
    ]);
    
    $pageContents = PageContent::factory()->count(8)->create([
        'blocks' => [['type' => 'features', 'title' => 'Features']]
    ]);
    
    $sections = Section::factory()->count(6)->create([
        'blocks' => [['type' => 'testimonial', 'title' => 'Testimonials']]
    ]);
    
    $complexQuery = Page::query()
        ->whereJsonContains('content_blocks', [['type' => 'hero']])
        ->orderBy('created_at', 'desc');
    
    $results = $complexQuery->get();
    
    expect($results)->toHaveCount(10);
    
    $heroPages = $results->filter(fn($page) => 
        collect($page->content_blocks)->contains('type', 'hero')
    );
    
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
    expect($heroPages)->toHaveCount(10);
});

test('cms module handles data consistency across models', function () {
    $page = Page::factory()->create([
        'slug' => 'consistent-page',
        'title' => ['en' => 'Consistent Page'],
<<<<<<< HEAD
        'content_blocks' => [['type' => 'text', 'content' => 'Initial content']]
=======
<<<<<<< HEAD
        'content_blocks' => [['type' => 'text', 'content' => 'Initial content']],
>>>>>>> 681ae6a (.)
    ]);
    
    $pageContent = PageContent::factory()->create([
        'slug' => 'consistent-content',
        'name' => ['en' => 'Consistent Content'],
        'blocks' => [['type' => 'card', 'title' => 'Initial card']]
    ]);
    
    $section = Section::factory()->create([
        'slug' => 'consistent-section',
        'name' => ['en' => 'Consistent Section'],
        'blocks' => [['type' => 'banner', 'title' => 'Initial banner']]
    ]);
    
    $page->update([
        'content_blocks' => array_merge($page->content_blocks, [['type' => 'updated', 'content' => 'Updated content']])
    ]);
    
    $pageContent->update([
        'blocks' => array_merge($pageContent->blocks, [['type' => 'updated', 'title' => 'Updated card']])
    ]);
    
    $section->update([
        'blocks' => array_merge($section->blocks, [['type' => 'updated', 'title' => 'Updated banner']])
    ]);
    
    $freshPage = $page->fresh();
    $freshPageContent = $pageContent->fresh();
    $freshSection = $section->fresh();
    
    expect($freshPage->content_blocks)->toHaveCount(2);
    expect($freshPageContent->blocks)->toHaveCount(2);
    expect($freshSection->blocks)->toHaveCount(2);
    
    expect($freshPage->content_blocks[1]['type'])->toBe('updated');
    expect($freshPageContent->blocks[1]['type'])->toBe('updated');
    expect($freshSection->blocks[1]['type'])->toBe('updated');
<<<<<<< HEAD
});
=======
});
=======
        'content_blocks' => [['type' => 'text', 'content' => 'Initial content']]
    ]);
    
    $pageContent = PageContent::factory()->create([
        'slug' => 'consistent-content',
        'name' => ['en' => 'Consistent Content'],
        'blocks' => [['type' => 'card', 'title' => 'Initial card']]
    ]);
    
    $section = Section::factory()->create([
        'slug' => 'consistent-section',
        'name' => ['en' => 'Consistent Section'],
        'blocks' => [['type' => 'banner', 'title' => 'Initial banner']]
    ]);
    
    $page->update([
        'content_blocks' => array_merge($page->content_blocks, [['type' => 'updated', 'content' => 'Updated content']])
    ]);
    
    $pageContent->update([
        'blocks' => array_merge($pageContent->blocks, [['type' => 'updated', 'title' => 'Updated card']])
    ]);
    
    $section->update([
        'blocks' => array_merge($section->blocks, [['type' => 'updated', 'title' => 'Updated banner']])
    ]);
    
    $freshPage = $page->fresh();
    $freshPageContent = $pageContent->fresh();
    $freshSection = $section->fresh();
    
    expect($freshPage->content_blocks)->toHaveCount(2);
    expect($freshPageContent->blocks)->toHaveCount(2);
    expect($freshSection->blocks)->toHaveCount(2);
    
    expect($freshPage->content_blocks[1]['type'])->toBe('updated');
    expect($freshPageContent->blocks[1]['type'])->toBe('updated');
    expect($freshSection->blocks[1]['type'])->toBe('updated');
});
>>>>>>> 09fa59df2d (.)
>>>>>>> 681ae6a (.)
