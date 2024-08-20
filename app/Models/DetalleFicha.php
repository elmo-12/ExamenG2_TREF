<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleFicha extends Model
{
    protected $table = 'detalle_ficha';
    protected $primaryKey = 'id_detalle';

    protected $fillable = [
        'id_ficha',
        'id_video',
        'precio',
        'cantidad',
    ];

    public $timestamps = false;

    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'id_ficha');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'id_video');
    }
}