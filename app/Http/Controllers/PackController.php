<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use Illuminate\Http\Request;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packes = Pack::paginate(8);
        if(!$packes->isEmpty()){
            $response = [
                'perPage' => $packes->perPage(),
                'currentPage' => $packes->currentPage(),
                'totalCount' => $packes->total(),
                'totalPages' => $packes->lastPage(),
                'data' => $packes->items(),
            ];
            $data = [
                'status'=>"200",
                'packs'=>$response
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
        $existingPack= pack::where('codePack', $request->codePack)->first();

        if ($existingPack) {
            return response()->json([
                'status' => 409,
                'Message' => "Pack deja existe."
            ], 409);
        } else {
            $packSaved = Pack::create($request->all());
            if ($packSaved) {
                return response()->json([
                    'status' => 200,
                    'produit' => $packSaved
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
        $existingPacks = Pack::where($column, 'LIKE', "%$param%")->paginate(8);
        if (!$existingPacks) {
            return response()->json([
                'status' => 404,
                'Message' => "Pack non trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingPacks->perPage(),
                'currentPage' => $existingPacks->currentPage(),
                'totalCount' => $existingPacks->total(),
                'totalPages' => $existingPacks->lastPage(),
                'data' => $existingPacks->items(),
            ];
            return response()->json([
                'status' => 200,
                'Message' => "La recherche par $column",
                'pack' => $response
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
        $existingPack = Pack::find($id);
        if (!$existingPack) {
            return response()->json([
                'status' => 404,
                'Message' => "Pack non trouvé."
            ], 404);
        }else{
            $existingPack->update($request->all());
            $response = [
                "status" => 200,
                "pack" =>$existingPack
            ];
            return response()->json($response, 200);
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
        $existingPack = Pack::find($id);

        if (!$existingPack) {
            return response()->json([
                'status' => 404,
                'message' => "Pack non trouvé."
            ], 404);

        } else {
            $existingPack->delete();

            return response()->json([
                'status' => 200,
                'message' => "Le pack est supprimé avec succès"
            ], 200);
        }
    }

}
