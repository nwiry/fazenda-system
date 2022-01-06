<?php

use App\Http\Controllers\FarmPages;
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

// Página Inicial
Route::any('/', [FarmPages::class, 'dashboard']);
// Cadastro de Animal
Route::any('/new_cattle', [FarmPages::class, 'new_cattle']);
// Listagem de Animais
Route::any('/list_cattle', [FarmPages::class, 'list_cattle']);
// Listagem de Animais Abatidos
Route::any('/list_slaughters', [FarmPages::class, 'list_slaughters']);