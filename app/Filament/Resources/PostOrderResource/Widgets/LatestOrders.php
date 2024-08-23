<?php

namespace App\Filament\Resources\PostOrderResource\Widgets;

use App\Filament\Resources\PostOrderResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = "full";
    public function table(Table $table): Table
    {
        return $table
            ->query(PostOrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(10)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('order.code_order')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('order.items')
                    ->label('Ordered Items')
                    ->html() // Enabling HTML rendering
                    ->getStateUsing(function ($record) {
                        return $record->order->items->map(function($item) {
                            $imageUrl = asset('storage/' . $item->product->img); // Assuming the image is stored in the storage folder
                            return '<div>' .
                                ' <img src="' . $imageUrl . '" style="width: 50px; height: 50px; object-fit: cover;">' .
                                ' Qty: ' . $item->qty . '</div>';
                        })->implode('<br>');
                    }),
                Tables\Columns\TextColumn::make('date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('resi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_paket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }
}
