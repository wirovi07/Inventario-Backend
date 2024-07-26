<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Codification;
use App\Models\Saledetails;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class SaleController extends Controller
{
    public function index()
    {
        $saleList = DB::table("sales as sa")
            ->join("customers as cu", "cu.id",  "sa.customer_id")
            ->join("companies as c", "c.id",  "sa.company_id")
            ->join("employees as em", "em.id",  "sa.employee_id")
            ->join("users as us", "us.id", "em.user_id")
            ->select(
                "sa.id as id",
                "sa.date as date",
                "sa.total as total",
                "c.name as company",
                DB::raw("CONCAT(cu.first_name, ' ', cu.last_name) as customer"),
                DB::raw("CONCAT(us.first_name, ' ', us.last_name) as employ")
            )
            ->get();
    
        if ($saleList) {
            return response()->json(['message' => 'List of sales found', 'data' => $saleList]);
        } else {
            return response()->json(['message' => 'List of sales not found']);
        }
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
            'total' => 'required',
            'customer_id' => 'required',
            'products' => 'required|array',
            'products.*.product_id' => 'required|int',
            'products.*.amount' => 'required|numeric',
            'products.*.unit_price' => 'required|string',
            'products.*.subtotal' => 'required|numeric'
        ]);
    
        $customer_id = $request->input('customer_id');
    
        try {
            DB::beginTransaction();
            $sales = new Sales();
            $sales->date = now(); 
            $sales->total = $request->total;
            $sales->company_id = $request->company_id;
            $sales->employee_id = $request->employee_id;
            $sales->customer_id = $request->customer_id; 
            $sales->save();

            $sale_id = $sales->id;

            foreach ($request->products as $product) {
                $saledetail = new Saledetails();
                $saledetail->sale_id = $sale_id;
                $saledetail->product_id = $product['product_id'];
                $saledetail->amount = $product['amount'];
                $saledetail->unit_price = $product['unit_price'];
                $saledetail->subtotal = $product['subtotal'];
                $saledetail->save();
            }

            DB::commit();
    
            return response()->json(['message' => 'Sales created successfully']);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error creating sales: ' . $e->getMessage()], 500);
        }
    }
    
    

    public function update(Request $request, string $id)
    {

        $customer_id = $request->customer_id['id'];

        $request->validate([
            'date' => 'required|date',
            'total' => 'required|string',
            'company_id' => 'required|int',
            'employee_id' => 'required|int',
            'customer_id.id' => 'required|int'
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
