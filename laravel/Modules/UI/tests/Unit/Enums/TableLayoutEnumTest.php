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
     * Test layout type checks.
     */
    public function test_layout_type_checks(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        $this->assertTrue($list->isListLayout());
        $this->assertFalse($list->isGridLayout());

        $this->assertTrue($grid->isGridLayout());
        $this->assertFalse($grid->isListLayout());
    }

    /**
     * Test grid configuration.
     */
    public function test_grid_configuration(): void
    {
        $grid = TableLayoutEnum::GRID;
        $config = $grid->getTableContentGrid();

        $this->assertIsArray($config);
        $this->assertArrayHasKey('sm', $config);
        $this->assertArrayHasKey('md', $config);
        $this->assertArrayHasKey('lg', $config);
        $this->assertArrayHasKey('xl', $config);
        $this->assertArrayHasKey('2xl', $config);
    }

    /**
     * Test table columns method.
     */
    public function test_table_columns_method(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

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
        $result = $list->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($listColumns, $result);

        // Test grid layout
        $result = $grid->getTableColumns($listColumns, $gridColumns);
        $this->assertEquals($gridColumns, $result);
    }

    /**
     * Test options method.
     */
    public function test_options_method(): void
    {
        $options = TableLayoutEnum::getOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('list', $options);
        $this->assertArrayHasKey('grid', $options);
        $this->assertEquals(TableLayoutEnum::LIST, $options['list']);
        $this->assertEquals(TableLayoutEnum::GRID, $options['grid']);
    }

    /**
     * Test container classes.
     */
    public function test_container_classes(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        $listClasses = $list->getContainerClasses();
        $gridClasses = $grid->getContainerClasses();

        $this->assertIsString($listClasses);
        $this->assertIsString($gridClasses);
        $this->assertNotEmpty($listClasses);
        $this->assertNotEmpty($gridClasses);
    }

    /**
     * Test translation support.
     */
    public function test_translation_support(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        // Test that labels are translatable
        $listLabel = $list->getLabel();
        $gridLabel = $grid->getLabel();

        $this->assertIsString($listLabel);
        $this->assertIsString($gridLabel);
        $this->assertNotEmpty($listLabel);
        $this->assertNotEmpty($gridLabel);
    }

    /**
     * Test color and icon methods.
     */
    public function test_color_and_icon_methods(): void
    {
        $list = TableLayoutEnum::LIST;
        $grid = TableLayoutEnum::GRID;

        // Test colors
        $listColor = $list->getColor();
        $gridColor = $grid->getColor();

        $this->assertIsString($listColor);
        $this->assertIsString($gridColor);
        $this->assertNotEmpty($listColor);
        $this->assertNotEmpty($gridColor);

        // Test icons
        $listIcon = $list->getIcon();
        $gridIcon = $grid->getIcon();

        $this->assertIsString($listIcon);
        $this->assertIsString($gridIcon);
        $this->assertNotEmpty($listIcon);
        $this->assertNotEmpty($gridIcon);
    }
} 