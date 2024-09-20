<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseAuth;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;

class CustomerLogin extends BaseAuth
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getUsernameFormComponent(),
                $this->getPasswordFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromForm(): array
    {
        return [
            'username' => $this->getState()['username'],
            'password' => $this->getState()['password'],
        ];
    }

    // public function authenticate(): void
    // {
    //     $this->rateLimit(5);

    //     $credentials = $this->getCredentialsFromForm();

    //     if (! auth('customer')->attempt($credentials)) {
    //         $this->addError('data.username', __('filament-panels::pages/auth/login.messages.failed'));
    //         return;
    //     }

    //     $this->session()->regenerate();

    //     $this->redirect(static::getRedirectUrl());
    // }
}