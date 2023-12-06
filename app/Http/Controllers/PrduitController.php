<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PrduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::with('fournisseurs')->paginate(5);
        // $produits = Produit::paginate(5);
        if (!$produits->isEmpty()) {
            $response = [
                'perPage' => $produits->perPage(),
                'currentPage' => $produits->currentPage(),
                'totalCount' => $produits->total(),
                'totalPages' => $produits->lastPage(),
                'data' => $produits->items(),
            ];
            $data = [
                'status' => "200",
                'produits' => $response
            ];
            return response()->json($data, 200);
            // return view(
            //     'produit.produit',
            //     [
            //         'produits' =>  $response['data'],
            //         'totalPages' => $response['totalPages'],
            //         'currentPage' => $response['currentPage']
            //     ]
            // );
        } else {
            return response()->json([
                'status' => "404",
                'message' => "Aucun enregistrement trouvé"
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code_produit' => 'required',
            'quantite' => 'required',
            'prix_unitaire' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            // return redirect('/produits')->with('fail', $validator->errors());
        }
        $existingProduit = Produit::where('code_produit', $request->code_produit)->first();

        if ($existingProduit) {
            return response()->json([
                'status' => 409,
                'Message' => "Produit deja existe."
            ], 409);
            // return redirect('/produits')->with('fail', "Produit deja existe");
        } else {
            $produitSaved = Produit::create($request->all());
            // $produit->fournisseurs()->attach($request->fournisseur_id, [
            //     'qte_entree' => $request->qte_entree,
            //     'date_entree' => $request->date_entree,
            // ]);

            if ($produitSaved) {
                return response()->json([
                    'status' => 200,
                    'produit' => $produitSaved
                ], 200);
                // return redirect('/produits')->with('success', "le produit s'est ajouté avec succès");
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
     * @param  string  $param
     * @param  string  $column
     * @return \Illuminate\Http\Response
     */
    public function show($column, $param)
    {
        $existingProduits = Produit::where($column, 'LIKE', "%$param%")->with('fournisseurs')->get();

        if (!$existingProduits) {
            return response()->json([
                'status' => 404,
                'Message' => "Produit non trouvé."
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'Message' => "La recherche par $column",
                'data' => $existingProduits
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $existingProduits = Produit::where('code_produit', 'LIKE', "%$request->code_produit%")->get();
        if ($existingProduits->isEmpty()) {
            // return response()->json([
            //     'status' => 404,
            //     'Message' => "Produit non trouvé."
            // ], 404);
            return redirect('/produits')->with('fail', "Produit non trouvé");
        } else {
            // return response()->json([
            //     'status' => 200,
            //     'data' => $existingProduit
            // ], 404);
            // $produitsArray = $existingProduits->toArray();
            return redirect('/produits')->with('produits', $existingProduits);
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
        $existingProduit = Produit::find($id);
        if (!$existingProduit) {
            // return response()->json([
            //     'status' => 404,
            //     'Message' => "Produit non trouvé."
            // ], 404);
            return redirect('/produits')->with('fail', "Produit non trouvé.");
        } else {
            $produitmatchCode = Produit::where('code_produit', $request->code)->first();
            if ($produitmatchCode) {
                return redirect('/produits')->with('fail', "Produit avec le code $request->code déja existe .");
            } else {
                $existingProduit->update($request->all());
                // return response()->json([
                //     'status' => 404,
                //     'data' => "Le produit est modifié avec succés"
                // ], 404);
                return redirect('/produits')->with('success', "le produit s'est modifier avec succès");
            }
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
        $existingProduit = Produit::find($id);

        if (!$existingProduit) {
            // return response()->json([
            //     'status' => 404,
            //     'message' => "Produit non trouvé."
            // ], 404);
            return redirect('/produits')->with('fail', "Produit non trouvé");
        } else {
            $existingProduit->delete();

            // return response()->json([
            //     'status' => 200,
            //     'message' => "Le produit est supprimé avec succès"
            // ], 200);
            return redirect('/produits')->with('success', "Le produit est supprimé avec succès");
        }
    }
}
