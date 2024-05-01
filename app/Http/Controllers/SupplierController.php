<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class SupplierController extends Controller
{
    public function index()
    {
        $supplierList = Supplier::all();

        return response()->json(['message' => 'List of supplier', 'data' => $supplierList]);
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
            'company_name' => 'required|date',
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
            'company_name' => 'required|date',
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
