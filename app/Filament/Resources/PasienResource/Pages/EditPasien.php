<?php

namespace App\Filament\Resources\PasienResource\Pages;

use App\Filament\Resources\PasienResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Pages\EditRecord;

class EditPasien extends EditRecord
{
    protected static string $resource = PasienResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
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
                            ->disabled(),
                        Forms\Components\Select::make("company_id")
                            ->label("Company")
                            ->visible(auth()->user()->is_admin)
                            ->placeholder("Pilih Company")
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
