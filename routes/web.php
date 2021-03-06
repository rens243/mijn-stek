<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\HouseController;
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
    return view('svelte-app');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/bcae', function () {
    return redirect('https://www.instagram.com/bread.clips.are.everywhere/');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function() {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Houses
    Route::prefix('houses/')->name('houses.')->group(function () {
        Route::resource('estate', EstateController::class);
    });
    Route::resource('houses', HouseController::class)->only([
        'index',
    ]);

});
