<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;



Route::get('/', function () {
    return view('attendance.bac');
});


Route::post('/attendance', [AttendanceController::class, 'store']);
