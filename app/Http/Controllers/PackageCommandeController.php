<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\CommandePackage;
use Illuminate\Http\Request;

class PackageCommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = CommandePackage::with('client', 'pack')->paginate(5);
        if(!$commandes->isEmpty()){
            $response = [
                'perPage' => $commandes->perPage(),
                'currentPage' => $commandes->currentPage(),
                'totalCount' => $commandes->total(),
                'totalPages' => $commandes->lastPage(),
                'data' => $commandes->items(),
            ];
            $data = [
                'status'=>"200",
                'commandes'=>$response
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
        // $commandeData = $request->only(['','pack_command_id', 'price', 'client_id']);
        $commandeData = $request->all();


        $commandeSaved = CommandePackage::create($commandeData);


        if ($commandeSaved) {
            return response()->json([
                'status' => 200,
                'commande' => $commandeSaved
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
