<?php

namespace App\Filament\Resources\TerapiResource\Pages;

use App\Filament\Resources\TerapiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTerapis extends ListRecords
{
    protected static string $resource = TerapiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
