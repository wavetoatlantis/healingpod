<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TerapiResource\Pages;
use App\Filament\Resources\TerapiResource\RelationManagers;
use App\Models\Terapi;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TerapiResource extends Resource
{
    protected static ?string $model = Terapi::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $label = 'Terapi';
    protected static ?string $pluralLabel = 'Terapi';
    protected static ?string $navigationLabel = 'Terapi';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("pasien.nama")
                    ->label("Pasien")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("tgl_terapi")
                    ->label("Tanggal Terapi")
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\Action::make('update_keterangan_setelah_terapi')
                    ->label("Update Setelah Terapi")
                    ->color("success")
                    ->icon("heroicon-o-shield-check")
                    ->fillForm(fn(Terapi $record): array => [
                        'keterangan_sebelum_terapi' => $record->keterangan_sebelum_terapi,
                        'keterangan_setelah_terapi' => $record->keterangan_setelah_terapi,
                    ])
                    ->form([
                        Forms\Components\Textarea::make("keterangan_sebelum_terapi")
                            ->disabled()
                            ->placeholder("Keterangan Sebelum Terapi"),
                        Forms\Components\Textarea::make("keterangan_setelah_terapi")
                            ->placeholder("Keterangan Setelah Terapi"),
                    ])
                    ->action(function (array $data, Terapi $record): void {
                        $record->update($data);
                    })
                    ->after(function () {
                        Notification::make()
                            ->title("Saved Successfully")
                            ->success()
                            ->send();
                    })
                ,
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
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
            'index' => Pages\ListTerapis::route('/'),
            'create' => Pages\CreateTerapi::route('/create'),
            'edit' => Pages\EditTerapi::route('/{record}/edit'),
        ];
    }
}
