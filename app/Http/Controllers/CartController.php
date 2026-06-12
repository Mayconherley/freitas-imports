<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('store.cart', $this->cartViewData());
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'variant_id' => ['nullable', 'exists:product_variants,id'],
        ]);

        $variant = null;
        if ($validated['variant_id'] ?? null) {
            $variant = ProductVariant::where('product_id', $product->id)->whereKey($validated['variant_id'])->firstOrFail();
        }

        $cart = session('cart', []);
        $quantity = (int) $validated['quantity'];
        $itemKey = $this->itemKey($product->id, $variant?->id);
        $availableStock = $variant?->stock ?? $product->stock;
        $cart[$itemKey] = min(($cart[$itemKey] ?? 0) + $quantity, max($availableStock, 1));

        session(['cart' => $cart]);

        return to_route('cart.index')->with('success', 'Produto adicionado ao carrinho.');
    }

    public function update(Request $request, string $itemKey): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:50'],
        ]);

        $cart = session('cart', []);
        $quantity = (int) $validated['quantity'];

        if ($quantity === 0) {
            unset($cart[$itemKey]);
        } else {
            $cart[$itemKey] = min($quantity, max($this->stockForItemKey($itemKey), 1));
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Carrinho atualizado.');
    }

    public function destroy(string $itemKey): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$itemKey]);
        session(['cart' => $cart]);

        return back()->with('success', 'Produto removido do carrinho.');
    }

    private function cartViewData(): array
    {
        $items = collect(session('cart', []))->map(function (int $quantity, string $itemKey) {
            [$productId, $variantId] = $this->parseItemKey($itemKey);
            $product = Product::with('activeVariants')->find($productId);

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

    private function itemKey(int $productId, ?int $variantId): string
    {
        return $productId . ':' . ($variantId ?: 0);
    }

    private function parseItemKey(string $itemKey): array
    {
        if (! str_contains($itemKey, ':')) {
            return [(int) $itemKey, null];
        }

        [$productId, $variantId] = explode(':', $itemKey, 2);

        return [(int) $productId, ((int) $variantId) ?: null];
    }

    private function stockForItemKey(string $itemKey): int
    {
        [$productId, $variantId] = $this->parseItemKey($itemKey);

        if ($variantId) {
            return (int) ProductVariant::where('product_id', $productId)->whereKey($variantId)->value('stock');
        }

        return (int) Product::whereKey($productId)->value('stock');
    }
}
