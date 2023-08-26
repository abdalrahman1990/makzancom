<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\SubcategoryController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\Admin\UserController;
use App\DataTables\AdvertisementDataTable;
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



//-------------------Admin route----------------//

Route::get('/dashbord',[AdminController::class, 'dashbord'])->name('dashbord');

//------------------Categories------------------//

Route::resource('category', CategoryController::class);

Route::post('category/{id}/toggleStatus', [CategoryController::class, 'toggleStatus'])->name('category.toggleStatus');

//------------------Sub-Categories------------------//

Route::resource('subcategory', SubcategoryController::class);

Route::post('subcategory/{id}/toggleStatus', [SubcategoryController::class, 'toggleStatus'])->name('subcategory.status');

//------------------Advertisements------------------//

// Display the list of advertisements (DataTable)
Route::get('/advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');

// Display the form to create a new advertisement
Route::get('/advertisements/create', [AdvertisementController::class, 'create'])->name('advertisements.create');

// Store a new advertisement
Route::post('/advertisements', [AdvertisementController::class, 'store'])->name('advertisements.store');

// Display the form to edit an existing advertisement
Route::get('/advertisements/{advertisement}/edit', [AdvertisementController::class, 'edit'])->name('advertisements.edit');

// Update an existing advertisement
Route::put('/advertisements/{advertisement}', [AdvertisementController::class, 'update'])->name('advertisements.update');

// Delete an advertisement
Route::delete('/advertisements/{advertisement}', [AdvertisementController::class, 'destroy'])->name('advertisements.destroy');

// Serve the data for the DataTable. This could be merged with the index route based on the AJAX request, but having a separate route can be cleaner.
Route::post('/advertisements/data', [AdvertisementController::class, 'dataTable'])->name('advertisements.data');


// Route::post('/advertisements/data', [AdvertisementController::class, 'dataTable'])->name('advertisements.data'); // This route will serve the data for the datatable.

//------------------Users------------------//

Route::resource('users',UserController::class);


