<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerDashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        if (! $request->user()) {
            return to_route('customer.login');
        }

        return view('customer.dashboard', [
            'orders' => Order::with('items')
                ->where('user_id', $request->user()->id)
                ->latest()
                ->paginate(8),
        ]);
    }
}
