<?php


use App\Http\Controllers\ClientController;
use App\Http\Controllers\PrduitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store'])->name('client.store');
Route::get('/clients/{id}', [ClientController::class, 'show'])->name('client.show');
Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('client.destroy');
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('client.update');
Route::post('/clients/search', [ClientController::class, 'search'])->name('client.search');


Route::get('/produits', [PrduitController::class, 'index']);
Route::post('produits', [PrduitController::class, 'store'])->name('produit.store');
Route::delete('/produits/{id}', [PrduitController::class, 'destroy'])->name('produit.destroy');
Route::get('/produits/{id}', [PrduitController::class, 'edit'])->name('produit.edit');
Route::put('/produits/{id}', [PrduitController::class, 'update'])->name('produit.update');
Route::post('/produit/search', [PrduitController::class, 'search'])->name('produit.search');



Route::get('/commandes', [CommandeController::class, "index"]);
Route::post('/commandes', [CommandeController::class, 'store'])->name('commande.store');
// Update the specified commande in the database
Route::put('/commandes/{commande}', [CommandeController::class, 'update'])->name('commande.update');
Route::delete('/commandes/{commande}', [CommandeController::class, 'destroy'])->name('commande.destroy');

