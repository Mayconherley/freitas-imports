<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'revenue' => Order::sum('total'),
            'ordersCount' => Order::count(),
            'productsCount' => Product::count(),
            'lowStockCount' => Product::where('stock', '<=', 5)->count(),
            'recentOrders' => Order::latest()->take(6)->get(),
            'lowStockProducts' => Product::with('category')->where('stock', '<=', 5)->orderBy('stock')->take(6)->get(),
        ]);
    }
}
