<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use stdClass;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commandes = Commande::whereHas('produits')->with('client', 'orderStatus','produits')->paginate(5);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $commandeData = $request->only(['','date_commande', 'prix', 'client_id', 'orderStatus_id', 'discount_id']);
        $produitsData = $request->input('produits', []);

        if (!isset($commandeData['date_commande'])) {
            $commandeData['date_commande'] = now()->toDateString();
        }

        $productController = new PrduitController();
        $productsOutOfStock = [];
        $test = new stdClass();


        // Iterate through each product in $produitsData
        foreach ($produitsData as $produit) {
            $productId = $produit['produit_id'];
            $quantity = $produit['quantity'];

            // Fetch the product by ID from the ProductController API
            $product = $productController->show('id',$productId);


            $jsonData = $product->getData();
            $data = $jsonData->produits->data[0];




            if (!$data || $data->quantite < $quantity) {
                // Product does not exist or quantity is insufficient
                $productsOutOfStock[] = $productId;

            } else {
                $newQuantity = $data->quantite - $quantity;
                $data->quantite=$newQuantity;
                // Convert stdClass to array
                $dataArray = json_decode(json_encode($data), true);
                // Now create the Request object
                $request = new Request($dataArray);
                $test=$productController->update($request, $productId);

            }
        }

        if (!empty($productsOutOfStock)) {
            // Some products are out of stock
            return response()->json([
                'status' => 400,
                'message' => 'Some products are out of stock',
                'out_of_stock_products' => $productsOutOfStock
            ], 400);
        }

        $commandeSaved = Commande::create($commandeData);

        if ($commandeSaved) {
            $commandeId = $commandeSaved->id;

            if (!empty($produitsData)) {
                $commandeSaved->produits()->attach($produitsData, ['commande_id' => $commandeId]);
            }
        }

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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request)
    {
        $commandeData = $request->only(['','date_commande', 'prix', 'client_id', 'orderStatus_id', 'discount_id']);
        $produitsData = $request->input('packs', []);

        if (!isset($commandeData['date_commande'])) {
            $commandeData['date_commande'] = now()->toDateString();
        }

        $commandeSaved = Commande::create($commandeData);

        if ($commandeSaved) {
            $commandeId = $commandeSaved->id;

            if (!empty($produitsData)) {
                $commandeSaved->packs()->attach($produitsData, ['commande_id' => $commandeId]);
            }
        }

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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $existingCommande = Commande::find($id);
        if (!$existingCommande) {
            return response()->json([
                'status' => 404,
                'Message' => "Commande non trouvé."
            ], 404);
        } else {
            return response()->json([
                'status' => 200,
                'data' => $existingCommande
            ], 200);
        }
    }
    public function show1($column, $param){

        $existingCommandes =Commande::whereHas('produits')->with('client', 'orderStatus','produits')
            ->where($column, 'LIKE', "%$param%")
            ->paginate(8);

        if (!$existingCommandes) {
            return response()->json([
                'status' => 404,
                'Message' => "Commande non trouvé."
            ], 404);
        } else {
            $response = [
                'perPage' => $existingCommandes->perPage(),
                'currentPage' => $existingCommandes->currentPage(),
                'totalCount' => $existingCommandes->total(),
                'totalPages' => $existingCommandes->lastPage(),
                'data' => $existingCommandes->items(),
            ];
            return response()->json([
                'status' => 200,
                'Message' => "La recherche par $column",
                'commande' => $response
            ], 200);
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
        $existingCommande = Commande::find($id);
        if (!$existingCommande) {
            return response()->json([
                'status' => 404,
                'Message' => "Commande non trouvé."
            ], 404);
        } else {
            $existingCommande->update($request->all());
            //return redirect('/commandes')->with('Sucess','Data updated');

            $response = [
                "status" => 200,
                "data" =>$existingCommande
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingCommande = Commande::find($id);

        if (!$existingCommande) {
            return response()->json([
                'status' => 404,
                'message' => "Commande non trouvé."
            ], 404);
            //return redirect('/commandes')->with('success', 'Commande supprimé avec succès.');

        } else {
            $existingCommande->delete();

            return response()->json([
                'status' => 200,
                'message' => "La commande est supprimé avec succès"
            ], 200);
        }
    }
}
