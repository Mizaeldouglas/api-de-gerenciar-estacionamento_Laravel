<?php /** @noinspection ALL */

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Cadastro_estabelecimento;
use App\Models\Cadastro_veiculos;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CadastroVeiculosController extends Controller
{
    public function index (): JsonResponse
    {
        try {
            $response = [];
            $veiculos = Cadastro_veiculos::all();
            $estabelecimento = Cadastro_estabelecimento::all();

            foreach ($veiculos as $veiculo) {
                foreach ($estabelecimento as $item) {
                    $response[] = [
                        'id' => $veiculo->id,
                        'brand' => $veiculo->brand,
                        'model' => $veiculo->model,
                        'color' => $veiculo->color,
                        'plate' => $veiculo->plate,
                        'type' => $veiculo->type,
                        'estabelecimento_id' => [
                            'Estabelecimento' => [
                                'id' => $item->id,
                                'name' => $item->name,
                                'cnpj' => $item->cnpj,
                                'phone' => $item->phone,
                                'number_motorcycles_spaces' => $item->number_motorcycles_spaces,
                                'number_car_spaces' => $item->number_car_spaces,
                            ]
                        ],
                    ];
                }

            }

            return response()->json(['Veiculos' => $response], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }


    public function store (Request $request): JsonResponse
    {
        try {

            $validate = $request->validate([
                'brand' => 'required',
                'model' => 'required',
                'color' => 'required',
                'plate' => 'required',
                'type' => 'required|in:carro,moto',
                'estabelecimento_id' => 'nullable|exists:cadastro_estabelecimentos,id'
            ]);

            $veiculo = Cadastro_veiculos::create($validate);
            $estabelecimento = Cadastro_estabelecimento::all();


            foreach ($estabelecimento as $item) {
                $response = [
                    'Veiculo' => [
                        'id' => $veiculo->id,
                        'brand' => $veiculo->brand,
                        'model' => $veiculo->model,
                        'color' => $veiculo->color,
                        'plate' => $veiculo->plate,
                        'type' => $veiculo->type,
                        'estabelecimento_id' => [
                            'Estabelecimento' => [
                                'id' => $item->id,
                                'name' => $item->name,
                                'cnpj' => $item->cnpj,
                                'phone' => $item->phone,
                                'number_motorcycles_spaces' => $item->number_motorcycles_spaces,
                                'number_car_spaces' => $item->number_car_spaces,
                            ]
                        ],
                        'updated_at' => $veiculo->updated_at,
                        'created_at' => $veiculo->created_at,
                    ]
                ];
            }

            return response()->json($response, 201);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }


    public function show (string $id)
    {
        try {
            $veiculos = Cadastro_veiculos::find($id);
            $estabelecimento = Cadastro_estabelecimento::all();


            foreach ($estabelecimento as $item) {
                $response = [
                    'id' => $veiculos->id,
                    'brand' => $veiculos->brand,
                    'model' => $veiculos->model,
                    'color' => $veiculos->color,
                    'plate' => $veiculos->plate,
                    'type' => $veiculos->type,
                    'estabelecimento_id' => [
                        'Estabelecimento' => [
                            'id' => $item->id,
                            'name' => $item->name,
                            'cnpj' => $item->cnpj,
                            'phone' => $item->phone,
                            'number_motorcycles_spaces' => $item->number_motorcycles_spaces,
                            'number_car_spaces' => $item->number_car_spaces,
                        ]
                    ],
                ];
            }


            return response()->json(['Veiculo' => $response], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function update (Request $request, string $id)
    {
        try {
            $veiculo = Cadastro_veiculos::find($id);

            if ($veiculo === null) {
                return response()->json(['error' => 'Veículo não encontrado!'], 404);
            }

            $validate = $request->validate([
                'brand' => 'required',
                'model' => 'required',
                'color' => 'required',
                'plate' => 'required',
                'type' => 'required|in:carro,moto',
                'estabelecimento_id' => 'nullable|exists:cadastro_estabelecimentos,id'
            ]);

            $veiculo->fill($validate);

            if ($request->has('estabelecimento_id')) {
                $veiculo->cadastro_estabelecimento()->associate($request->input('estabelecimento_id'));
            }

            $veiculo->save();

            // Carregue o relacionamento atualizado com o estabelecimento associado
            $veiculo->load('cadastro_estabelecimento');

            $response = [
                'id' => $veiculo->id,
                'brand' => $veiculo->brand,
                'model' => $veiculo->model,
                'color' => $veiculo->color,
                'plate' => $veiculo->plate,
                'type' => $veiculo->type,
                'estabelecimento_id' => [
                    'Estabelecimento' => [
                        'id' => $veiculo->cadastro_estabelecimento->id,
                        'name' => $veiculo->cadastro_estabelecimento->name,
                        'cnpj' => $veiculo->cadastro_estabelecimento->cnpj,
                        'phone' => $veiculo->cadastro_estabelecimento->phone,
                        'number_motorcycles_spaces' => $veiculo->cadastro_estabelecimento->number_motorcycles_spaces,
                        'number_car_spaces' => $veiculo->cadastro_estabelecimento->number_car_spaces,
                    ]
                ],
            ];

            return response()->json($response, 200);

        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }


    public function destroy (string $id)
    {
        try {
            $veiculo = Cadastro_veiculos::find($id);
            if ($veiculo === null) {
                return response()->json(['error' => 'Veículo não encontrado!'], 404);
            }
            $veiculo->delete();

            return response()->json('Deletado com sucesso!', 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }
}
