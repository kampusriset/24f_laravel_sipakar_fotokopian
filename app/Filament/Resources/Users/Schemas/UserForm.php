<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun (Login)')
                    ->description('Digunakan untuk masuk ke dalam aplikasi.')
                    ->components([
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        
                        Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'kasir' => 'Kasir',
                            ])
                            ->required(),

                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->minLength(6),
                    ])->columns(2),

                Section::make('Data Profil Karyawan')
                    ->description('Informasi detail biodata karyawan.')
                    ->relationship('operator')
                    ->components([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }
}
