<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected static bool $canCreateAnother = false;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
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
                            Forms\Components\TextInput::make("password")
                                ->label("Password")
                                ->placeholder("Password")
                                ->password()
                                ->required(),
                        ])
                ])
        );
    }
}
