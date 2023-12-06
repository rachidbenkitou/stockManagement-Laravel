<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fournisseurs = Fournisseur::paginate(10);
        if ($fournisseurs->count() > 0) {
            $response = [
                'perPage' => $fournisseurs->perPage(),
                'currentPage' => $fournisseurs->currentPage(),
                'totalCount' => $fournisseurs->total(),
                'totalPages' => $fournisseurs->lastPage(),
                'data' => $fournisseurs->items(),
            ];
            $data = [
                'status' => "200",
                'produits' => $response
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validators = Validator::make($request->all(), [
            'code_fournisseur' => 'required',
            'nom' => 'required',
            'adresse' => 'required',
            'tel' => 'required|numeric|digits:10',
            'mail' => 'required|email',
            'fax' => 'required|numeric|digits:10',
        ]);

        if ($validators->fails()) {
            $response = [
                'status' => 422,
                "message" => "Validation échouée",
                'les erreurs' => $validators->errors()
            ];
            return response()->json($response, 422);
        }
        $existingFournisseur = Fournisseur::where('code_fournisseur', $request->code_fornisseur)->first();
        if ($existingFournisseur) {
            $response = [
                'status' => 409,
                "message" => "Fournisseur deja existe."
            ];
            return response()->json($response, 409);
        }
        $fournisseurSaved = Fournisseur::create($request->all());
        if ($fournisseurSaved) {
            $response = [
                'status' => 200,
                "fournisseur" => $fournisseurSaved
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
            return response()->json($response, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($column, $param)
    {
        $existingFournisseurs = Fournisseur::where($column, 'LIKE', "%$param%")->paginate(10);

        if ($existingFournisseurs->count() == 0) {
            $response = [
                'status' => 500,
                'message' => 'Aucun enregistrement trouvé.'
            ];
            return response()->json($response, 404);
        } else {
            $response = [
                'perPage' => $existingFournisseurs->perPage(),
                'currentPage' => $existingFournisseurs->currentPage(),
                'totalCount' => $existingFournisseurs->total(),
                'totalPages' => $existingFournisseurs->lastPage(),
                'data' => $existingFournisseurs->items(),
            ];
            $data = [
                'status' => 500,
                'Message' => "La recherche par $column",
                'fournisseurs' => $response
            ];
            return response()->json($data, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existingFournisseur = Fournisseur::find($id);
        if (!$existingFournisseur) {
            $response = [
                "status" => 404,
                "message" => "Le fournisseur à mettre à jour n'a pas été trouvé."
            ];
            return response()->json($response, 404);
        }
        $validators = Validator::make($request->all(), [
            'code_fournisseur' => 'required',
            'nom' => 'required',
            'adresse' => 'required',
            'tel' => 'required|numeric|digits:10',
            'mail' => 'required|email',
            'fax' => 'required|numeric|digits:10',
        ]);
        if ($validators->fails()) {
            $response = [
                "status" => 422,
                "message" => "La validation de la requête a échoué.",
                "errors" => $validators->errors()
            ];
            return response()->json($response, 422);
        }
        $existingFournisseur->update($request->all());
        $response = [
            "status" => 200,
            "data" => $existingFournisseur
        ];
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingFournisseur = Fournisseur::find($id);
        if (!$existingFournisseur) {
            $response = [
                "status" => 404,
                "message" => "Le fournisseur à mettre à jour n'a pas été trouvé."
            ];
            return response()->json($response, 404);
        }
        $existingFournisseur->delete();
        return response()->json([
            'status' => 200,
            'message' => "Le produit est supprimé avec succès"
        ], 200);
    }
}
