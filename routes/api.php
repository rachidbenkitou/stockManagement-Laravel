<?php


use App\Http\Controllers\ClientController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FactureController;


use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PrduitController;
use App\Http\Controllers\Produit_PackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('produits', [PrduitController::class, 'index']);
Route::post('produits', [PrduitController::class, 'store']);
Route::get('produits/{column}/{param}', [PrduitController::class, 'show']);
Route::put('produits/{id}', [PrduitController::class, 'update']);
Route::delete('produits/{id}', [PrduitController::class, 'destroy']);




Route::get('clients', [ClientController::class, 'index']);
Route::post('clients', [ClientController::class, 'store']);
Route::get('clients/{column}/{param}', [ClientController::class, 'show']);
Route::delete('clients/{id}', [ClientController::class, 'destroy']);
Route::put('clients/{id}', [ClientController::class, 'update']);

Route::get('factures', [FactureController::class, 'index']);
Route::post('factures', [FactureController::class, 'store']);
Route::get('factures/{column}/{param}', [FactureController::class, 'show']);
Route::delete('factures/{id}', [FactureController::class, 'destroy']);
Route::put('factures/{id}', [FactureController::class, 'update']);

Route::get('packs', [PackController::class, 'index']);
Route::post('packs', [PackController::class, 'store']);
Route::get('packs/{column}/{param}', [PackController::class, 'show']);
Route::delete('packs/{id}', [PackController::class, 'destroy']);
Route::put('packs/{id}', [PackController::class, 'update']);

Route::get('packProduits', [Produit_PackController::class, 'index']);
Route::post('packProduits', [Produit_PackController::class, 'store']);
Route::get('packProduits/{column}/{param}', [Produit_PackController::class, 'show']);
Route::delete('packProduits/{pack_id}/{produit_id}', [Produit_PackController::class, 'destroy']);
Route::put('packProduits/{id}', [Produit_PackController::class, 'update']);




Route::get('commandes', [CommandeController::class, 'index']);
Route::get('commandes/{id}', [CommandeController::class, 'show']);
Route::post('commandes', [CommandeController::class, 'store']);
Route::delete('commandes/{id}', [CommandeController::class, 'destroy']);
Route::put('commandes/{id}', [CommandeController::class, 'update']);


Route::get('fournisseurs', [FournisseurController::class, 'index']);
Route::post('fournisseurs', [FournisseurController::class, 'store']);
Route::get('fournisseurs/{column}/{param}', [FournisseurController::class, 'show']);
Route::put('fournisseurs/{id}', [FournisseurController::class, 'update']);
Route::delete('fournisseurs/{id}', [FournisseurController::class, 'destroy']);


Route::get('orderStatuses', [OrderStatusController::class, 'index']);
Route::get('orderStatuses/{id}', [OrderStatusController::class, 'show']);
Route::post('orderStatuses', [OrderStatusController::class, 'store']);
Route::put('orderStatuses/{id}', [OrderStatusController::class, 'update']);
Route::delete('orderStatuses/{id}', [OrderStatusController::class, 'destroy']);

Route::get('discounts', [DiscountController::class, 'index']);
Route::get('discounts/{id}', [DiscountController::class, 'show']);
Route::post('discounts', [DiscountController::class, 'store']);
Route::put('discounts/{id}', [DiscountController::class, 'update']);
Route::delete('discounts/{id}', [DiscountController::class, 'destroy']);




