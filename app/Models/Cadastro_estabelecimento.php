<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @method static create(array $validate)
 * @method static find(string $id)
 */
class Cadastro_estabelecimento extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cnpj',
        'phone',
        'number_motorcycles_spaces',
        'number_car_spaces'
    ];


    public function cadastro_veiculos (): HasMany
    {
        return $this->hasMany(Cadastro_veiculos::class);
    }
}
