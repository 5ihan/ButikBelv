<?php

namespace App\Filament\Resources\PostOrderResource\Widgets;

use Carbon\Carbon;
use Filament\Widgets\LineChartWidget;
use App\Models\Order;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;


class ChartOrder extends LineChartWidget
{
    protected static ?string $heading = 'Sales per Month';

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Sales',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(function (TrendValue $value) {
                $date = Carbon::createFromFormat('Y-m',$value->date);
                $formatedDate = $date->format('M');

                return $formatedDate;
            }),
        ];
    }
}
