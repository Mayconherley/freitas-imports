<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.orders.index', [
            'orders' => Order::when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
                ->latest()
                ->paginate(12)
                ->withQueryString(),
            'status' => $request->string('status')->toString(),
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', ['order' => $order->load(['items.product', 'histories.user'])]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:novo,separacao,enviado,concluido,cancelado'],
            'payment_status' => ['nullable', 'in:aguardando,pago,estornado'],
        ]);

        $order->update($validated);

        $order->histories()->create([
            'user_id' => $request->user()->id,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'notes' => 'Atualizado pela gestao.',
        ]);

        return back()->with('success', 'Status atualizado.');
    }
}
