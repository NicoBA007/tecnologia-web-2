<?php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('index');
});

Route::prefix('a2')->group(function () {

  Route::get('/', function () {
    return view('a2.listado');
  });

  Route::get('/ejercicio{id}', function ($id) {
    return view("a2.ejercicio$id.index");
  })->where('id', '[0-9]+');
});