<?php

use App\Livewire\Appointment;
use App\Livewire\HomePage;
use App\Livewire\Login;
use App\Livewire\Register;
use App\Livewire\TrackStatus;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class);
Route::get('/appointment', Appointment::class);
Route::get('/track-status', TrackStatus::class);
Route::get('/register', Register::class);
Route::get('/login', Login::class);
