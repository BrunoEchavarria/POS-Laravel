<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\precentacionesController;
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
    return view('template');
})->name('home');

Route::view('/panel','panel.index')->name('panel');

Route::resources([
    'categorias' => categoriaController::class,
    'marca'=> marcaController::class,
    'presentaciones' => precentacionesController::class
]);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/404', function () {
    return view('pages.404');
})->name('Error-404');

Route::get('/401', function () {
    return view('pages.401');
})->name('Error-401');

Route::get('/500', function () {
    return view('pages.500');
})->name('Error-500');

