<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasienResource\Pages;
use App\Filament\Resources\PasienResource\RelationManagers;
use App\Models\Pasien;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PasienResource extends Resource
{
    protected static ?string $model = Pasien::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $label = 'Pasien';
    protected static ?string $pluralLabel = 'Pasien';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("nama")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("kode")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("company.nama")
                    ->visible(auth()->user()->user_category_id == 1)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("tgl_lahir")
                    ->label("Tanggal Lahir")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("keterangan")
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
            ])
            ->modifyQueryUsing(fn(Builder $query) => auth()->user()->is_admin ? $query->where('company_id', '!=', null) : $query->where('company_id', auth()->user()->company_id));
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
            'index' => Pages\ListPasiens::route('/'),
            'create' => Pages\CreatePasien::route('/create'),
            'edit' => Pages\EditPasien::route('/{record}/edit'),
        ];
    }
}
