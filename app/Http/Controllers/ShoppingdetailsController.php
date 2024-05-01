<?php

namespace App\Http\Controllers;

use App\Models\Shoppingdetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class ShoppingdetailsController extends Controller
{
    public function index()
    {
        $shoppingdetailList = Shoppingdetails::all();

        return response()->json(['message' => 'List of shoppingdetails', 'data' => $shoppingdetailList]);
    }

    public function show(string $id)
    {
        $shoppingdetail = Shoppingdetails::find($id);

        if ($shoppingdetail) {
            return response()->json(['message' => 'Shoppingdetails found', 'data' => $shoppingdetail]);
        } else {
            return response()->json(['message' => 'Shoppingdetails not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|date',
            'unit_price' => 'required|string',
            'subtotal' => 'required|string',
            'buy_id' => 'required|int',
            'product_id' => 'required|int',
        ]);

        try {
            $shoppingdetail = new Shoppingdetails();
            $shoppingdetail->date = $request->date;
            $shoppingdetail->total = $request->total;
            $shoppingdetail->company_id = $request->company_id;
            $shoppingdetail->supplier_id = $request->employee_id;
            $shoppingdetail->save();

            return response()->json(['message' => 'Shoppingdetails created successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating Shoppingdetails: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|date',
            'unit_price' => 'required|string',
            'subtotal' => 'required|string',
            'buy_id' => 'required|int',
            'product_id' => 'required|int',
        ]);

        try {
            $shoppingdetail = Shoppingdetails::find($id);
            $shoppingdetail->date = $request->date;
            $shoppingdetail->total = $request->total;
            $shoppingdetail->company_id = $request->company_id;
            $shoppingdetail->supplier_id = $request->employee_id;
            $shoppingdetail->save();

            return response()->json(['message' => 'Shoppingdetails updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating shoppingdetails: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $shoppingdetail = Shoppingdetails::find($id);

        if (!$shoppingdetail) {
            return response()->json(['message' => 'Shoppingdetails not delete']);
        }

        $shoppingdetail->delete();

        return response()->json(['message' => 'Shoppingdetails deleted successfully']);
    }
}
