<?php

use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::get('/docs', [DocumentationController::class, 'index'])->name('docs.index');
Route::get('/docs/search.json', [DocumentationController::class, 'search'])->name('docs.search');
Route::get('/docs/{page}', [DocumentationController::class, 'show'])->where('page', '[a-z0-9-]+')->name('docs.show');
Route::view('/accessibility', 'accessibility')->name('accessibility');
