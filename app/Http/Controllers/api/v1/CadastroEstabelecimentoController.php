<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CadastroEstabelecimentoController extends Controller
{
    public function index (): JsonResponse
    {
        return response()->json('Teste');
    }
}
