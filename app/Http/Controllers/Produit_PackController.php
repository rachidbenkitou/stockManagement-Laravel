<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use Illuminate\Http\Request;

class Produit_PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $existingPacksProduits = Pack::with('produits')
            ->paginate(8);
        if (!$existingPacksProduits) {
            return response()->json([
                'status' => 404,
                'Message' => "Pack non trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingPacksProduits->perPage(),
                'currentPage' => $existingPacksProduits->currentPage(),
                'totalCount' => $existingPacksProduits->total(),
                'totalPages' => $existingPacksProduits->lastPage(),
                'data' => $existingPacksProduits->items(),
            ];
            return response()->json([
                'status' => 200,
                'packs' => $response
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Récupérez le pack existant
        $pack = Pack::findOrFail($request->pack_id);

        // Limitez le nombre maximal de produits attachés au pack
        $maxProduits = $pack->nbrProduits;; // Définissez la limite souhaitée

        // Vérifiez le nombre actuel de produits attachés au pack
        $nombreProduitsActuel = $pack->produits()->count();

        // Si le nombre actuel atteint la limite, renvoyez une réponse d'erreur
        if ($nombreProduitsActuel >= $maxProduits) {
            return response()->json([
                'status' => 400,
                'message' => 'La limite maximale de produits dans le pack est atteinte.'
            ], 400);
        }

        // Si la limite n'est pas atteinte, attachez le nouveau produit au pack
        $produit = $request->input('produit_id');
        $savedPack = $pack->produits()->attach($produit);

        // Retournez une réponse JSON en cas de succès
        $updatedPack = Pack::with('produits')->find($request->pack_id);
        return response()->json([
            'status' => 200,
            'pack' => $updatedPack
        ], 200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $column, $param
     * @return \Illuminate\Http\Response
     */
    public function show($column, $param)
    {
        $existingPacksProduits = Pack::with('produits')
            ->where($column, 'LIKE', "%$param%")
            ->paginate(8);
        if (!$existingPacksProduits) {
            return response()->json([
                'status' => 404,
                'Message' => "Pack non trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingPacksProduits->perPage(),
                'currentPage' => $existingPacksProduits->currentPage(),
                'totalCount' => $existingPacksProduits->total(),
                'totalPages' => $existingPacksProduits->lastPage(),
                'data' => $existingPacksProduits->items(),
            ];
            return response()->json([
                'status' => 200,
                'Message' => "La recherche par $column",
                'packs' => $response
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pack_id,$produit_id)
    {
    $pack = Pack::findOrFail($pack_id);



    $pack->produits()->detach($produit_id);

    // Retournez une réponse JSON en cas de succès
    return response()->json(['message' => 'Le produit a été supprimé du pack avec succès.'], 200);
    }
}
