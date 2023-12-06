<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discount = Discount::paginate(10);
        if ($discount->count() > 0) {
            $response = [
                'perPage' => $discount->perPage(),
                'currentPage' => $discount->currentPage(),
                'totalCount' => $discount->total(),
                'totalPages' => $discount->lastPage(),
                'data' => $discount->items(),
            ];
            $data = [
                'status' => "200",
                'discount' => $response
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
        $existingDiscount = Discount::where('type', $request->type)->first();
        if ($existingDiscount) {
            $response = [
                'status' => 409,
                "message" => "Discount deja existe."
            ];
            return response()->json($response, 409);
        }
        $discountSaved = Discount::create($request->all());
        if ($discountSaved) {
            $response = [
                'status' => 200,
                "discount" => $discountSaved
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $existingDiscount = Discount::find($id);
        if (!$existingDiscount) {
            return response()->json([
                'status' => 404,
                'Message' => "Discount non trouvé."
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'data' => $existingDiscount
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
        $existingDiscount = Discount::find($id);
        if (!$existingDiscount) {
            return response()->json([
                'status' => 404,
                'Message' => "OrderStatus non trouvé."
            ], 404);
        } else {
            $existingDiscount->update($request->all());

            return response()->json([
                'status' => 404,
                'data' => "Le discount est modifié avec succés"
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
        $existingDiscount = Discount::find($id);
        if (!$existingDiscount) {
            $response = [
                "status" => 404,
                "message" => "Le discount à mettre à jour n'a pas été trouvé."
            ];
            return response()->json($response, 404);
        }
        $existingDiscount->delete();
        return response()->json([
            'status' => 200,
            'message' => "Le discount est supprimé avec succès"
        ], 200);
    }
}
