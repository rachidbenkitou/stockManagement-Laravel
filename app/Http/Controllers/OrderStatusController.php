<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderStatus = OrderStatus::paginate(10);
        if ($orderStatus->count() > 0) {
            $response = [
                'perPage' => $orderStatus->perPage(),
                'currentPage' => $orderStatus->currentPage(),
                'totalCount' => $orderStatus->total(),
                'totalPages' => $orderStatus->lastPage(),
                'data' => $orderStatus->items(),
            ];
            $data = [
                'status' => "200",
                'orderStatuses' => $response
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
        $existingOrderStatuses = OrderStatus::where('status', $request->status)->first();
        if ($existingOrderStatuses) {
            $response = [
                'status' => 409,
                "message" => "Statut deja existe."
            ];
            return response()->json($response, 409);
        }
        $existingOrderStatuseSaved = OrderStatus::create($request->all());
        if ($existingOrderStatuseSaved) {
            $response = [
                'status' => 200,
                "orderStatus" => $existingOrderStatuseSaved
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
     * @param \App\Models\OrderStatus $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $existingOrderStatus = OrderStatus::find($id);
        if (!$existingOrderStatus) {
            return response()->json([
                'status' => 404,
                'Message' => "OrderStatus non trouvé."
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'data' => $existingOrderStatus
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\OrderStatus $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderStatus $orderStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\OrderStatus $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existingOrderStatus = OrderStatus::find($id);
        if (!$existingOrderStatus) {
            return response()->json([
                'status' => 404,
                'Message' => "OrderStatus non trouvé."
            ], 404);
        } else {
            $existingOrderStatus->update($request->all());
            //return redirect('/commandes')->with('Sucess','Data updated');

            return response()->json([
                'status' => 404,
                'data' => "Le statut est modifié avec succés"
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\OrderStatus $orderStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingOrderStatus = OrderStatus::find($id);
        if (!$existingOrderStatus) {
            $response = [
                "status" => 404,
                "message" => "Le statut à mettre à jour n'a pas été trouvé."
            ];
            return response()->json($response, 404);
        }
        $existingOrderStatus->delete();
        return response()->json([
            'status' => 200,
            'message' => "Le statut est supprimé avec succès"
        ], 200);
    }
}
