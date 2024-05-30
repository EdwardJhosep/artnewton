<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use App\Models\Comentario;
use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerImagenesController extends Controller
{
    public function index()
    {
        // Obtener el mes y año actual
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Filtrar las imágenes según el mes y año actual
        $imagenes = Imagen::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('imagenes'));
    }
    public function index1()
    {
        // Obtener el mes y año actual
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Filtrar las imágenes según el mes y año actual
        $imagenes = Imagen::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('imagenes', compact('imagenes'));
    }


    public function filtrarImagenes(Request $request)
    {
        $mes = $request->input('mes');
        $ano = $request->input('ano');
    
        $query = Imagen::query();
    
        if ($mes) {
            $query->whereMonth('created_at', $mes);
        }
    
        if ($ano) {
            $query->whereYear('created_at', $ano);
        }
    
        $imagenes = $query->orderBy('created_at', 'desc')->get();
    
        if ($imagenes->isEmpty()) {
            // Buscar el mes más reciente con imágenes disponibles
            $mesRecomendado = Imagen::whereYear('created_at', $ano)
                ->selectRaw('MONTH(created_at) as mes')
                ->groupBy('mes')
                ->orderByRaw('COUNT(*) DESC')
                ->pluck('mes')
                ->first();
    
            $nombreMes = $mesRecomendado ? Carbon::create()->month($mesRecomendado)->locale('es')->monthName : 'Ninguno';
    
            return redirect()->route('inicio')->with('error', "No hay imágenes disponibles para el mes y año seleccionados. Te recomendamos revisar el mes de $nombreMes.");
        }
    
        return view('welcome', compact('imagenes'));
    }
    
    public function filtraImagenes1(Request $request)
    {
        $mes = $request->get('mes');

        if ($mes) {
            $imagenes = Imagen::whereMonth('created_at', $mes)
                              ->whereYear('created_at', now()->year)
                              ->orderBy('created_at', 'desc')
                              ->get();
        } else {
            $imagenes = Imagen::orderBy('created_at', 'desc')->get();
        }

        return view('imagenes', compact('imagenes'));
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

    public function ver($id)
    {
        $imagen = Imagen::findOrFail($id);
        return view('ver-imagen', compact('imagen'));
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

