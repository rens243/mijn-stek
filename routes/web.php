<?php

use App\Http\Controllers\AuthController;
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

Route::name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->name('login');
//    Route::get('/register', [AuthController::class, 'register'])
//        ->name('register');
});

Route::get('/', function () {
    return view('svelte-app');
});

Route::get('/bcae', function () {
    return redirect('https://www.instagram.com/bread.clips.are.everywhere/');
});
