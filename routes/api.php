<?php


use App\Http\Controllers\AuthController;

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FactureController;


use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PackageCommandeController;
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





//Route::get('clients', [ClientController::class, 'index']);
//Route::post('clients', [ClientController::class, 'store']);
//Route::get('clients/{column}/{param}', [ClientController::class, 'show']);
//Route::delete('clients/{id}', [ClientController::class, 'destroy']);
//Route::put('clients/{id}', [ClientController::class, 'update']);
Route::post('login', [AuthController::class, 'login']);
Route::post('loginClient', [AuthController::class, 'loginClient']);
Route::post('register', [AuthController::class, 'register']);

//Route::group(['middleware'=> ['auth:sanctum']], function () {
//
//    Route::post('logout', [AuthController::class, 'logout']);
//});


////Route::group(['middleware'=> ['auth:sanctum']], function () {
//Route::get('clients', [ClientController::class, 'index']);
//Route::post('clients', [ClientController::class, 'store']);
//Route::get('clients/{column}/{param}', [ClientController::class, 'show']);
//Route::delete('clients/{id}', [ClientController::class, 'destroy']);
//Route::put('clients/{id}', [ClientController::class, 'update']);
//});








Route::post('registerClient', [AuthController::class, 'registerClient']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('fournisseurs', [FournisseurController::class, 'index']);
    Route::get('fournisseurs/all', [FournisseurController::class, 'getAll']);
    Route::post('fournisseurs', [FournisseurController::class, 'store']);
    Route::get('fournisseurs/{column}/{param}', [FournisseurController::class, 'show']);
    Route::put('fournisseurs/{id}', [FournisseurController::class, 'update']);
    Route::delete('fournisseurs/{id}', [FournisseurController::class, 'destroy']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('commandes', [CommandeController::class, 'index']);

    Route::delete('commandes/{id}', [CommandeController::class, 'destroy']);
    Route::put('commandes/{id}', [CommandeController::class, 'update']);

    Route::get('commandes/{id}', [CommandeController::class, 'show']);
    Route::get('commandes/{column}/{param}', [CommandeController::class, 'show1']);

    Route::post('commandes', [CommandeController::class, 'store']);
});

Route::get('clients/{column1}/{param1}', [ClientController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('clients', [ClientController::class, 'index']);
    Route::post('clients', [ClientController::class, 'store']);
    Route::get('clients/{column1}/{param1}/{column2}/{param2}', [ClientController::class, 'show_two']);
    Route::delete('clients/{id}', [ClientController::class, 'destroy']);
    Route::put('clients/{id}', [ClientController::class, 'update']);
});
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('categories', [CategorieController::class, 'index']);
    Route::get('categories/all', [CategorieController::class, 'getAll']);
    Route::post('categories', [CategorieController::class, 'store']);
    Route::get('categories/{column}/{param}', [CategorieController::class, 'show']);
    Route::put('categories/{id}', [CategorieController::class, 'update']);
    Route::delete('categories/{id}', [CategorieController::class, 'destroy']);
});
Route::get('produits', [PrduitController::class, 'index']);
Route::get('produits/{column}/{param}', [PrduitController::class, 'show']);
Route::get('produits/all', [PrduitController::class, 'getAllProducts']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('produits', [PrduitController::class, 'store']);
    Route::post('produits/quantite/{produitId}/{fournisseurId}', [PrduitController::class, 'addQuantite']);
    Route::put('produits/{id}', [PrduitController::class, 'update']);
    Route::delete('produits/{id}', [PrduitController::class, 'destroy']);
});
Route::get('packs', [PackController::class, 'index']);
Route::get('packs/{column}/{param}', [PackController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('packs', [PackController::class, 'store']);
    Route::delete('packs/{id}', [PackController::class, 'destroy']);
    Route::put('packs/{id}', [PackController::class, 'update']);
});
Route::get('packProduits', [Produit_PackController::class, 'index']);
Route::get('packProduits/{column}/{param}', [Produit_PackController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('packProduits', [Produit_PackController::class, 'store']);
    Route::delete('packProduits/{pack_id}/{produit_id}', [Produit_PackController::class, 'destroy']);
    Route::put('packProduits/{id}', [Produit_PackController::class, 'update']);
});
//Route::get('factures', [FactureController::class, 'index']);
//Route::post('factures', [FactureController::class, 'store']);
//Route::get('factures/{column}/{param}', [FactureController::class, 'show']);
//Route::delete('factures/{id}', [FactureController::class, 'destroy']);
//Route::put('factures/{id}', [FactureController::class, 'update']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('orderStatuses', [OrderStatusController::class, 'index']);
    Route::get('orderStatuses/{id}', [OrderStatusController::class, 'show']);
    Route::post('orderStatuses', [OrderStatusController::class, 'store']);
    Route::put('orderStatuses/{id}', [OrderStatusController::class, 'update']);
    Route::delete('orderStatuses/{id}', [OrderStatusController::class, 'destroy']);
});
//Route::get('discounts', [DiscountController::class, 'index']);
//Route::get('discounts/{id}', [DiscountController::class, 'show']);
//Route::post('discounts', [DiscountController::class, 'store']);
//Route::put('discounts/{id}', [DiscountController::class, 'update']);
//Route::delete('discounts/{id}', [DiscountController::class, 'destroy']);
Route::get('packsCommandes', [PackageCommandeController::class, 'index']);
Route::get('commandepacks', [PackageCommandeController::class, 'index2']);
Route::get('commandepacks/{column}/{param}', [PackageCommandeController::class, 'show']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('packsCommandes', [PackageCommandeController::class, 'store']);
    Route::post('packsCommandes', [CommandeController::class, 'store1']);


});
