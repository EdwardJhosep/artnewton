<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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
    }

    // Listar todas las imágenes
    public function all()
    {
        $imagenes = Imagen::all();
        return response()->json($imagenes);
    }

    // Eliminar una imagen
    public function eliminar(Request $request)
    {
        $codigo = $request->codigo;

        if (!$codigo) {
            return response()->json([
                'error' => "El código no se proporcionó correctamente."
            ], 400);
        }

        $imagen = Imagen::where('codigo', $codigo)->firstOrFail();

        $imagen_path = public_path('ServidorProductos/' . $imagen->imagen);
        if (file_exists($imagen_path)) {
            unlink($imagen_path);
        }

        $imagen->delete();

        return response()->json([
            'message' => "Imagen eliminada exitosamente."
        ]);
    }

    // Actualizar una imagen
    public function actualizar(Request $request)
    {
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
    }

    // Mostrar una imagen específica
    public function show($codigo)
    {
        $imagen = Imagen::where('codigo', $codigo)->first();
        return response()->json([
            'imagen' => $imagen
        ]);
    }
}
