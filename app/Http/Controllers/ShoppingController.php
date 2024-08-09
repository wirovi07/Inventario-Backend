<?php

namespace App\Http\Controllers;

use App\Models\Shopping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;

class ShoppingController extends Controller
{
    public function index()
    {
        $buyList = DB::table("shopping as sh")
            ->join("companies as c", "c.id",  "sh.company_id")
            ->join("suppliers as su", "su.id",  "sh.supplier_id")
            ->select(
                "sh.id",
                "sh.date",
                "sh.total",
                "c.name as company",
                "su.contact_name as supplier",
            )
            ->get();

        if ($buyList) {
            return response()->json(['message' => 'List of buys found', 'data' => $buyList]);
        } else {
            return response()->json(['message' => 'List of buys not found']);
        }
    }

    public function show(string $id)
    {
        $shopping = Shopping::find($id);

        if ($shopping) {
            return response()->json(['message' => 'Shopping found', 'data' => $shopping]);
        } else {
            return response()->json(['message' => 'Shopping not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'total' => 'required|string',
            'company_id' => 'required|int',
            'supplier_id' => 'required|int',
        ]);

        try {
            $shopping = new Shopping();
            $shopping->date = $request->date;
            $shopping->total = $request->total;
            $shopping->company_id = $request->company_id;
            $shopping->supplier_id = $request->employee_id;
            $shopping->save();

            return response()->json(['message' => 'Shopping created successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating shopping: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'total' => 'required|string',
            'company_id' => 'required|int',
            'supplier_id' => 'required|int',
        ]);

        try {
            $shopping = Shopping::find($id);
            $shopping->date = $request->date;
            $shopping->total = $request->total;
            $shopping->company_id = $request->company_id;
            $shopping->supplier_id = $request->employee_id;
            $shopping->save();

            return response()->json(['message' => 'Shopping updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating shopping: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $shopping = Shopping::find($id);

        if (!$shopping) {
            return response()->json(['message' => 'Shopping not delete']);
        }

        $shopping->delete();

        return response()->json(['message' => 'Shopping deleted successfully']);
    }
}
