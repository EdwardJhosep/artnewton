<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VerImagenesController;
use Illuminate\Support\Facades\Route;

// Rutas principales
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/login', [PageController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [PageController::class, 'login'])->name('login');
Route::post('/logout', [PageController::class, 'logout'])->name('logout');
Route::get('/admin', [PageController::class, 'admin'])->name('admin');

// Rutas para subir y ver imágenes
Route::view('/subir-imagen', 'subir-imagen')->name('subir.imagen.form');
Route::post('/subir-imagen', [ImageController::class, 'store'])->name('subir.imagen');
Route::get('/ver-imagen/{id}', [VerImagenesController::class, 'ver'])->name('ver.imagen');
Route::get('/ver-imagenes', [VerImagenesController::class, 'index1'])->name('ver.imagenes');
Route::get('/ver-imagen/{id}', [VerImagenesController::class, 'ver'])->name('ver.imagen');
Route::get('/welcome', [VerImagenesController::class, 'volver'])->name('ver.welcome');

Route::delete('/eliminar-imagen/{id}', [VerImagenesController::class, 'eliminar'])->name('eliminar.imagen');
Route::get('/filtrar-imagenes', [VerImagenesController::class, 'ver'])->name('filtra.imagenes');

// routes/web.php


Route::post('/imagenes/{imageId}/comment', [VerImagenesController::class, 'storeComment'])->name('comentar.imagen');
Route::post('/like-imagen/{imageId}', [VerImagenesController::class, 'likeImage'])->name('like.imagen');
Route::get('/', [VerImagenesController::class, 'indexWithComments'])->name('inicio');

Route::get('/', [VerImagenesController::class, 'index'])->name('inicio');
Route::post('/comentar/{id}', [VerImagenesController::class, 'storeComment'])->name('store.comment');
Route::post('/like/{id}', [VerImagenesController::class, 'likeImage'])->name('like.image');
Route::get('/filtrar-imagenes', [VerImagenesController::class, 'filtrarImagenes'])->name('filtrar.imagenes');

Route::get('/admin/imagenes', [ImageController::class, 'all'])->name('ver.imagenes');
Route::post('/admin/imagen/store', [ImageController::class, 'store'])->name('guardar.imagen');
Route::delete('/admin/imagen/eliminar/{id}', [ImageController::class, 'eliminar'])->name('eliminar.imagen');
Route::put('/admin/imagen/actualizar/{id}', [ImageController::class, 'actualizar'])->name('actualizar.imagen');
Route::get('/admin/imagen/show/{codigo}', [ImageController::class, 'show'])->name('mostrar.imagen');
Route::get('/ver-imagenes', [VerImagenesController::class, 'index'])->name('ver.imagenes')->middleware('auth');
