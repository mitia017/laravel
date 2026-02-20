<?php

use Illuminate\Support\Facades\Route;

$regexId = '[0-9]+';
$regexSlug = '[0-9a-z\-]+';

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/biens', [App\Http\Controllers\AgenceController::class, 'index'])->name('property.index');
Route::get('/biens/{slug}-{property}', [App\Http\Controllers\AgenceController::class, 'show'])->name('property.show')->where([
    'property' => $regexId,
    'slug' => $regexSlug,
]);
Route::post('/biens/{property}/contact', [App\Http\Controllers\AgenceController::class, 'contact'])->name('property.contact')->where([
    'property' => $regexId,
]);

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'doLogin']);
Route::delete('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::prefix('admin')->name('admin.')->middleware('auth')->group(function(){
    Route::resource('property', App\Http\Controllers\Admin\PropertyController::class)->except(['show']);
    Route::resource('option', App\Http\Controllers\Admin\OptionController::class)->except(['show']);
});