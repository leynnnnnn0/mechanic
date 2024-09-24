<?php

namespace App\Filament\Auth;

use Filament\Facades\Filament;
use Filament\Pages\Auth\Login as BaseAuth;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CustomLogin extends BaseAuth
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

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.username' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        $credentials = $this->getCredentialsFromFormData($this->form->getState());

        if (!Auth::guard('customer')->attempt($credentials)) {
            $this->throwFailureValidationException();
        }

        $user = Auth::guard('customer')->user();
        Auth::guard('customer')->login($user);

        session()->regenerate();
        return app(LoginResponse::class);
    }


    protected function getAuthGuard(): string
    {
        return 'customer';
    }
}
