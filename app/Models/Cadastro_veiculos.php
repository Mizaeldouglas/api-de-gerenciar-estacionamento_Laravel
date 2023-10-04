<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cadastro_veiculos extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'color',
        'plate',
        'type'
    ];

    public function cadastro_estabelecimento (): BelongsTo
    {
        return $this->belongsTo(Cadastro_estabelecimento::class);
    }
}
