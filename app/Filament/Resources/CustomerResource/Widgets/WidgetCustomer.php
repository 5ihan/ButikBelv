<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WidgetCustomer extends BaseWidget
{
    public ?User $record;


    protected function getStats(): array
    {
        return [
            Stat::make('Total Customers', $this->record->posts()->count()),
        ];
    }
}
