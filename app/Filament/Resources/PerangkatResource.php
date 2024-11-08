<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerangkatResource\Pages;
use App\Filament\Resources\PerangkatResource\RelationManagers;
use App\Models\Perangkat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerangkatResource extends Resource
{
    protected static ?string $model = Perangkat::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $label = 'Perangkat';
    protected static ?string $pluralLabel = 'Perangkat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        Forms\Components\Select::make("company_id")
                            ->label("Company")
                            ->placeholder("Pilih Company")
                            ->visible(auth()->user()->is_admin)
                            ->options(
                                \App\Models\Company::all()->pluck('nama', 'id')
                            ),
                        Forms\Components\TextInput::make("serial_number")
                            ->placeholder("Nomor Serial")
                            ->label("Nomor Serial")
                            ->required(),
                    ])
            ]) ;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("company.nama")
                    ->visible(auth()->user()->is_admin)
                    ->label("Company")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("serial_number")
                    ->label("Nomor Serial")
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListPerangkats::route('/'),
            'create' => Pages\CreatePerangkat::route('/create'),
            'edit' => Pages\EditPerangkat::route('/{record}/edit'),
        ];
    }
}
