<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('seller')->latest()->get();

        return view('dbpenjualan', compact('sales'));
    }
}
