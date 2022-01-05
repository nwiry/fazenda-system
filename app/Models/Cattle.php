<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Cattle extends Model
{
    use HasFactory;

    /**
     * @param \Illuminate\Http\Request $request Obtem as requisições do HTTP para tratamento
     * @return array Retorna um array com o resultado da ação
     */
    public static function edit(Request $request)
    {
        try {
            DB::table('farm_cattle')->where('cattle_id')->update([
                'milk' => $request->input('cattle_milk'),
                'feed' => $request->input('cattle_feed'),
                'weight' => $request->input('cattle_weight'),
            ]);
            return ['status' => 'success'];
        } catch (\Illuminate\Database\QueryException $e) {
            return ['status' => 'warning', 'response' => $e->getMessage()];
        }
    }

    /**
     * @param \Illuminate\Http\Request $request Obtem as requisições do HTTP para tratamento
     * @return array Retorna um array com o resultado da ação
     */
    public static function register(Request $request): array
    {
        try {
            DB::table('farm_cattle')->insert([
                'code' => $request->input('cattle_code'),
                'milk' => $request->input('cattle_milk'),
                'feed' => $request->input('cattle_feed'),
                'weight' => $request->input('cattle_weight'),
                'birthday' => $request->input('cattle_birthday'),
            ]);
            return ['status' => 'success'];
        } catch (\Illuminate\Database\QueryException $e) {
            return ['status' => 'warning', 'response' => $e->getMessage()];
        }
    }
}
