<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'), 
                TextColumn::make('sku'), 
                TextColumn::make('price'), 
                TextColumn::make('stock'), 
                ImageColumn::make('image') 
                    ->disk('public'), 

                TextColumn::make('is_active')
                    ->label('Status Aktif')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Tidak Aktif') // Mengubah 1/0 jadi teks
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'), // Hijau untuk aktif, Merah untuk tidak            
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
