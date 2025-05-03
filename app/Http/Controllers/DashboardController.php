<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showOrders(): View
    {
        // Initialize empty collection
        $orders = collect();

        // Check if user is authenticated
        if (Auth::check()) {
            // Get orders for logged in user with status filtering options
            $orders = Order::where('user_id', Auth::id())
                ->with('damageDetails')
                ->latest() // Order by newest first
                ->get();

            // If you want to filter by specific status, you can use:
            // $orders = Order::where('user_id', Auth::id())
            //     ->completed() // Using the scope we defined
            //     ->with('damageDetails')
            //     ->get();
        }

        return view('dashboard', [
            'orders' => $orders,
            'statuses' => Order::getStatuses() // Pass statuses to view if needed
        ]);
    }

    // Additional method to filter by status
    public function showOrdersByStatus($status): View
    {
        $orders = collect();

        if (Auth::check()) {
            $orders = Order::where('user_id', Auth::id())
                ->where('status', $status)
                ->with('damageDetails')
                ->get();
        }

        return view('dashboard', [
            'orders' => $orders,
            'currentStatus' => $status,
            'statuses' => Order::getStatuses()
        ]);
    }
}
