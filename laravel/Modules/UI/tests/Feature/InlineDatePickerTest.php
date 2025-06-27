<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Filament\Forms\Components\Field;
use Filament\Forms\Form;
use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\UI\Tests\TestCase;

class InlineDatePickerTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated(): void
    {
        $component = InlineDatePicker::make('test');
        $this->assertInstanceOf(Field::class, $component);
        $this->assertInstanceOf(InlineDatePicker::class, $component);
    }

    /** @test */
    public function it_can_set_and_get_enabled_dates(): void
    {
        $dates = ['2025-06-01', '2025-06-15', '2025-06-30'];
        
        $component = InlineDatePicker::make('test')
            ->enabledDates($dates);
            
        $this->assertEquals($dates, $component->getEnabledDates());
    }

    /** @test */
    public function it_accepts_closure_for_enabled_dates(): void
    {
        $dates = ['2025-06-01', '2025-06-15', '2025-06-30'];
        
        $component = InlineDatePicker::make('test')
            ->enabledDates(fn () => $dates);
            
        $this->assertEquals($dates, $component->getEnabledDates());
    }

    /** @test */
    public function it_checks_if_date_is_enabled(): void
    {
        $dates = ['2025-06-15'];
        
        $component = InlineDatePicker::make('test')
            ->enabledDates($dates);
            
        $this->assertTrue($component->isDateEnabled('2025-06-15'));
        $this->assertFalse($component->isDateEnabled('2025-06-16'));
    }

    /** @test */
    public function it_generates_month_grid_correctly(): void
    {
        $component = InlineDatePicker::make('test')
            ->enabledDates(['2025-06-15']);
            
        $grid = $component->generateMonthGrid(2025, 6);
        
        $this->assertIsArray($grid);
        $this->assertArrayHasKey('year', $grid);
        $this->assertArrayHasKey('month', $grid);
        $this->assertArrayHasKey('weeks', $grid);
        $this->assertIsArray($grid['weeks']);
        
        // Find the enabled date in the grid
        $enabledDateFound = false;
        foreach ($grid['weeks'] as $week) {
            foreach ($week as $day) {
                if ($day['date'] === '2025-06-15') {
                    $enabledDateFound = true;
                    $this->assertTrue($day['enabled']);
                    $this->assertTrue($day['selectable']);
                }
            }
        }
        
        $this->assertTrue($enabledDateFound, 'Enabled date 2025-06-15 not found in grid');
    }

    /** @test */
    public function it_applies_calendar_config(): void
    {
        $config = [
            'locale' => 'it',
            'firstDayOfWeek' => 1,
            'numberOfMonths' => 2,
        ];
        
        $component = InlineDatePicker::make('test')
            ->calendarConfig($config);
            
        $this->assertEquals($config, $component->getCalendarConfig());
    }

    /** @test */
    public function it_can_be_used_in_a_form(): void
    {
        $form = Form::make()
            ->schema([
                InlineDatePicker::make('appointment_date')
                    ->enabledDates(['2025-06-15'])
            ]);
            
        $this->assertCount(1, $form->getComponents());
        $this->assertInstanceOf(InlineDatePicker::class, $form->getComponent('appointment_date'));
    }

    /** @test */
    public function it_handles_empty_enabled_dates(): void
    {
        $component = InlineDatePicker::make('test')
            ->enabledDates([]);
            
        $this->assertEmpty($component->getEnabledDates());
        $this->assertTrue($component->isDateEnabled('2025-06-15'));
    }

    /** @test */
    public function it_handles_invalid_dates(): void
    {
        $component = InlineDatePicker::make('test')
            ->enabledDates(['invalid-date']);
            
        $this->assertFalse($component->isDateEnabled('2025-06-15'));
    }

    /** @test */
    public function it_handles_different_date_formats(): void
    {
        $component = InlineDatePicker::make('test')
            ->enabledDates(['2025-06-15']);
            
        $this->assertTrue($component->isDateEnabled('2025-06-15'));
        $this->assertFalse($component->isDateEnabled('15-06-2025'));
    }

    /** @test */
    public function it_handles_time_portion_gracefully(): void
    {
        $component = InlineDatePicker::make('test')
            ->enabledDates(['2025-06-15']);
            
        $this->assertTrue($component->isDateEnabled('2025-06-15 14:30:00'));
    }
}
