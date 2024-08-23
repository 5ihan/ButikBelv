<?php

namespace App\Filament\Resources\PostOrderResource\Pages;

use App\Filament\Resources\PostOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPostOrders extends ListRecords
{
    protected static string $resource = PostOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
