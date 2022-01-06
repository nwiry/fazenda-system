<?php

use App\Models\Cattle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * @version 1.0 - Primeira versão da API do Sistema
 */
Route::prefix('v1')->group(function () {
    /**
     * @api /api/v1/edit_cattle - Chama a função para editar o gado retornando a resposta da execução
     */
    Route::post('/edit_cattle', [Cattle::class, 'edit']);
    /**
     * @api /api/v1/list_cattle - Chama a função para listar os gados cadastrados retornando uma lista com os dados
     */
    Route::get('/list_cattle', [Cattle::class, 'list']);
    /**
     * @api /api/v1/list_slaughters - Chama a função para listar os animais que foram abatidos retornando uma lista com os dados
     */
    Route::get('/list_cattle_slaughters', [Cattle::class, 'list_slaughters']);
    /**
     * @api /api/v1/list_slaughters - Chama a função para listar os animais disponíeis para abate retornando uma lista com os dados
     */
    Route::get('/list_slaughters', [Cattle::class, 'slaughters']);
    /**
     * @api /api/v1/register_cattle - Chama a função para cadastrar o gado retornando a resposta da execução
     */
    Route::post('/register_cattle', [Cattle::class, 'register']);
    /**
     * @api /api/v1/slaughter_cattle - Chama a função para enviar o gado para abate retornando a resposta da execução
     */
    Route::post('/slaughter_cattle', [Cattle::class, 'slaughter']);
});
