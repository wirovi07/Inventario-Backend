<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function supplier()
    {
        $data = DB::table("suppliers as su")
        ->select(
        "su.id as id",
            "su.company_name as name",
        )->get();

        return response()->json(['message' => 'List of suppliers', 'data' => $data]);
    }

    public function index()
    {
        $supplierList = DB::table("suppliers as su")
        ->join("companies as c", "c.id", "su.company_id")
        ->select(
            "su.id as id",
            "su.company_name as company_name",
            "su.contact_name as contact_name",
            "su.address as address",
            "su.email as email",
            "su.phone as phone",
            "c.name as name_company"
        )->get();

        if ($supplierList) {
            return response()->json(['message' => 'List of suppliers found', 'data' => $supplierList]);
        } else {
            return response()->json(['message' => 'List of suppliers not found']);
        }
    }

    public function show(string $id)
    {
        $supplier = Supplier::find($id);

        if ($supplier) {
            return response()->json(['message' => 'Supplier found', 'data' => $supplier]);
        } else {
            return response()->json(['message' => 'Supplier not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'contact_name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'company_id' => 'required|int',
        ]);

        try {
            $supplier = new Supplier();
            $supplier->company_name = $request->company_name;
            $supplier->contact_name = $request->contact_name;
            $supplier->address = $request->address;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->company_id = $request->company_id;
            $supplier->save();

            return response()->json(['message' => 'Supplier created successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating supplier: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'company_name' => 'required|string',
            'contact_name' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'company_id' => 'required|int',
        ]);

        try {
            $supplier = Supplier::find($id);
            $supplier->company_name = $request->company_name;
            $supplier->contact_name = $request->contact_name;
            $supplier->address = $request->address;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->company_id = $request->company_id;
            $supplier->save();

            return response()->json(['message' => 'Supplier updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating supplier: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $supplier = Supplier::find($id);

        if (!$supplier) {
            return response()->json(['message' => 'Supplier not delete']);
        }

        $supplier->delete();

        return response()->json(['message' => 'Supplier deleted successfully']);
    }
}
