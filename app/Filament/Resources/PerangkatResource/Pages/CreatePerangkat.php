<?php

namespace App\Filament\Resources\PerangkatResource\Pages;

use App\Filament\Resources\PerangkatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePerangkat extends CreateRecord
{
    protected static string $resource = PerangkatResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if(!auth()->user()->is_admin){
            $data['company_id'] = auth()->user()->company_id;
        }
        return $data;
    }
}
