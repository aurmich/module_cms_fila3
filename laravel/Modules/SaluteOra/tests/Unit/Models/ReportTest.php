<?php

declare(strict_types=1);

use Modules\SaluteOra\Enums\DayFrequencyEnum;
use Modules\SaluteOra\Models\Report;

test('it correctly casts teeth brushing frequency to enum', function (): void {
        // Create a report with a teeth_brushing_frequency value
        $report = new Report([
            'teeth_brushing_frequency' => DayFrequencyEnum::DAILY->value,
        ]);

        // Assert that the attribute is an instance of DayFrequencyEnum
        $this->assertInstanceOf(DayFrequencyEnum::class, $report->teeth_brushing_frequency);
        $this->assertEquals(DayFrequencyEnum::DAILY, $report->teeth_brushing_frequency);
});

test('it correctly sets teeth brushing frequency using enum', function (): void {
        $report = new Report();
        $report->teeth_brushing_frequency = DayFrequencyEnum::TWICE_DAILY;

        // Assert that the attribute is an instance of DayFrequencyEnum
        $this->assertInstanceOf(DayFrequencyEnum::class, $report->teeth_brushing_frequency);
        $this->assertEquals(DayFrequencyEnum::TWICE_DAILY, $report->teeth_brushing_frequency);
});

test('it correctly serializes teeth brushing frequency to json', function (): void {
        $report = new Report([
            'teeth_brushing_frequency' => DayFrequencyEnum::OCCASIONALLY->value,
        ]);

        $json = $report->toArray();

        // Assert that the enum is serialized to its string value
        $this->assertIsString($json['teeth_brushing_frequency']);
        $this->assertEquals(DayFrequencyEnum::OCCASIONALLY->value, $json['teeth_brushing_frequency']);
});
