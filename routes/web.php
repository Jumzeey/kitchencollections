<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
//protected routes for admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout',[AdminController::class, 'AdminDestroy'])->name('admin.logout');
    Route::get('/admin/profile', [ProfileController::class, 'Profile'])->name('admin.profile');
    Route::post('/admin/profile/update', [ProfileController::class, 'ProfileStore'])->name('admin.profile.store');
});

//protected routes for vendors
Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor/dashboard',[VendorController::class, 'VendorDashboard'])->name('vendor.dashboard');
});
//web routes
Route::get('/admin/login',[AdminController::class, 'AdminLogin']);

