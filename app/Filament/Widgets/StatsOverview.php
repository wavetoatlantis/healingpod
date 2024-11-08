<?php

namespace App\Filament\Widgets;

use App\Models\Pasien;
use App\Models\RiwayatTerapi;
use App\Models\Terapi;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $jumlahPasien = Pasien::owner()->count();
        $jumlahTerapi = Terapi::owner()->count();
        $jumlahRiwayatTerapi = RiwayatTerapi::owner()->count();
        return [
            Stat::make('Jumlah Pasien', $jumlahPasien),
            Stat::make('Jumlah Terapi', $jumlahTerapi),
            Stat::make('Jumlah Riwayat Terapi', $jumlahRiwayatTerapi),
        ];
    }
}
