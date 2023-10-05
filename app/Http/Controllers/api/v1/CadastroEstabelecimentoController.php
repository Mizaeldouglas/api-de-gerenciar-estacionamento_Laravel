<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cadastro_estabelecimento;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CadastroEstabelecimentoController extends Controller
{
    public function index (): JsonResponse
    {
        $estabelecimento =  Cadastro_estabelecimento::all();
        return response()->json(compact('estabelecimento'));
    }

    public function store (Request $request): JsonResponse
    {
        try {
            $validate = $request->validate([
                'name' => 'required',
                'cnpj' => 'required',
                'phone' => 'required',
                'number_motorcycles_spaces' => 'required',
                'number_car_spaces' => 'required'
            ]);

            $estabelecimento = Cadastro_estabelecimento::create($validate);

            return response()->json(['Estabelecimento' => $estabelecimento], 201);
        }catch (Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function show (string $id): JsonResponse
    {
        $estabelecimento = Cadastro_estabelecimento::find($id);

        if ($estabelecimento === null){
            return response()->json(['error' => 'Estabelecimento Não encontrado!'], 404);
        }
        return response()->json(['Estabelecimento' => $estabelecimento]);
    }

    public function update (Request $request, string $id): JsonResponse
    {
        try {
            $estabelecimento = Cadastro_estabelecimento::find($id);
            $estabelecimento->update($request->all());
            $estabelecimento->save();

            return response()->json(['Estabelecimento' => $estabelecimento], 201);
        }catch (Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function destroy (string $id): JsonResponse
    {
        $estabelecimento =  Cadastro_estabelecimento::find($id);
        $estabelecimento->delete();

        return response()->json("estabelecimento deletado Com sucesso!", 204);
    }
}
