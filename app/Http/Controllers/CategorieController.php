<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Http\Request;

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
