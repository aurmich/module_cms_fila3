<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Enums;

use Tests\TestCase;
use Modules\UI\Enums\TableLayoutEnum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Stack;

class TableLayoutEnumTest extends TestCase
{
    /**
     * Test enum values.
     */
    public function test_enum_values(): void
    {
        $this->assertEquals('list', TableLayoutEnum::LIST->value);
        $this->assertEquals('grid', TableLayoutEnum::GRID->value);
    }

    /**
     * Test default layout.
     */
    public function test_default_layout(): void
    {
        $default = TableLayoutEnum::init();
        $this->assertEquals(TableLayoutEnum::LIST, $default);
    }

    /**
     * Test toggle functionality.
     */
    public function test_toggle_functionality(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        $this->assertEquals($grid, $list->toggle());
        $this->assertEquals($list, $grid->toggle());
    }

    /**
     * Test layout checks.
     */
    public function test_layout_checks(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        $this->assertTrue($list->isListLayout());
        $this->assertFalse($list->isGridLayout());
        $this->assertTrue($grid->isGridLayout());
        $this->assertFalse($grid->isListLayout());
    }

    /**
     * Test labels.
     */
    public function test_labels(): void
    {
        $listLabel = TableLayoutEnum::LIST->getLabel();
        $gridLabel = TableLayoutEnum::GRID->getLabel();

        $this->assertIsString($listLabel);
        $this->assertIsString($gridLabel);
        $this->assertNotEmpty($listLabel);
        $this->assertNotEmpty($gridLabel);
    }

    /**
     * Test colors.
     */
    public function test_colors(): void
    {
        $listColor = TableLayoutEnum::LIST->getColor();
        $gridColor = TableLayoutEnum::GRID->getColor();

        $this->assertEquals('primary', $listColor);
        $this->assertEquals('secondary', $gridColor);
    }

    /**
     * Test icons.
     */
    public function test_icons(): void
    {
        $listIcon = TableLayoutEnum::LIST->getIcon();
        $gridIcon = TableLayoutEnum::GRID->getIcon();

        $this->assertEquals('heroicon-o-list-bullet', $listIcon);
        $this->assertEquals('heroicon-o-squares-2x2', $gridIcon);
    }

    /**
     * Test table content grid configuration.
     */
    public function test_table_content_grid(): void
    {
        $listGrid = TableLayoutEnum::LIST->getTableContentGrid();
        $gridGrid = TableLayoutEnum::GRID->getTableContentGrid();

        $this->assertNull($listGrid);
        $this->assertIsArray($gridGrid);
        $this->assertArrayHasKey('sm', $gridGrid);
        $this->assertArrayHasKey('md', $gridGrid);
        $this->assertArrayHasKey('lg', $gridGrid);
        $this->assertArrayHasKey('xl', $gridGrid);
        $this->assertArrayHasKey('2xl', $gridGrid);
    }

    /**
     * Test table columns selection.
     */
    public function test_table_columns_selection(): void
    {
        $listColumns = [
            TextColumn::make('name'),
            TextColumn::make('email'),
        ];

        $gridColumns = [
            Stack::make([
                TextColumn::make('name'),
                TextColumn::make('email'),
            ]),
        ];

        // Test list layout
        $selectedListColumns = TableLayoutEnum::LIST->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($listColumns, $selectedListColumns);

        // Test grid layout
        $selectedGridColumns = TableLayoutEnum::GRID->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($gridColumns, $selectedGridColumns);
    }

    /**
     * Test options array.
     */
    public function test_options_array(): void
    {
        $options = TableLayoutEnum::getOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('list', $options);
        $this->assertArrayHasKey('grid', $options);
        $this->assertIsString($options['list']);
        $this->assertIsString($options['grid']);
    }

    /**
     * Test container classes.
     */
    public function test_container_classes(): void
    {
        $listClasses = TableLayoutEnum::LIST->getContainerClasses();
        $gridClasses = TableLayoutEnum::GRID->getContainerClasses();

        $this->assertEquals('table-layout-list', $listClasses);
        $this->assertEquals('table-layout-grid', $gridClasses);
    }

    /**
     * Test responsive grid configuration values.
     */
    public function test_responsive_grid_values(): void
    {
        $grid = TableLayoutEnum::GRID->getTableContentGrid();
        
        if ($grid !== null) {
            $this->assertEquals(1, $grid['sm']);
            $this->assertEquals(2, $grid['md']);
            $this->assertEquals(3, $grid['lg']);
            $this->assertEquals(4, $grid['xl']);
            $this->assertEquals(5, $grid['2xl']);
        }
    }

    /**
     * Test enum implements required interfaces.
     */
    public function test_implements_interfaces(): void
    {
        $reflection = new \ReflectionEnum(TableLayoutEnum::class);
        $interfaces = $reflection->getInterfaceNames();

        $this->assertContains('Filament\Support\Contracts\HasColor', $interfaces);
        $this->assertContains('Filament\Support\Contracts\HasIcon', $interfaces);
        $this->assertContains('Filament\Support\Contracts\HasLabel', $interfaces);
    }

    /**
     * Test enum is string backed.
     */
    public function test_string_backed_enum(): void
    {
        $reflection = new \ReflectionEnum(TableLayoutEnum::class);
        $backingType = $reflection->getBackingType();

        $this->assertNotNull($backingType);
        $this->assertEquals('string', $backingType->getName());
    }

    /**
     * Test all cases are accessible.
     */
    public function test_all_cases_accessible(): void
    {
        $cases = TableLayoutEnum::cases();

        $this->assertCount(2, $cases);
        $this->assertContains(TableLayoutEnum::LIST, $cases);
        $this->assertContains(TableLayoutEnum::GRID, $cases);
    }

    /**
     * Test from method works correctly.
     */
    public function test_from_method(): void
    {
        $list = TableLayoutEnum::from('list');
        $grid = TableLayoutEnum::from('grid');

        $this->assertEquals(TableLayoutEnum::LIST, $list);
        $this->assertEquals(TableLayoutEnum::GRID, $grid);
    }

    /**
     * Test tryFrom method works correctly.
     */
    public function test_tryFrom_method(): void
    {
        $list = TableLayoutEnum::tryFrom('list');
        $grid = TableLayoutEnum::tryFrom('grid');
        $invalid = TableLayoutEnum::tryFrom('invalid');

        $this->assertEquals(TableLayoutEnum::LIST, $list);
        $this->assertEquals(TableLayoutEnum::GRID, $grid);
        $this->assertNull($invalid);
    }
} 