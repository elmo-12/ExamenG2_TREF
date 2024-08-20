<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    protected $table = 'ficha';
    protected $primaryKey = 'id_ficha';

    protected $fillable = [
        'id_cliente',
        'fecha_venta',
        'total',
    ];

    public $timestamps = false;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function detallesFicha()
    {
        return $this->hasMany(DetalleFicha::class, 'id_ficha');
    }
}