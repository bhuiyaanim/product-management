<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\ProductStock;
use App\Models\ReturnProduct;


class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalStockIn = ProductStock::where('status', ProductStock::STOCK_IN)->count();
        $totalReturnProducts = ReturnProduct::count();
        $recentProducts = Product::latest()->limit(10)->get();

        return view('dashboard', compact('totalProducts', 'totalUsers', 'totalStockIn', 'totalReturnProducts', 'recentProducts'));
    }
}
