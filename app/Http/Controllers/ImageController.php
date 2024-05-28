<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    /**
     * Store a newly created image in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'nombre_imagen' => 'required|string|max:255',
                'nombre_alumno' => 'required|string|max:255',
                'grado' => 'required|string|max:50',
                'sesion' => 'required|string|max:50',
                'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Procesar y almacenar la imagen
            $image = $request->file('imagen');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('ServidorProductos');
            $image->move($destinationPath, $imageName);

            // Guardar la información de la imagen en la base de datos
            $imagen = new Imagen();
            $imagen->name = $request->input('nombre_imagen');
            $imagen->name_alumno = $request->input('nombre_alumno');
            $imagen->imagen = 'ServidorProductos/' . $imageName; // Almacenar la ruta relativa
            $imagen->grado = $request->input('grado');
            $imagen->sesion = $request->input('sesion');
            $imagen->save();

            // Retornar la respuesta con mensaje de éxito
            return back()
                ->with('success', 'La imagen se ha subido correctamente.')
                ->with('image', $imageName);
        } catch (\Exception $e) {
            Log::error('Error al subir la imagen: ' . $e->getMessage());
            return back()->with('error', 'Hubo un problema al subir la imagen.');
        }
    }

    // Listar todas las imágenes
    public function all(Request $request)
    {
        try {
            $year = $request->get('year');
            $month = $request->get('month');

            $imagenes = Imagen::query();

            if ($year && $month) {
                $imagenes->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);
            } elseif ($year) {
                $imagenes->whereYear('created_at', $year);
            }

            $imagenes = $imagenes->get();

            return view('imagenes', compact('imagenes'));
        } catch (\Exception $e) {
            Log::error('Error al listar las imágenes: ' . $e->getMessage());
            return back()->with('error', 'Hubo un problema al obtener las imágenes.');
        }
    }

    public function eliminar($id)
    {
        try {
            $imagen = Imagen::findOrFail($id);
    
            $imagen_path = public_path($imagen->imagen);
    
            if (file_exists($imagen_path)) {
                unlink($imagen_path);
            } else {
                // Añade un mensaje de depuración aquí
                Log::info('El archivo no existe: ' . $imagen_path);
            }
    
            $imagen->delete();
    
            return redirect()->back()->with('success', 'Imagen eliminada exitosamente.');
        } catch (\Exception $e) {
            // Añade un mensaje de depuración aquí
            Log::error('Error al eliminar la imagen: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo eliminar la imagen.');
        }
    }

    // Actualizar una imagen
    public function actualizar(Request $request)
    {
        try {
            $codigo = $request->codigo;
            $imagen = Imagen::where('codigo', $codigo)->first();
            if (!$imagen) {
                return response()->json(['error' => 'Imagen no encontrada'], 404);
            }
            $imagen->name = $request->input('nombre_imagen');
            $imagen->name_alumno = $request->input('nombre_alumno');
            $imagen->grado = $request->input('grado');
            $imagen->sesion = $request->input('sesion');
            $imagen->save();

            return response()->json(['message' => "Datos actualizados correctamente"], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la imagen: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un problema al actualizar la imagen'], 500);
        }
    }

    // Mostrar una imagen específica
    public function show($codigo)
    {
        try {
            $imagen = Imagen::where('codigo', $codigo)->first();
            if (!$imagen) {
                return response()->json(['error' => 'Imagen no encontrada'], 404);
            }
            return response()->json(['imagen' => $imagen]);
        } catch (\Exception $e) {
            Log::error('Error al mostrar la imagen: ' . $e->getMessage());
            return response()->json(['error' => 'Hubo un problema al obtener la imagen'], 500);
        }
    }
}
