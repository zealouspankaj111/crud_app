<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = DB::table('products')->count();
        $categoryCount = DB::table('categories')->count();

        return view('dashboard', compact('productCount', 'categoryCount'));
    }
}
