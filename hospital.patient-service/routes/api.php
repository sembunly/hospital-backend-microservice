<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::post('/patients', [PatientController::class, 'store']);

Route::get('/addresses/provinces', [AddressController::class, 'provinces'])
    ->name('addresses.provinces');
Route::get('/addresses/provinces/{province}/districts', [AddressController::class, 'districts'])
    ->name('addresses.districts');
Route::get('/addresses/districts/{district}/communes', [AddressController::class, 'communes'])
    ->name('addresses.communes');
Route::get('/addresses/communes/{commune}/villages', [AddressController::class, 'villages'])
    ->name('addresses.villages');
