<?php

namespace App\Http\Controllers;

use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function home()
    {
        $imagenes = Imagen::all();
        return view('welcome', compact('imagenes'));
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $usuario = $request->input('usuario');
        $password = $request->input('password');

        // Validar las credenciales
        if ($usuario == 'Newton@2024' && $password == 'newton@2024') {
            // Credenciales válidas, guardar en sesión
            Session::put('authenticated', true);
            return redirect()->route('admin');
        } else {
            // Credenciales inválidas
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas. Inténtalo de nuevo.');
        }
    }

    public function logout()
    {
        Session::forget('authenticated');
        return redirect()->route('home')->with('message', 'Has cerrado sesión correctamente.');
    }

    public function admin()
    {
        // Verificar si el usuario está autenticado
        if (!Session::has('authenticated')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        return view('admin');
    }

    public function showImages()
    {
        // Verificar si el usuario está autenticado
        if (!Session::has('authenticated')) {
            return redirect()->route('login.form')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $imagenes = Imagen::all();
        return view('imagenes', compact('imagenes'));
    }
}
