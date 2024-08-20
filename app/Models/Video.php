<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';
    protected $primaryKey = 'id_video';

    protected $fillable = [
        'stock',
        'descripcion',
        'precio',
    ];

    public $timestamps = false;

    public function detallesFicha()
    {
        return $this->hasMany(DetalleFicha::class, 'id_video');
    }
}