<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaledetailsController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\ShoppingdetailsController;
use App\Http\Controllers\SupplierController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:api'], function () {

        //EMPLOY
        Route::get('employ', [EmployController::class, 'index']);
        Route::get('employ/{id}', [EmployController::class, 'show']);
        Route::post('employ', [EmployController::class, 'store']);
        Route::put('employ/{id}', [EmployController::class, 'update']);
        Route::delete('employ/{id}', [EmployController::class, 'destroy']);

        //COMPANY
        Route::get('company', [CompanyController::class, 'index']);
        Route::get('company/{id}', [CompanyController::class, 'show']);
        Route::post('company', [CompanyController::class, 'store']);
        Route::put('company/{id}', [CompanyController::class, 'update']);
        Route::delete('company/{id}', [CompanyController::class, 'destroy']);

        //CUSTOMER
        Route::get('customer', [CustomerController::class, 'index']);
        Route::get('customer/{id}', [CustomerController::class, 'show']);
        Route::post('customer', [CustomerController::class, 'store']);
        Route::put('customer/{id}', [CustomerController::class, 'update']);
        Route::delete('customer/{id}', [CustomerController::class, 'destroy']);

        //PRODUCT
        Route::get('product', [ProductController::class, 'index']);
        Route::get('product/{id}', [ProductController::class, 'show']);
        Route::post('product', [ProductController::class, 'store']);
        Route::put('product/{id}', [ProductController::class, 'update']);
        Route::delete('product/{id}', [ProductController::class, 'destroy']);

        //SALE
        Route::get('sale', [SaleController::class, 'index']);
        Route::get('sale/{id}', [SaleController::class, 'show']);
        Route::post('sale', [SaleController::class, 'store']);
        Route::put('sale/{id}', [SaleController::class, 'update']);
        Route::delete('sale/{id}', [SaleController::class, 'destroy']);

        //SALE-DETAILS
        Route::get('saledetails', [SaledetailsController::class, 'index']);
        Route::get('saledetails/{id}', [SaledetailsController::class, 'show']);
        Route::post('saledetails', [SaledetailsController::class, 'store']);
        Route::put('saledetails/{id}', [SaledetailsController::class, 'update']);
        Route::delete('saledetails/{id}', [SaledetailsController::class, 'destroy']);

        //SHOPPING
        Route::get('shopping', [ShoppingController::class, 'index']);
        Route::get('shopping/{id}', [ShoppingController::class, 'show']);
        Route::post('shopping', [ShoppingController::class, 'store']);
        Route::put('shopping/{id}', [ShoppingController::class, 'update']);
        Route::delete('shopping/{id}', [ShoppingController::class, 'destroy']);

        //SHOPPING-DETAILS
        Route::get('shoppingdetails', [ShoppingdetailsController::class, 'index']);
        Route::get('shoppingdetails/{id}', [ShoppingdetailsController::class, 'show']);
        Route::post('shoppingdetails', [ShoppingdetailsController::class, 'store']);
        Route::put('shoppingdetails/{id}', [ShoppingdetailsController::class, 'update']);
        Route::delete('shoppingdetails/{id}', [ShoppingdetailsController::class, 'destroy']);

        //SUPPLIER
        Route::get('supplier', [SupplierController::class, 'index']);
        Route::get('supplier/{id}', [SupplierController::class, 'show']);
        Route::post('supplier', [SupplierController::class, 'store']);
        Route::put('supplier/{id}', [SupplierController::class, 'update']);
        Route::delete('supplier/{id}', [SupplierController::class, 'destroy']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
