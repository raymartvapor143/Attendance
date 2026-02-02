<?php


use App\Http\Controllers\AdminController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;




Route::get('/', function () {
    return view('attendance.bac');
});

// Route::get('/', function () {
//     return view('attendance.bac');
// });




Route::post('/attendance', [AttendanceController::class, 'store'])
    ->name('attendance.store')
    ->middleware('web'); // Keep web middleware if using CSRF





Route::get('/bac-attendance', [AttendanceController::class, 'bac'])->name('bac.attendance');

Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::post('/admin/controllers/{controller}/toggle', [AdminController::class, 'toggleController']);

