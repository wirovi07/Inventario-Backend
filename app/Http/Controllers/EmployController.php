<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class EmployController extends Controller
{
    public function index()
    {
        $employList = DB::table("employees as e")
            ->join("users as u", "u.id",  "e.user_id")
            ->join("companies as c", "c.id",  "e.company_id")
            ->select(
                "e.id as id",
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as name"),
                "u.type_document as type_document",
                "u.document as document",
                "e.employee_position as employee_position", 
                "e.hire_date as hire_date",                  
                "e.salary as salary",                        
                "u.sex as sex",
                "u.address as address",
                "u.phone as phone",
                "u.email as email",
                "c.name as name_company"
            )->get();
    
        if ($employList) {
            return response()->json(['message' => 'List of employees found', 'data' => $employList]);
        } else {
            return response()->json(['message' => 'List of employees not found']);
        }
    }
    
    public function show(string $id)
    {
        $employ = DB::table("employees as e")
        ->join("users as u", "u.id",  "e.user_id")
        ->join("companies as c", "e.company_id", "c.id")
        ->where("e.id", $id)
        ->select(
            "e.id as id",
            "u.type_document as type_document",
            "u.document as document",
            "u.first_name as first_name",
            "u.last_name as last_name",
            "e.employee_position as employee_position",
            "e.hire_date as hire_date",
            "e.salary as salary",
            "u.sex as sex",
            "u.address as address",
            "u.phone as phone",
            "u.email as email",
            "c.id as company_id",
            "c.name as name"
        )->first();

        if ($employ) {
            return response()->json(['message' => 'Employ found', 'data' => $employ]);
        } else {
            return response()->json(['message' => 'Employ not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_document' => 'required|string',
            'document' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'employee_position' => 'required|string',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric',
            'sex' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'password' => 'required',
            'company_id' => 'required|int'
        ]);
    
        DB::beginTransaction();
    
        try {
            $user = new User();
            $user->type_document = $request->type_document;
            $user->document = $request->document;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->rol = "empleado";
            $user->sex = $request->sex;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
    
            $employ = new Employ();
            $employ->employee_position = $request->employee_position;
            $employ->hire_date = $request->hire_date;
            $employ->salary = $request->salary;
            $employ->company_id = $request->company_id;
            $employ->user_id = $user->id; 
            $employ->save();
    
            DB::commit();
            return response()->json(['message' => 'Employ created successfully']);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating employ: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_document' => 'required|string',
            'document' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'employee_position' => 'required|string',
            'hire_date' => 'required|date',
            'salary' => 'required|numeric',
            'sex' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|string',
            'company_id' => 'required|int'
        ]);
    
        DB::beginTransaction();
    
        try {
            $employ = Employ::findOrFail($id);
            $user = User::findOrFail($employ->user_id);
    
            $employ->employee_position = $request->employee_position;
            $employ->hire_date = $request->hire_date;
            $employ->salary = $request->salary;
            $employ->company_id = $request->company_id;
            $employ->save();
    
            $user->type_document = $request->type_document;
            $user->document = $request->document;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->sex = $request->sex;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->save();
    
            DB::commit();
            return response()->json(['message' => 'Employ updated successfully']);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error updating employ: ' . $e->getMessage()], 500);
        }
    }
    
    public function destroy(string $id)
    {
        $employ = Employ::find($id);

        if (!$employ) {
            return response()->json(['message' => 'Employ not delete']);
        }

        $employ->delete();

        return response()->json(['message' => 'Employ deleted successfully']);
    }
}
