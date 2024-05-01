<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use Illuminate\Database\QueryException;


class CustomerController extends Controller
{
    public function index()
    {
        $customerList = Customer::all();

        return response()->json(['message' => 'List of customer', 'data' => $customerList]);
    }

    public function show(string $id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return response()->json(['message' => 'Customer found', 'data' => $customer]);
        } else {
            return response()->json(['message' => 'Customer not found']);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_document' => 'required|string',
            'document' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sex' => 'required|string',
            'address' => 'required|int',
            'phone' => 'required|string',
            'email' => 'required|string',
            'company_id' => 'required|int'
        ]);

        try {
            $customer = new Customer();
            $customer->type_document = $request->type_document;
            $customer->document = $request->document;
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->sex = $request->sex;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->company_id = $request->company_id;
            $customer->save();

            return response()->json(['message' => 'Customer created successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error creating customer: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'type_document' => 'required|string',
            'document' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'sex' => 'required|string',
            'address' => 'required|int',
            'phone' => 'required|string',
            'email' => 'required|string',
            'company_id' => 'required|int'
        ]);

        try {
            $customer = Customer::find($id);
            $customer->type_document = $request->type_document;
            $customer->document = $request->document;
            $customer->first_name = $request->first_name;
            $customer->last_name = $request->last_name;
            $customer->sex = $request->sex;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->company_id = $request->company_id;
            $customer->save();

            return response()->json(['message' => 'Customer updated successfully']);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Error updating customer: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not delete']);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully']);
    }
}
