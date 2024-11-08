<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms;


use Filament\Forms\Get;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return parent::form(
            $form
                ->schema([
                    Forms\Components\Section::make("Informasi User")
                        ->schema([
                            Forms\Components\TextInput::make("name")
                                ->label("Nama")
                                ->placeholder("Nama")
                                ->required(),
                            Forms\Components\Select::make("company_id")
                                ->label("Company")
                                ->placeholder("Pilih Company")
                                ->required()
                                ->options(
                                    \App\Models\Company::all()->pluck('nama', 'id')
                                ),
                            Forms\Components\TextInput::make("email")
                                ->label("Email")
                                ->placeholder("Email")
                                ->email()
                                ->required(),
                            Forms\Components\Toggle::make("change_password")
                                ->reactive(),
                            Forms\Components\TextInput::make("password")
                                ->hidden(fn (Get $get) => !$get('change_password'))
                                ->label("Password")
                                ->placeholder("Password")
                                ->password()
                                ->required(),
                        ])
                ])
        );
    }

}
