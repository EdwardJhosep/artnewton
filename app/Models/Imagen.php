<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes'; // Si el nombre de la tabla es diferente

    protected $fillable = ['name_alumno', 'name', 'grado', 'sesion', 'imagen'];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_imagen', 'id');
    }

    public function likes()
    {
        return $this->hasOne(Like::class, 'id_imagen', 'id');
    }
}
