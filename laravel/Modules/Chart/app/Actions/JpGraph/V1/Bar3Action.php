<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Plot\AccBarPlot;
use Amenadiel\JpGraph\Plot\BarPlot;
use Amenadiel\JpGraph\Text\Text;
use Modules\Chart\Actions\JpGraph\ApplyPlotStyleAction;
use Modules\Chart\Actions\JpGraph\GetGraphAction;
use Modules\Chart\Datas\AnswerData;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

class Bar3Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $chart = $answersChartData->chart;
        $answers = $answersChartData->answers;
        $graph = app(GetGraphAction::class)->execute($chart);
        $graph->img->SetMargin(50, 50, 50, 100);
        $labels = $answers->toCollection()->pluck('label')->all();
        $datay = $answers->toCollection()->pluck('value')->all();
        $datay1 = $answers->toCollection()->pluck('value1')->all();
        // $legends = collect(collect($datay)->first())->keys()->all();
        $answers_first = $answers->first();
        Assert::isInstanceOf($answers_first, AnswerData::class);
        $legends = [];
        $valueArray = SafeArrayCastAction::cast($answers_first->value);
        if (!empty($valueArray)) {
            $legends = array_keys($valueArray);
        }

        // dddx(['legends' => $legends, 'labels' => $labels, 'datay' => $datay, 'datay1' => $datay1]);

        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels($labels);
        $graph->xaxis->SetLabelAngle($chart->x_label_angle);

        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);

        $graph->yscale->ticks->SupressZeroLabel(false);

        // Create the bar plots
        $colors = explode(',', $chart->list_color);
        $bplot = [];
        $value_pos = ['bottom', 'top'];

        foreach ($legends as $k => $legend) {
            $tmp_data = array_column($datay, $legend);
            $tmp = new BarPlot($tmp_data);
            $tmp = app(ApplyPlotStyleAction::class)->execute($tmp, $chart);

            $tmp->SetValuePos($value_pos[$k]);
            $tmp->SetColor($colors[$k]);
            $tmp->SetFillColor($colors[$k].'@'.$chart->transparency); // trasparenza da 0 a 1

            $tmp->SetLegend($legend);

            $bplot[] = $tmp;
        }

        // Create the grouped bar plot
        $accBarPlot = new AccBarPlot($bplot);
        $accBarPlot->SetWidth($chart->plot_perc_width / 100);
        // ...and add it to the graPH
        $graph->Add($accBarPlot);

        if (\count($datay) > 1) {
            // dddx($this->data->first()['title_type']);
            // dddx($this->vars['title']);
            $title = $chart->title;

            // $subtitle = 'Totale rispondenti';
            $graph->title->Set($title);
            $graph->title->SetFont($chart->font_family, $chart->font_style, 11);
        }

        // Controllo sicuro per la proprietà totali che potrebbe essere aggiunta dinamicamente
        $totaliArray = SafeArrayCastAction::cast($chart->totali ?? null);
        if (!empty($totaliArray)) {
            $str = '';
            foreach ($totaliArray as $k => $v) {
                $kString = SafeStringCastAction::cast($k);
                $vString = SafeStringCastAction::cast($v);
                $str .= $kString.' '.$vString.' - ';
            }

            $graph->footer->center->Set($str);
            $graph->footer->center->SetFont($chart->font_family, $chart->font_style, 11);
        }

        // cifre sopra il grafico
        $delta = ($chart->width - 100) / \count($datay1);

        $datay1Array = SafeArrayCastAction::cast($datay1);
        if (!empty($datay1Array)) {
            foreach ($datay1Array as $i => $v) {
                $txt = new Text('');
                $vArray = SafeArrayCastAction::cast($v);
                if (isset($vArray[0])) {
                    $v0String = SafeStringCastAction::cast($vArray[0]);
                    $txt = new Text($v0String);
                }

                $x = 50 + ($delta * $i) + ($delta / 3);
                $txt->SetPos($x, 20);
                $graph->AddText($txt);

                $txt2 = new Text('');
                if (isset($vArray[1])) {
                    $v1String = SafeStringCastAction::cast($vArray[1]);
                    $txt2 = new Text($v1String);
                }

                $txt2->SetPos($x, 35);
                $graph->AddText($txt2);
            }
        }

        return $graph;
    }
}
