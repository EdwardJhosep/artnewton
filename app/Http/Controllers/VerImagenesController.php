<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Comentario;
use App\Models\Like;
use Illuminate\Http\Request;

class VerImagenesController extends Controller
{
    public function index()
    {
        // Obtener todas las imágenes (puedes ajustar esta lógica según sea necesario)
        $imagenes = Imagen::orderBy('created_at', 'desc')->get();

        return view('welcome', compact('imagenes'));
    }

    public function filtrarImagenes(Request $request)
    {
        // Obtener los parámetros de filtrado desde el formulario
        $mes = $request->input('mes');
        $ano = $request->input('ano');

        // Filtrar imágenes según los parámetros recibidos
        $imagenes = Imagen::whereMonth('created_at', $mes)
            ->whereYear('created_at', $ano)
            ->orderBy('created_at', 'desc')
            ->get();

        // Puedes personalizar el mensaje si no hay imágenes
        if ($imagenes->isEmpty()) {
            return redirect()->route('inicio')->with('error', 'No hay imágenes disponibles para el mes y año seleccionados.');
        }

        // Si hay imágenes, retornar la vista con las imágenes filtradas
        return view('welcome', compact('imagenes'));
    }
    
    public function volver()
    {
        $imagenes = Imagen::all();
        return view('welcome', compact('imagenes'));
    }
    
    public function eliminar($id)
    {
        $imagen = Imagen::findOrFail($id);
        $imagen->delete();
        
        return redirect()->route('ver.imagenes')->with('success', 'Imagen eliminada correctamente');
    }

    
    public function ver(Request $request)
    {
        $query = Imagen::query();

        if ($request->has('mes') && $request->mes != '') {
            $query->whereMonth('created_at', $request->mes);
        }

        if ($request->has('ano') && $request->ano != '') {
            $query->whereYear('created_at', $request->ano);
        }

        $imagenes = $query->get();

        return view('imagenes', compact('imagenes'));
    }
    
    public function storeComment(Request $request, $imageId)
    {
        $request->validate([
            'comentarista' => 'required',
            'comentario' => 'required'
        ]);

        Comentario::create([
            'id_imagen' => $imageId,
            'comentarista' => $request->comentarista,
            'comentario' => $request->comentario
        ]);

        return redirect()->back()->with('success', 'Comentario agregado correctamente');
    }

    public function likeImage($imageId)
    {
        $like = Like::where('id_imagen', $imageId)->first();
        if ($like) {
            $like->increment('likes');
        } else {
            Like::create(['id_imagen' => $imageId, 'likes' => 1]);
        }

        return redirect()->back()->with('success', 'Imagen marcada como me gusta');
    }
    public function indexWithComments()
{
    $imagenes = Imagen::with(['comentarios', 'likes'])->get();
    return view('welcome', compact('imagenes'));
}

}
