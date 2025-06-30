<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;



class AdminController extends Controller
{
    public function dashboard() {
        $productCount = Product::count();
        $orderCount = Order::count();
        $categoryCount = Category::count();
        $contactMessageCount = ContactMessage::count();

        $monthlySales = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total) as total')
        )
        ->where('status', 'completed') // ✅ Only completed sales
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $chartLabels = $monthlySales->pluck('month')->toArray();
        $chartData = $monthlySales->pluck('total')->toArray();

        $recentOrders = Order::latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'productCount',
            'orderCount',
            'categoryCount',
            'contactMessageCount',
            'recentOrders',
            'chartLabels',
            'chartData'
        ));
    }
}
