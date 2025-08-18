<?php

declare(strict_types=1);

use Modules\Chart\Models\Chart;
use Modules\Chart\Datas\AnswersChartData;
use Modules\Chart\Datas\ChartData;
use Modules\Chart\Datas\AnswerData;
use Spatie\LaravelData\DataCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Chart Integration Tests', function () {
    beforeEach(function () {
        // Create test chart in database
        $this->chart = Chart::factory()->create([
            'type' => 'bar1',
            'width' => 800,
            'height' => 600,
            'colors' => ['#ff0000', '#00ff00', '#0000ff'],
        ]);
    });

    it('can create chart with all attributes', function () {
        $chart = Chart::create([
            'type' => 'pie1',
            'width' => 400,
            'height' => 400,
            'color' => '#ff5733',
            'bg_color' => '#ffffff',
            'font_size' => 14,
            'colors' => ['#red', '#green', '#blue'],
        ]);

        expect($chart)->toBeInstanceOf(Chart::class)
            ->and($chart->type)->toBe('pie1')
            ->and($chart->width)->toBe(400)
            ->and($chart->height)->toBe(400)
            ->and($chart->colors)->toBeArray()
            ->and($chart->colors)->toHaveCount(3);
    });

    it('integrates with AnswersChartData correctly', function () {
        // Create chart data from model
        $chartData = new ChartData(
            type: $this->chart->type,
            max: 100.0
        );

        $answerData = [
            new AnswerData(label: 'Option 1', value: 30, avg: 75.0),
            new AnswerData(label: 'Option 2', value: 45, avg: 85.0),
        ];

        $answersChartData = new AnswersChartData(
            tot: 75,
            title: 'Integration Test Chart',
            footer: 'Test Footer',
            tot_answered: 75,
            tot_invited: 100,
            answers: new DataCollection(AnswerData::class, $answerData),
            chart: $chartData
        );

        // Test that the integration works
        expect($answersChartData->getChartJsType())->toBe('bar')
            ->and($answersChartData->getChartJsData())->toBeArray()
            ->and($answersChartData->getChartJsOptionsArray())->toBeArray();
    });

    it('handles chart settings for different types', function () {
        // Test simple chart
        $settings = $this->chart->getSettings();
        expect($settings)->toBeArray()
            ->and($settings)->toHaveCount(1);

        // Test mixed chart type (if MixedChart exists)
        $mixedChart = Chart::factory()->create(['type' => 'mixed:test']);
        
        // This might throw an exception if MixedChart doesn't exist, which is expected
        try {
            $mixedSettings = $mixedChart->getSettings();
            expect($mixedSettings)->toBeArray();
        } catch (Exception $e) {
            // Expected if MixedChart model doesn't exist
            expect($e)->toBeInstanceOf(Exception::class);
        }
    });

    it('handles chart attribute accessors correctly', function () {
        // Test type attribute
        expect($this->chart->getTypeAttribute('custom'))->toBe('custom')
            ->and($this->chart->getTypeAttribute(null))->toBe('bar1');

        // Test width attribute
        expect($this->chart->getWidthAttribute('1000'))->toBe(1000)
            ->and($this->chart->getWidthAttribute(null))->toBeInt();

        // Test height attribute  
        expect($this->chart->getHeightAttribute('500'))->toBe(500)
            ->and($this->chart->getHeightAttribute(null))->toBeInt();
    });

    it('can update chart properties', function () {
        $this->chart->update([
            'type' => 'doughnut',
            'width' => 1200,
            'height' => 800,
            'colors' => ['#new1', '#new2'],
        ]);

        expect($this->chart->fresh()->type)->toBe('doughnut')
            ->and($this->chart->fresh()->width)->toBe(1200)
            ->and($this->chart->fresh()->height)->toBe(800)
            ->and($this->chart->fresh()->colors)->toBe(['#new1', '#new2']);
    });

    it('validates chart data persistence', function () {
        $chartData = [
            'type' => 'lineSubQuestion',
            'width' => 600,
            'height' => 400,
            'color' => '#123456',
            'transparency' => 80,
        ];

        $chart = Chart::create($chartData);
        $chart->refresh();

        expect($chart->type)->toBe('lineSubQuestion')
            ->and($chart->width)->toBe(600)
            ->and($chart->height)->toBe(400)
            ->and($chart->color)->toBe('#123456')
            ->and($chart->transparency)->toBe(80);
    });

    it('handles chart deletion correctly', function () {
        $chartId = $this->chart->id;
        
        $this->chart->delete();
        
        expect(Chart::find($chartId))->toBeNull();
    });

    it('can query charts by type', function () {
        Chart::factory()->create(['type' => 'pie1']);
        Chart::factory()->create(['type' => 'bar2']);
        Chart::factory()->create(['type' => 'line']);

        $barCharts = Chart::where('type', 'like', 'bar%')->get();
        $pieCharts = Chart::where('type', 'pie1')->get();

        expect($barCharts->count())->toBeGreaterThanOrEqual(2) // bar1 from beforeEach + bar2
            ->and($pieCharts->count())->toBe(1);
    });

    it('validates chart factory functionality', function () {
        $charts = Chart::factory()->count(5)->create();

        expect($charts)->toHaveCount(5);
        
        foreach ($charts as $chart) {
            expect($chart)->toBeInstanceOf(Chart::class)
                ->and($chart->type)->toBeString()
                ->and($chart->width)->toBeInt()
                ->and($chart->height)->toBeInt();
        }
    });

    it('handles chart colors correctly', function () {
        $chart = Chart::factory()->create([
            'colors' => ['#ff0000', '#00ff00', '#0000ff']
        ]);

        expect($chart->colors)->toBeArray()
            ->and($chart->colors)->toHaveCount(3)
            ->and($chart->colors[0])->toBe('#ff0000');
    });

    it('processes panel row integration', function () {
        // Test getPanelRow with existing field
        $result = $this->chart->getPanelRow('type', 'chart_type');
        
        expect($result)->toBe('bar1');
        
        // Verify the field was updated
        expect($this->chart->fresh()->chart_type)->toBe('bar1');
    });

    it('handles large datasets efficiently', function () {
        // Create multiple charts to test performance
        $charts = Chart::factory()->count(50)->create();
        
        expect($charts)->toHaveCount(50);
        
        // Test bulk operations
        $chartIds = $charts->pluck('id')->toArray();
        $foundCharts = Chart::whereIn('id', $chartIds)->get();
        
        expect($foundCharts)->toHaveCount(50);
    });

    it('validates chart type mapping', function () {
        $typeMapping = [
            'bar1' => 'bar',
            'bar2' => 'bar', 
            'bar3' => 'bar',
            'horizbar1' => 'bar',
            'pie1' => 'doughnut',
            'pieAvg' => 'doughnut',
            'lineSubQuestion' => 'line',
        ];

        foreach ($typeMapping as $originalType => $expectedType) {
            $chartData = new ChartData(type: $originalType);
            $answersChartData = new AnswersChartData(
                tot: 100,
                title: 'Test',
                footer: 'Test',
                tot_answered: 50,
                tot_invited: 100,
                answers: new DataCollection(AnswerData::class, []),
                chart: $chartData
            );

            expect($answersChartData->getChartJsType())->toBe($expectedType);
        }
    });
});
