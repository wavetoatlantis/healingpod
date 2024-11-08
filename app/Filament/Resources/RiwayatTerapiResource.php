<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiwayatTerapiResource\Pages;
use App\Models\RiwayatTerapi;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;


class RiwayatTerapiResource extends Resource
{
    protected static ?string $model = RiwayatTerapi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $label="Riwayat Terapi";
    protected static ?string $pluralLabel = "Riwayat Terapi";

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
//                Tables\Columns\TextColumn::make("terapi_id")
//                    ->label("ID Terapi")
//                    ->searchable()
//                    ->sortable(),
                Tables\Columns\TextColumn::make("pasien.nama")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("game.nama")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("lama_terapi")
                    ->formatStateUsing(function ($state) {
                        return gmdate("H:i:s", $state);
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("tgl_terapi")
                    ->label("Tanggal Terapi")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("point")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("jarak")
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
//                Tables\Filters\SelectFilter::make("pasien_id")
//                    ->label("Pasien")
//                    ->placeholder("Pilih Pasien")
//                    ->options(
//                        \App\Models\Pasien::all()->pluck('nama', 'id')
//                    ),
                Filter::make('tgl_terapi')
                    ->form([
                        DatePicker::make('start_date'),
                        DatePicker::make('end_date')
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_terapi', '>=', $date),
                            )
                            ->when(
                                $data['end_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tgl_terapi', '<=', $date),
                            );
                    })
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];

                        if ($data['start_date'] ?? null) {
                            $indicators['start_date'] = 'Dari ' . Carbon::parse($data['start_date'])->toFormattedDateString();
                        }

                        if ($data['end_date'] ?? null) {
                            $indicators['end_date'] = 'Sampai ' . Carbon::parse($data['end_date'])->toFormattedDateString();
                        }

                        return $indicators;
                    })
                ,

            ])
            ->actions([
            ])
            ->bulkActions([
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()
                        ->withFilename(function ( $livewire) {
                        $tableFilter = $livewire->tableFilters['tgl_terapi'];
                        $date_start = $tableFilter['start_date'];
                        $date_end = $tableFilter['end_date'];
                        $fileName = "Riwayat Terapi";
                        if ($date_start) {
                            $fileName = $fileName . '-' . Carbon::parse($date_start)->format('Y-m-d');
                        }
                        if ($date_end) {
                            $fileName = $fileName . '-' . Carbon::parse($date_end)->format('Y-m-d');
                        }
                        return $fileName . '.xlsx';
                    })->fromTable()

                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => auth()->user()->is_admin ? $query->where('pasien_id', '!=', null) : $query->whereHas('pasien', fn(Builder $query) => $query->where('company_id', auth()->user()->company_id)));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatTerapis::route('/'),
        ];
    }
}
