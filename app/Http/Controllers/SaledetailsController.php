<?php

namespace App\Http\Controllers;

use App\Models\Saledetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class SaledetailsController extends Controller
{
    public function index()
    {
        $saledetailsList = Saledetails::all();

        return response()->json(['message' => 'List of saledetails', 'data' => $saledetailsList]);
    }

    public function show(string $id)
    {
        $saledetails = Saledetails::find($id);

        if ($saledetails) {
            return response()->json(['message' => 'Saledetails found', 'data' => $saledetails]);
        } else {
            return response()->json(['message' => 'Saledetails not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required|int',
            'products' => 'required|array',
            'products.*.product_id' => 'required|int',
            'products.*.amount' => 'required|numeric',
            'products.*.unit_price' => 'required|string',
            'products.*.subtotal' => 'required|numeric'
        ]);
    
        try {
            foreach ($request->products as $product) {
                $saledetail = new Saledetails();
                $saledetail->sale_id = $request->sale_id;
                $saledetail->product_id = $product['product_id'];
                $saledetail->amount = $product['amount'];
                $saledetail->unit_price = $product['unit_price'];
                $saledetail->subtotal = $product['subtotal'];
                $saledetail->save();
            }
    
            return response()->json(['message' => 'Saledetails created successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating saledetails: ' . $e->getMessage()], 500);
        }
    }
    

    public function update(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|string',
            'unit_price' => 'required|string',
            'subtotal' => 'required|string',
            'sale_id' => 'required|int',
            'product_id' => 'required|int'
        ]);

        try {
            $saledetails = Saledetails::find($id);
            $saledetails->amount = $request->amount;
            $saledetails->unit_price = $request->unit_price;
            $saledetails->subtotal = $request->subtotal;
            $saledetails->sale_id = $request->sale_id;
            $saledetails->product_id = $request->product_id;
            $saledetails->save();

            return response()->json(['message' => 'Saledetails updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating saledetails: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $saledetails = Saledetails::find($id);

        if (!$saledetails) {
            return response()->json(['message' => 'Saledetails not delete']);
        }

        $saledetails->delete();

        return response()->json(['message' => 'Saledetails deleted successfully']);
    }
}
