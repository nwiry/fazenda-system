<?php

namespace App\Models;

use Exception;
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
    public static function del_cattle(Request $request)
    {
        try {
            DB::table('farm_cattle')->where('id', '=', $request->input('cattle_id'))->delete();
            return ['status' => 'success'];
        } catch (\Illuminate\Database\QueryException $e) {
            return ['status' => 'warning', 'response' => $e->getMessage()];
        }
    }

    /**
     * @param \Illuminate\Http\Request $request Obtem as requisições do HTTP para tratamento
     * @return array Retorna um array com o resultado da ação
     */
    public static function edit(Request $request)
    {
        try {
            DB::table('farm_cattle')->where('cattle_id', '=', $request->input('cattle_id'))->update([
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
     * @return array|\Exception Retorna um array com os dados ou uma exceção caso haja problema com o banco de dados
     */
    public static function list()
    {
        try {
            $list = DB::table('farm_cattle')->get();
            foreach ($list as $key => $value) {
                $list[$key]->full_date = $list[$key]->birth_month . '/' . $list[$key]->birth_year;
                $list[$key]->actions = '<button class="btn btn-primary" style="margin-right: 5px;" onclick="(window.location.href=\'/edit_cattle?cattle_id=' . $list[$key]->id . '\')">Editar</button>
                <button class="btn btn-danger" onclick="slaughter(this, ' . $list[$key]->id . ', \'' . $list[$key]->code . '\')">Enviar para abate</button>';
            }
            return [
                'draw' => 1,
                'recordsTotal' => $list->count(),
                'recordsFiltered' => $list->count(),
                'data' => $list
            ];
        } catch (\Illuminate\Database\QueryException $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    /**
     * @return array|\Exception Retorna um array com os dados ou uma exceção caso haja problema com o banco de dados
     */
    public static function list_slaughters()
    {
        try {
            $list = DB::table('farm_cattle_slaughter')->get();
            foreach ($list as $key => $value) {
                $oldData = json_decode($list[$key]->json_data);
                $oldData->full_date = $oldData->birth_month . '/' . $oldData->birth_year;
                $data[] = $oldData;
            }
            return [
                'draw' => 1,
                'recordsTotal' => $list->count(),
                'recordsFiltered' => $list->count(),
                'data' => $data
            ];
        } catch (\Illuminate\Database\QueryException $th) {
            throw new Exception($th->getMessage(), 500);
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
                'birth_month' => $request->input('cattle_birth_month'),
                'birth_year' => $request->input('cattle_birth_year'),
            ]);
            return ['status' => 'success'];
        } catch (\Illuminate\Database\QueryException $e) {
            return ['status' => 'warning', 'response' => $e->getMessage()];
        }
    }

    /**
     * @param \Illuminate\Http\Request $request Obtem as requisições do HTTP para tratamento
     * @param string $search Tipo de busca
     * @return array|\Exception Retorna um array com o resultado da requisição ou uma exceçãoi caso haja algum problema com o banco de dados
     */
    public static function search(Request $request, string $search = 'id')
    {
        try {
            $search = DB::table('farm_cattle')->where($search, '=', $request->input('cattle_id'))->get();
            return isset($search[0]) ? ['status' => true, 'data' => $search[0]] : ['status' => false];
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    /**
     * @return array|\Exception Retorna um array com o resultado da ação retorna uma exceção caso haja algum problema com o banco de dados
     */
    public static function slaughter(Request $request)
    {
        try {
            DB::table('farm_cattle_slaughter')->insert([
                'json_data' => json_encode(self::visualization($request)[0])
            ]);
            self::del_cattle($request);
            return ['status' => 'success'];
        } catch (\Illuminate\Database\QueryException $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    /**
     * @return array|\Exception Retorna os animais disponíveis para abate, seguindo as condições:
     * (Possui mais de 5 anos de idade, produz menos de 40l de leite, produz menos de 70l de leite e ingere mais de 50kg de ração por dia, possui peso maior que 18@).
     * Ou retorna uma exceção caso haja algum problema com o banco de dados
     */
    public static function slaughters()
    {
        try {
            $slaughters = DB::table('farm_cattle')
                ->whereRaw('? - birth_year >= 5', [date('Y')])
                ->orWhere('milk', '<', 40)
                ->orWhereRaw('milk < 70 and feed > 50')
                ->orWhere('weight', '>', '270')
                ->get();
            foreach ($slaughters as $key => $value) {
                $slaughters[$key]->full_date = $slaughters[$key]->birth_month . '/' . $slaughters[$key]->birth_year;
                $slaughters[$key]->actions = '<button class="btn btn-danger" onclick="slaughter(this, ' . $slaughters[$key]->id . ', \'' . $slaughters[$key]->code . '\')">Enviar para abate</button>';
            }
            return [
                'draw' => 1,
                'recordsTotal' => $slaughters->count(),
                'recordsFiltered' => $slaughters->count(),
                'data' => $slaughters
            ];
        } catch (\Illuminate\Database\QueryException $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    /**
     * @return array|\Exception Retorna o número da contagem de tabelas por animal ou retorna uma exceção caso haja algum problema com o banco de dados
     */
    public static function sum_cattles()
    {
        try {
            $cattle = DB::table('farm_cattle')->get();
            return [
                'num_milk' => $cattle->sum('milk'),
                'num_feed' => $cattle->sum('feed'),
                'slaughters' => DB::table('farm_cattle_slaughter')->get()->count()
            ];
        } catch (\Illuminate\Database\QueryException $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request Obtem as requisições do HTTP para tratamento
     * @return object|\Exception Retorna um objeto com o resultado ou uma exceção caso haja problema com o banco de dados
     */
    public static function visualization(Request $request)
    {
        try {
            return DB::table('farm_cattle')->where('id', '=', $request->input('cattle_id'))->get();
        } catch (\Illuminate\Database\QueryException $th) {
            throw new Exception($th->getMessage(), 500);
        }
    }
}
