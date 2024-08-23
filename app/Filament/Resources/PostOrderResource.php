<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostOrderResource\Pages;
use App\Filament\Resources\PostOrderResource\RelationManagers;
use App\Models\PostOrder;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\Imports\ImportColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;


class PostOrderResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = PostOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_id')
                    ->required()
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('date')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Forms\Components\TextInput::make('resi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status_paket')
                    ->required()
                    ->options([
                        'Dalam Proses' => 'Dalam Proses',
                        'Sudah Dikirim' => 'Sudah Dikirim',
                    ])
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.code_order')
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\Order::class,
            // RelationManagers\Cart::class,
            // RelationManagers\Customer::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPostOrders::route('/'),
            'create' => Pages\CreatePostOrder::route('/create'),
            'edit' => Pages\EditPostOrder::route('/{record}/edit'),
        ];
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
            'publish'
        ];
    }
}
