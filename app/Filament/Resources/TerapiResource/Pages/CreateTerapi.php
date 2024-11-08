<?php

namespace App\Filament\Resources\TerapiResource\Pages;

use App\Filament\Resources\TerapiResource;
use App\Models\Pasien;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;

class CreateTerapi extends CreateRecord
{
    protected static string $resource = TerapiResource::class;
    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function form(Form $form): Form
    {
        return parent::form($form
            ->schema([
                Forms\Components\Section::make("Informasi Terapi")
                    ->schema([
                        Forms\Components\Select::make("pasien_id")
                            ->label("Pasien")
                            ->placeholder("Pilih Pasien")
                            ->required()
                            ->options(
                                Pasien::owner()->pluck('nama', 'id')
                            ),
                        Forms\Components\DatePicker::make("tgl_terapi")
                            ->label("Tanggal Terapi")
                            ->placeholder("Tanggal Terapi")
                            ->required(),
                        Forms\Components\Textarea::make("keterangan_sebelum_terapi")
                            ->required()
                            ->placeholder("Keterangan Sebelum Terapi"),
                    ])
            ]));
    }
}
