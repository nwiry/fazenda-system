<?php

namespace App\Http\Controllers;

use App\Models\Cattle;
use Illuminate\Http\Request;

class FarmPages extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Retorna a view com o layout inicial e variáveis
     */
    public static function dashboard()
    {
        return view('dashboard', ['nums_cattle' => Cattle::sum_cattles()]);
    }
    
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Retorna a view com o layout de edição de animal e variáveis
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Retorna erro 404 caso nao exista o aniaml para edição
     */
    public static function edit_cattle(Request $request)
    {
        $searchCattle = Cattle::search($request);
        return $searchCattle['status'] ? view('edit_cattle', ['cattleInfo' => $searchCattle['data']]) : abort(404);
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Retorna a view com o layout de cadastro de animais
     */
    public static function new_cattle()
    {
        return view('new_cattle');
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Retorna a view com o layout da listagem de animais
     */
    public static function list_cattle()
    {
        return view('list_cattle');
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory Retorna a view com o layout da listagem de animais que foram abatidos
     */
    public static function list_slaughters()
    {
        return view('list_slaughters');
    }
}
