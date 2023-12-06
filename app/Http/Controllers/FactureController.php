<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $factures = Facture::with('commande')->paginate(10);
        if(!$factures->isEmpty()){
            $response = [
                'perPage' => $factures->perPage(),
                'currentPage' => $factures->currentPage(),
                'totalCount' => $factures->total(),
                'totalPages' => $factures->lastPage(),
                'data' => $factures->items(),
            ];
            $data = [
                'status'=>"200",
                'data'=>$response
            ];
            return response()->json($data, 200);
        }else{
            return response()->json([
                'status'=>"404",
                'message'=>"Aucun enregistrement trouvé"
            ],404);
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
        $existingFacture = Facture::where('codeFacture', $request->codeFacture)->first();

        if ($existingFacture) {
            return response()->json([
                'status' => 409,
                'Message' => "Facture deja existe."
            ], 409);
        } else {
            $factureSaved = Facture::create($request->all());
            if ($factureSaved) {
                return response()->json([
                    'status' => 200,
                    'produit' => $factureSaved
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Internal server error'
                ], 500);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($column, $param)
    {
        $existingFactures = Facture::with('commande')
            ->where($column, 'LIKE', "%$param%")
            ->paginate(10);
        if (!$existingFactures) {
            return response()->json([
                'status' => 404,
                'Message' => "Facture non trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingFactures->perPage(),
                'currentPage' => $existingFactures->currentPage(),
                'totalCount' => $existingFactures->total(),
                'totalPages' => $existingFactures->lastPage(),
                'data' => $existingFactures->items(),
            ];
            return response()->json([
                'status' => 200,
                'Message' => "La recherche par $column",
                'data' => $response
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
        $existingFacture = Facture::find($id);
        if (!$existingFacture) {
            return response()->json([
                'status' => 404,
                'Message' => "Facture non trouvé."
            ], 404);
        }else{
            $existingFacture->update($request->all());
            return response()->json([
                'status' => 404,
                'data' => "Le facture est modifié avec succés"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingFacture = Facture::find($id);

        if (!$existingFacture) {
            return response()->json([
                'status' => 404,
                'message' => "Facture non trouvé."
            ], 404);

        } else {
            $existingFacture->delete();

            return response()->json([
                'status' => 200,
                'message' => "Le facture est supprimé avec succès"
            ], 200);
        }
    }
}
