<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class CompanyController extends Controller
{
    public function index()
    {
        $companyList = Company::all();

        return response()->json(['message' => 'List of company', 'data' => $companyList]);
    }

    public function show(string $id)
    {
        $company = DB::table("companies as c")
        ->join("users as u", "c.user_id", "u.id")
        ->where("c.id", $id)
        ->select(
            "c.*",
            "u.first_name as first_name"
        )->first();

        if ($company) {
            return response()->json(['message' => 'Company found', 'data' => $company]);
        } else {
            return response()->json(['message' => 'Company not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nit' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
        ]);
        
        DB::beginTransaction();

        try {
            $company = new Company();
            $company->nit = $request->nit;
            $company->name = $request->name;
            $company->address = $request->address;
            $company->phone = $request->phone;
            $company->email = $request->email;
            $company->user_id = Auth::id();
            $company->save();

        DB::commit();

            return response()->json(['message' => 'Company created successfully']);
        } catch (QueryException $e) {
        DB::rollBack();
            return response()->json(['message' => 'Error creating Company: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nit' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
        ]);

        try {
            $company = Company::find($id);
            $company->nit = $request->nit;
            $company->name = $request->name;
            $company->address = $request->address;
            $company->phone = $request->phone;
            $company->email = $request->email;
            $company->save();

            return response()->json(['message' => 'Company updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating Company: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $company = Company::find($id);

        if (!$company) {
            return response()->json(['message' => 'Company not delete']);
        }

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
