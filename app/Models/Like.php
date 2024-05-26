<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['id_imagen', 'likes'];

    public function image()
    {
        return $this->belongsTo(Imagen::class, 'id_imagen');
    }
}
