<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    public function product()
    {
        $data = DB::table("products as p")
            ->select(
                "p.id as id",
                "p.name as name",
                "p.price as price",
            )->get();

        return response()->json(['message' => 'List of products', 'data' => $data]);
    }

    public function index()
    {
        $productList = DB::table("products as p")
        ->join("companies as c", "c.id", "p.company_id")
        ->join("suppliers as su", "su.id", "p.supplier_id")
        ->select(
            "p.id as id",
            "p.name as name",
            "p.description as description",
            "p.price as price",
            "p.inventory_quantity as inventory_quantity",
            "c.name as name_company",
            "su.company_name as name_supplier"
        )->get();

        if ($productList) {
            return response()->json(['message' => 'List of products found', 'data' => $productList]);
        } else {
            return response()->json(['message' => 'List of products not found']);
        }
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
            'price' => 'required|numeric',
            'inventory_quantity' => 'required|numeric',
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
            'price' => 'required|numeric',
            'inventory_quantity' => 'required|numeric',
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
