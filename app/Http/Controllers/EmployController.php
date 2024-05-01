<?php

namespace App\Http\Controllers;

use App\Models\Employ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class CustomerController extends Controller
{
    public function index()
    {
        $employList = Employ::all();

        return response()->json(['message' => 'List of employ', 'data' => $employList]);
    }

    public function show(string $id)
    {
        $employ = Employ::find($id);

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
            'address' => 'required|int',
            'phone' => 'required|string',
            'email' => 'required|string',
            'company_id' => 'required|int'
        ]);

        try {
            $employ = new employ();
            $employ->type_document = $request->type_document;
            $employ->document = $request->document;
            $employ->first_name = $request->first_name;
            $employ->last_name = $request->last_name;
            $employ->employee_position = $request->employee_position;
            $employ->hire_date = $request->hire_date;
            $employ->salary = $request->salary;
            $employ->sex = $request->sex;
            $employ->address = $request->address;
            $employ->phone = $request->phone;
            $employ->email = $request->email;
            $employ->company_id = $request->company_id;
            $employ->save();

            return response()->json(['message' => 'Employ created successfully']);
        } catch (QueryException $e) {
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
            'address' => 'required|int',
            'phone' => 'required|string',
            'email' => 'required|string',
            'company_id' => 'required|int'
        ]);

        try {
            $employ = Employ::find($id);
            $employ->type_document = $request->type_document;
            $employ->document = $request->document;
            $employ->first_name = $request->first_name;
            $employ->last_name = $request->last_name;
            $employ->employee_position = $request->employee_position;
            $employ->hire_date = $request->hire_date;
            $employ->salary = $request->salary;
            $employ->sex = $request->sex;
            $employ->address = $request->address;
            $employ->phone = $request->phone;
            $employ->email = $request->email;
            $employ->company_id = $request->company_id;
            $employ->save();

            return response()->json(['message' => 'Employ updated successfully']);
        } catch (QueryException $e) {
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
