<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';

    protected $fillable = [
        'DNI',
        'nombres',
        'direccion',
    ];

    public $timestamps = false;

    public function fichas()
    {
        return $this->hasMany(Ficha::class, 'id_cliente');
    }
}