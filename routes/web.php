<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/profile/index', [ProfileController::class, 'profile'])->name('profile.index');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


//-------------------admin route----------------//
Route::get('admin/dashbord',[AdminController::class, 'dashbord'])->middleware('auth','role:admin')->name('admin.dashbord');

Route::get('admin/login',[AdminController::class, 'login'])->name('admin.login');


//------------------vendor route---------------//
Route::get('vendor/dashbord',[VendorController::class, 'dashbord'])->middleware('auth','role:vendor')->name('vendor.dashbord');

require __DIR__.'/auth.php';
