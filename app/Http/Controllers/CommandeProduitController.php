<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CommandeProduit;
use App\Models\Discount;
use Illuminate\Http\Request;

class CommandeProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandeProduit = CommandeProduit::paginate(10);
        if ($commandeProduit->count() > 0) {
            $response = [
                'perPage' => $commandeProduit->perPage(),
                'currentPage' => $commandeProduit->currentPage(),
                'totalCount' => $commandeProduit->total(),
                'totalPages' => $commandeProduit->lastPage(),
                'data' => $commandeProduit->items(),
            ];
            $data = [
                'status' => "200",
                '$commandeProduit' => $response
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
        //
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
