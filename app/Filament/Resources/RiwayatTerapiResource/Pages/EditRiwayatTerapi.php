<?php

namespace App\Filament\Resources\RiwayatTerapiResource\Pages;

use App\Filament\Resources\RiwayatTerapiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiwayatTerapi extends EditRecord
{
    protected static string $resource = RiwayatTerapiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
