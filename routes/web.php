<?php

use App\Livewire\Appointment;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/appointment', Appointment::class);
