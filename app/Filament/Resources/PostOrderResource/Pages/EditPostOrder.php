<?php

namespace App\Filament\Resources\PostOrderResource\Pages;

use App\Filament\Resources\PostOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPostOrder extends EditRecord
{
    protected static string $resource = PostOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
