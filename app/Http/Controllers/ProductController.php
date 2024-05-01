<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class ProductController extends Controller
{
    public function index()
    {
        $productList = Product::all();

        return response()->json(['message' => 'List of product', 'data' => $productList]);
    }

    public function show(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json(['message' => 'Product found', 'data' => $product]);
        } else {
            return response()->json(['message' => 'Product not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'inventory_quantity' => 'required|string',
            'company_id' => 'required|int',
            'supplier_id' => 'required|int'
        ]);

        try {
            $product = new product();
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->inventory_quantity = $request->inventory_quantity;
            $product->company_id = $request->company_id;
            $product->supplier_id = $request->supplier_id;
            $product->save();

            return response()->json(['message' => 'Product created successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating product: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'inventory_quantity' => 'required|string',
            'company_id' => 'required|int',
            'supplier_id' => 'required|int'
        ]);

        try {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->inventory_quantity = $request->inventory_quantity;
            $product->company_id = $request->company_id;
            $product->supplier_id = $request->supplier_id;
            $product->save();

            return response()->json(['message' => 'Product updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating product: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not delete']);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
