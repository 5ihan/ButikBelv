<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Customer;


class CountCustomer extends BaseWidget
{
    protected function getStats(): array
    {
        $totalCustomers = Customer::count();
        return [
            Stat::make('Total Customers', $totalCustomers)
        ];
    }
}
