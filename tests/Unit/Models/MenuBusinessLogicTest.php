<?php

declare(strict_types=1);

use Modules\Cms\Models\Menu;

describe('Menu Business Logic', function () {
    test('menu extends base model', function () {
        expect(Menu::class)->toBeSubclassOf(\Modules\Cms\Models\BaseModel::class);
    });

    test('menu implements recursive relationships contract', function () {
        expect(Menu::class)->toImplement(\Modules\Xot\Contracts\HasRecursiveRelationshipsContract::class);
    });

    test('menu has recursive relationships trait', function () {
        $traits = class_uses(Menu::class);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($traits)->toHaveKey(\Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships::class);
    });

    test('menu has sushi to json trait', function () {
        $traits = class_uses(Menu::class);
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($traits)->toHaveKey(\Modules\Tenant\Models\Traits\SushiToJsons::class);
    });

    test('menu has expected fillable fields', function () {
<<<<<<< HEAD
        $menu = new Menu();
=======
        $menu = new Menu;
>>>>>>> b32aaf5 (.)
        $expectedFillable = [
            'title',
            'items',
            'parent_id',
        ];
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($menu->getFillable())->toEqual($expectedFillable);
    });

    test('menu can get tree options for hierarchical display', function () {
        $options = Menu::getTreeMenuOptions();
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($options)->toBeArray();
    });

    test('menu can get label', function () {
<<<<<<< HEAD
        $menu = new Menu();
        $menu->title = 'Test Menu';
        
=======
        $menu = new Menu;
        $menu->title = 'Test Menu';

>>>>>>> b32aaf5 (.)
        expect($menu->getLabel())->toBe('Test Menu');
    });

    test('menu has correct casts for structured data', function () {
<<<<<<< HEAD
        $menu = new Menu();
        $casts = $menu->getCasts();
        
=======
        $menu = new Menu;
        $casts = $menu->getCasts();

>>>>>>> b32aaf5 (.)
        expect($casts['items'])->toBe('array');
        expect($casts['id'])->toBe('string');
    });

    test('menu has schema definition for structured data', function () {
<<<<<<< HEAD
        $menu = new Menu();
        
=======
        $menu = new Menu;

>>>>>>> b32aaf5 (.)
        expect($menu)->toHaveProperty('schema');
        expect($menu->schema['title'])->toBe('string');
        expect($menu->schema['parent_id'])->toBe('integer');
    });

    test('menu can get rows for sushi functionality', function () {
<<<<<<< HEAD
        $menu = new Menu();
        
=======
        $menu = new Menu;

>>>>>>> b32aaf5 (.)
        expect(method_exists($menu, 'getRows'))->toBeTrue();
    });

    test('menu can build tree queries', function () {
        $query = Menu::tree();
<<<<<<< HEAD
        
=======

>>>>>>> b32aaf5 (.)
        expect($query)->toBeInstanceOf(\Staudenmeir\LaravelAdjacencyList\Eloquent\Builder::class);
    });

    test('menu can query by depth', function () {
        $query = Menu::whereDepth(1);
<<<<<<< HEAD
        
        expect($query)->toBeInstanceOf(\Staudenmeir\LaravelAdjacencyList\Eloquent\Builder::class);
    });
});
=======

        expect($query)->toBeInstanceOf(\Staudenmeir\LaravelAdjacencyList\Eloquent\Builder::class);
    });
});
>>>>>>> b32aaf5 (.)
