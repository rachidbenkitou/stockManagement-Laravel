<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Produit;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::paginate(5);
        if($clients->count()>0){
            $response = [
                'perPage' => $clients->perPage(),
                'currentPage' => $clients->currentPage(),
                'totalCount' => $clients->total(),
                'totalPages' => $clients->lastPage(),
                'data' => $clients->items(),
            ];
            $data = [
                'status'=>"200",
                'clients'=>$response
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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


//        $validator = Validator::make($request->all(), [
//            'code_produit' => 'required',
//            'quantite' => 'required',
//            'prix_unitaire' => 'required',
//            'description' => 'required',
//        ]);
//        if ($validator->fails()) {
//            // return response()->json(['errors' => $validator->errors()], 422);
//            return redirect('/produits')->with('fail', $validator->errors());
//        }
        $existingClient = Client::where('id', $request->id)->first();

        if ($existingClient) {
             return response()->json([
                 'status' => 409,
                 'Message' => "Client deja existe."
             ], 409);
//            return redirect('/produits')->with('fail', "Produit deja existe");
        } else {
            // $produit = new Produit();
            // $produit->code = $request->code;
            // $produit->quantite = $request->quantite;
            // $produit->prix_unitaire = $request->prix_unitaire;
            // $produit->description = $request->description;
            // $produit->save();
            $clientSaved = Client::create($request->all());
            // $produit->fournisseurs()->attach($request->fournisseur_id, [
            //     'qte_entree' => $request->qte_entree,
            //     'date_entree' => $request->date_entree,
            // ]);

            if ($clientSaved) {
                return response()->json([
                    'status' => 200,
                    'client' => $clientSaved
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($column, $param){

        $existingClients =Client::where($column, 'LIKE', "%$param%")->paginate(5);

        if (!$existingClients) {
            return response()->json([
                'status' => 404,
                'Message' => "Client non trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingClients->perPage(),
                'currentPage' => $existingClients->currentPage(),
                'totalCount' => $existingClients->total(),
                'totalPages' => $existingClients->lastPage(),
                'data' => $existingClients->items(),
            ];
            return response()->json([
                'status' => 200,
                'Message' => "La recherche par $column",
                'client' => $response
            ], 200);
        }
    }
    public function show_two($column1, $param1, $column2, $param2) {
        $existingClients = Client::where(function ($query) use ($column1, $param1, $column2, $param2) {
            $query->where($column1, 'LIKE', "%$param1%")
                ->orWhere($column2, 'LIKE', "%$param2%");
        })->paginate(5);

        if (!$existingClients) {
            return response()->json([
                'status' => 404,
                'message' => "Aucun client trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingClients->perPage(),
                'currentPage' => $existingClients->currentPage(),
                'totalCount' => $existingClients->total(),
                'totalPages' => $existingClients->lastPage(),
                'data' => $existingClients->items(),
            ];

            return response()->json([
                'status' => 200,
                'message' => "La recherche par $column1 et $column2",
                'client' => $response
            ], 200);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  string  $code
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
//        $existingClients= Client::where('firstName', 'LIKE', "%$request->firstName%")
//            ->orWhere('lastName', 'LIKE', "%$request->lastName%")
//            ->get();
//        if ($existingClients->isEmpty()) {
//
//            return redirect('/clients')->with('fail', "Client non trouvé");
//
//        } else {
//
//            return redirect('/clients')->with('clients', $existingClients);
//
//        }
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
        $existingClient = Client::find($id);
        if (!$existingClient) {
            return response()->json([
                'status' => 404,
                'Message' => "Client non trouvé."
            ], 404);
        }else{
            $existingClient->update($request->all());

            $response = [
                "status" => 200,
                "data" =>$existingClient
            ];
            return response()->json($response, 200);
        }
//        $client = Client::findOrFail($id);
//
//        $client->update($request->all());

//        return redirect('/clients')->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        // Récupérer le client à supprimer
//        $client = Client::findOrFail($id);
//
//        // Supprimer le client
//        $client->delete();
//
//        // Rediriger avec un message de succès
//        return redirect('/clients')->with('success', 'Client supprimé avec succès.');
        $existingClient = Client::find($id);

        if (!$existingClient) {
             return response()->json([
                 'status' => 404,
                 'message' => "Client non trouvé."
             ], 404);

        } else {
            $existingClient->delete();

             return response()->json([
                 'status' => 200,
                 'message' => "Le client est supprimé avec succès"
             ], 200);
//            return redirect('/produits')->with('success', "Le produit est supprimé avec succès");
        }
    }
}
