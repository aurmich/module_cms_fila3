<?php

declare(strict_types=1);

use Mockery;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Modules\Xot\Filament\Traits\HasXotTable;

uses(\Modules\Xot\Tests\TestCase::class);

beforeEach(function () {
    // Set up any necessary test data or mocks
});

afterEach(function () {
    Mockery::close();
});

// Test the table method with all methods implemented
test('table method with all methods implemented', function () {
    // Create mock object that uses HasXotTable trait
    $mock = Mockery::mock(HasTableWithXot::class);

    // Set up expectations for required methods
    $mock->shouldReceive('getModelClass')
        ->andReturn(DummyModel::class);
    $mock->shouldReceive('getTableRecordTitleAttribute')
        ->andReturn('name');

    // Set up expectations for optional methods
    $mock->shouldReceive('getTableHeaderActions')
        ->once()
        ->andReturn([]);
    $mock->shouldReceive('getTableActions')
        ->once()
        ->andReturn([]);
    $mock->shouldReceive('getTableBulkActions')
        ->once()
        ->andReturn([]);
    $mock->shouldReceive('getTableFilters')
        ->once()
        ->andReturn([]);
    $mock->shouldReceive('getTableBulkActions')
        ->once()
        ->andReturn([]);

    // Call the table method
    $table = $mock->table(Table::make());

    // Assert the table is an instance of Table
    expect($table)->toBeInstanceOf(Table::class);
});

// Test the table method without optional methods implemented
test('table method without optional methods', function () {
    // Create mock object that uses HasXotTable trait without optional methods
    $mock = Mockery::mock(HasTableWithoutOptionalMethods::class);

    // Set up expectations for required methods
    $mock->shouldReceive('getModelClass')
        ->andReturn(DummyModel::class);
    $mock->shouldReceive('getTableRecordTitleAttribute')
        ->andReturn('name');

    // Call the table method
    $table = $mock->table(Table::make());

    // Assert the table is an instance of Table
    expect($table)->toBeInstanceOf(Table::class);
});

// Test the table method with a custom table configuration
test('table method with custom configuration', function () {
    // Create mock object that uses HasXotTable trait
    $mock = Mockery::mock(HasTableWithXot::class);

    // Set up expectations for required methods
    $mock->shouldReceive('getModelClass')
        ->andReturn(DummyModel::class);
    $mock->shouldReceive('getTableRecordTitleAttribute')
        ->andReturn('name');

    // Set up expectations for optional methods
    $mock->shouldReceive('getTableHeaderActions')
        ->once()
        ->andReturn([]);
    $mock->shouldReceive('getTableActions')
        ->once()
        ->andReturn([]);
    $mock->shouldReceive('getTableBulkActions')
        ->once()
        ->andReturn([]);
    $mock->shouldReceive('getTableFilters')
        ->once()
        ->andReturn([]);

    // Call the table method with custom configuration
    $table = $mock->table(Table::make()
        ->columns([
            // Add test columns
        ])
        ->filters([
            // Add test filters
        ])
    );

    // Assert the table is an instance of Table
    expect($table)->toBeInstanceOf(Table::class);
});

/**
 * Dummy class that uses HasTable and HasXotTable traits for testing.
 */
class HasTableWithXot implements HasTable
{
    use HasXotTable;

    // Implement all required methods from HasTable interface
    public function getTable() {}
    public function getTablePage() {}
    public function getTableRecordsPerPage() {}
    public function getTableSortColumn() {}
    public function getTableSortDirection() {}
    public function getTableFilters() {}
    public function getTableFiltersForm() {}
    public function getTableFilterState() {}
    public function getTableGrouping() {}
    public function getTableSearchIndicator() {}
    public function getTableColumnSearchIndicators() {}
    public function getTableColumnToggleForm() {}
    public function getTableRecords() {}
    public function getTableRecord() {}
    public function getTableRecordKey() {}
    public function getSelectedTableRecords() {}
    public function getAllTableRecordsCount() {}
    public function getAllSelectableTableRecordsCount() {}
    public function getAllSelectableTableRecordKeys() {}
    public function getTableQueryForExport() {}
    public function getFilteredTableQuery() {}
    public function getFilteredSortedTableQuery() {}
    public function getAllTableSummaryQuery() {}
    public function getPageTableSummaryQuery() {}
    public function getMountedTableAction() {}
    public function getMountedTableActionForm() {}
    public function getMountedTableActionRecord() {}
    public function getMountedTableActionRecordKey() {}
    public function getMountedTableBulkAction() {}
    public function getMountedTableBulkActionForm() {}
    public function getActiveTableLocale() {}
    public function isTableLoaded() {}
    public function isTableReordering() {}
    public function hasTableSearch() {}
    public function isTableColumnToggledHidden() {}
    public function callMountedTableAction() {}
    public function callTableColumnAction() {}
    public function deselectAllTableRecords() {}
    public function mountTableAction() {}
    public function mountTableBulkAction() {}
    public function mountedTableActionRecord() {}
    public function replaceMountedTableAction() {}
    public function replaceMountedTableBulkAction() {}
    public function resetTableSearch() {}
    public function resetTableColumnSearch() {}
    public function toggleTableReordering() {}
    public function parseTableFilterName() {}
    public function makeFilamentTranslatableContentDriver() {}
}

/**
 * Dummy class without the optional methods.
 */
class HasTableWithoutOptionalMethods extends HasTableWithXot
{
    // This class inherits all methods but doesn't implement the optional ones
}

/**
 * Dummy model class for testing.
 */
class DummyModel
{
    // Dummy model class for testing
}
