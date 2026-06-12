<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $data = $this->cartData();

        if ($data['items']->isEmpty()) {
            return to_route('cart.index')->with('success', 'Adicione produtos antes de finalizar o pedido.');
        }

        return view('store.checkout', $data);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->cartData();

        if ($data['items']->isEmpty()) {
            return to_route('cart.index');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_email' => ['required', 'email', 'max:160'],
            'customer_phone' => ['required', 'string', 'max:40'],
            'shipping_method' => ['required', 'in:retirada,entrega'],
            'shipping_zip' => ['nullable', 'string', 'max:20'],
            'shipping_street' => ['nullable', 'string', 'max:180'],
            'shipping_number' => ['nullable', 'string', 'max:30'],
            'shipping_complement' => ['nullable', 'string', 'max:120'],
            'shipping_neighborhood' => ['nullable', 'string', 'max:120'],
            'shipping_city' => ['nullable', 'string', 'max:120'],
            'shipping_state' => ['nullable', 'string', 'max:2'],
            'payment_method' => ['required', 'in:pix,cartao,dinheiro'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        foreach ($data['items'] as $item) {
            if ($item['quantity'] > $item['available_stock']) {
                return to_route('cart.index')->with('success', 'Ajuste o carrinho: um dos itens esta com estoque insuficiente.');
            }
        }

        $order = DB::transaction(function () use ($validated, $data) {
            $order = Order::create([
                'code' => 'IMP-' . now()->format('ymd') . '-' . random_int(1000, 9999),
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'payment_method' => $validated['payment_method'],
                'shipping_method' => $validated['shipping_method'],
                'shipping_address' => $this->shippingAddress($validated),
                'shipping_zip' => $validated['shipping_zip'] ?? null,
                'shipping_city' => $validated['shipping_city'] ?? null,
                'shipping_state' => $validated['shipping_state'] ?? null,
                'subtotal' => $data['subtotal'],
                'shipping_total' => $validated['shipping_method'] === 'entrega' ? 18 : 0,
                'total' => $data['subtotal'] + ($validated['shipping_method'] === 'entrega' ? 18 : 0),
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $product = $item['product'];
                $variant = $item['variant'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_variant_id' => $variant?->id,
                    'product_name' => $product->name,
                    'variant_label' => $variant?->label(),
                    'sku' => $variant?->sku ?: $product->sku,
                    'unit_price' => $item['unit_price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['total'],
                ]);

                if ($variant) {
                    $variant->decrement('stock', min($item['quantity'], $variant->stock));
                }

                $product->decrement('stock', min($item['quantity'], $product->stock));
            }

            return $order;
        });

        $order->histories()->create([
            'user_id' => auth()->id(),
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'notes' => 'Pedido criado pelo checkout.',
        ]);

        session()->forget('cart');

        return to_route('checkout.success', ['order' => $order->code])->with('success', 'Pedido criado com sucesso.');
    }

    public function success(Order $order): View
    {
        return view('store.order-success', ['order' => $order->load('items')]);
    }

    private function cartData(): array
    {
        $items = collect(session('cart', []))->map(function (int $quantity, string $itemKey) {
            [$productId, $variantId] = $this->parseItemKey($itemKey);
            $product = Product::find($productId);

            if (! $product) {
                return null;
            }

            $variant = $variantId ? ProductVariant::find($variantId) : null;
            $unitPrice = (float) $product->price + (float) ($variant?->price_adjustment ?? 0);

            return [
                'key' => $itemKey,
                'product' => $product,
                'variant' => $variant,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'available_stock' => $variant?->stock ?? $product->stock,
                'total' => $unitPrice * $quantity,
            ];
        })->filter()->values();

        return [
            'items' => $items,
            'subtotal' => $items->sum('total'),
            'shipping' => $items->isEmpty() ? 0 : 18,
            'total' => $items->sum('total') + ($items->isEmpty() ? 0 : 18),
        ];
    }

    private function parseItemKey(string $itemKey): array
    {
        if (! str_contains($itemKey, ':')) {
            return [(int) $itemKey, null];
        }

        [$productId, $variantId] = explode(':', $itemKey, 2);

        return [(int) $productId, ((int) $variantId) ?: null];
    }

    private function shippingAddress(array $data): ?string
    {
        if (($data['shipping_method'] ?? 'retirada') === 'retirada') {
            return null;
        }

        return collect([
            trim(($data['shipping_street'] ?? '') . ', ' . ($data['shipping_number'] ?? '')),
            $data['shipping_complement'] ?? null,
            $data['shipping_neighborhood'] ?? null,
            $data['shipping_city'] ?? null,
            $data['shipping_state'] ?? null,
            $data['shipping_zip'] ?? null,
        ])->filter()->implode(' - ');
    }
}
