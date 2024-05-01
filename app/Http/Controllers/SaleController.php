<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class SaleController extends Controller
{
    public function index()
    {
        $salesList = Sales::all();

        return response()->json(['message' => 'List of sales', 'data' => $salesList]);
    }

    public function show(string $id)
    {
        $sales = Sales::find($id);

        if ($sales) {
            return response()->json(['message' => 'Sales found', 'data' => $sales]);
        } else {
            return response()->json(['message' => 'Sales not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'total' => 'required|string',
            'company_id' => 'required|int',
            'employee_id' => 'required|int',
            'customer_id' => 'required|int'
        ]);

        try {
            $sales = new Sales();
            $sales->date = $request->date;
            $sales->total = $request->total;
            $sales->company_id = $request->company_id;
            $sales->employee_id = $request->employee_id;
            $sales->customer_id = $request->customer_id;
            $sales->save();

            return response()->json(['message' => 'Sales created successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating sales: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'total' => 'required|string',
            'company_id' => 'required|int',
            'employee_id' => 'required|int',
            'customer_id' => 'required|int'
        ]);

        try {
            $sales = Sales::find($id);
            $sales->date = $request->date;
            $sales->total = $request->total;
            $sales->company_id = $request->company_id;
            $sales->employee_id = $request->employee_id;
            $sales->customer_id = $request->customer_id;
            $sales->save();

            return response()->json(['message' => 'Sales updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating sales: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $sales = Sales::find($id);

        if (!$sales) {
            return response()->json(['message' => 'Sales not delete']);
        }

        $sales->delete();

        return response()->json(['message' => 'Sales deleted successfully']);
    }
}
