<?php

namespace App\Filament\Resources\RiwayatTerapiResource\Pages;

use App\Filament\Resources\RiwayatTerapiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatTerapis extends ListRecords
{
    protected static string $resource = RiwayatTerapiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
