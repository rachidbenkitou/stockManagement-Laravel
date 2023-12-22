<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categorie::paginate(5);
        if ($categories->count() > 0) {
            $response = [
                'perPage' => $categories->perPage(),
                'currentPage' => $categories->currentPage(),
                'totalCount' => $categories->total(),
                'totalPages' => $categories->lastPage(),
                'data' => $categories->items(),
            ];
            $data = [
                'status' => "200",
                'categories' => $response
            ];
            return response()->json($data, 200);
        } else {
            return response()->json([
                'status' => "404",
                'message' => "Aucun enregistrement trouvé"
            ], 404);
        }
    }

    public function getAll()
    {
        $categories = Categorie::all();
        if ($categories->count() > 0) {
            $data = [
                'status' => "200",
                'categories' => $categories
            ];
            return response()->json($data, 200);
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
        $validators = Validator::make($request->all(), [
            'nom' => 'required',
            'description' => 'required',
        ]);
        if ($validators->fails()) {
            $response = [
                'status' => 422,
                "message" => "Validation échouée",
                'erreurs' => $validators->errors()
            ];
            return response()->json($response, 422);
        }
        $existingCategorie = Categorie::where('nom', $request->nom)->first();

        if ($existingCategorie) {
            return response()->json([
                'status' => 409,
                'message' => "Categorie deja existe."
            ], 409);
        } else {
            $categorieSaved = Categorie::create($request->all());

            if ($categorieSaved) {
                return response()->json([
                    'status' => 200,
                    'categorie' => $categorieSaved
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
        $existingCategorie = Categorie::where($column, 'LIKE', "%$param%")->paginate(5);;

        if (!$existingCategorie) {
            return response()->json([
                'status' => 404,
                'Message' => "Categorie non trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingCategorie->perPage(),
                'currentPage' => $existingCategorie->currentPage(),
                'totalCount' => $existingCategorie->total(),
                'totalPages' => $existingCategorie->lastPage(),
                'data' => $existingCategorie->items(),
            ];
            $data = [
                'status' => "200",
                'Message' => "La recherche par $column",
                'categories' => $response
            ];
            return response()->json($data, 200);
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
        $existingCategorie = Categorie::find($id);
        if (!$existingCategorie) {
            return response()->json([
                'status' => 404,
                'Message' => "Produit non trouvé."
            ], 404);
        } else {
            $categorieMatchCode = Categorie::where('nom', $request->nom)->first();
            if ($categorieMatchCode) {
                return response()->json([
                    'status' => 404,
                    'Message' => "Categorie avec le code $request->nom déja existe ."
                ], 404);
            } else {
                $existingCategorie->update($request->all());
                return response()->json([
                    'status' => 200,
                    'data' => $existingCategorie
                ], 200);
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
        $existingCategorie = Categorie::find($id);

        if (!$existingCategorie) {
            return response()->json([
                'status' => 404,
                'message' => "Categorie non trouvé."
            ], 404);
        } else {
            $existingCategorie->delete();

            return response()->json([
                'status' => 200,
                'message' => "La Categorie est supprimé avec succès"
            ], 200);
        }
    }
}
