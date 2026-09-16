<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

Route::get('/patients', [PatientController::class, 'index']);
Route::post('/patients', [PatientController::class, 'store']);
Route::get('/patients/{patient}', [PatientController::class, 'show']);
Route::match(['put', 'patch'], '/patients/{patient}', [PatientController::class, 'update']);
Route::delete('/patients/{patient}', [PatientController::class, 'destroy']);

Route::get('/addresses/provinces', [AddressController::class, 'provinces'])
    ->name('addresses.provinces');
Route::get('/addresses/provinces/{province}/districts', [AddressController::class, 'districts'])
    ->name('addresses.districts');
Route::get('/addresses/districts/{district}/communes', [AddressController::class, 'communes'])
    ->name('addresses.communes');
Route::get('/addresses/communes/{commune}/villages', [AddressController::class, 'villages'])
    ->name('addresses.villages');
