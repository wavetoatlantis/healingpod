<?php

namespace App\Filament\Resources\PasienResource\Pages;

use App\Filament\Resources\PasienResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;


class CreatePasien extends CreateRecord
{
    protected static string $resource = PasienResource::class;
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

    public function form(Form $form): Form
    {
        return parent::form($form
            ->schema([
                Forms\Components\Section::make("Informasi Pasien")
                    ->schema([
                        Forms\Components\TextInput::make("nama")
                            ->placeholder("Nama Pasien")
                            ->required(),
                        Forms\Components\TextInput::make("kode")
                            ->placeholder("Kode Pasien")
                            ->label("Kode Pasien")
                        ,
                        Forms\Components\Select::make("company_id")
                            ->label("Company")
                            ->placeholder("Pilih Company")
                            ->visible(auth()->user()->is_admin)
                            ->options(
                                \App\Models\Company::all()->pluck('nama', 'id')
                            ),
                        Forms\Components\DatePicker::make("tgl_lahir")
                            ->label("Tanggal Lahir")
                            ->placeholder("Tanggal Lahir")
                            ->required(),
                        Forms\Components\Textarea::make("keterangan")
                            ->placeholder("Keterangan")
                    ])
            ]));
    }

}
