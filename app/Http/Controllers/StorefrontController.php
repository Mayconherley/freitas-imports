<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function home(): View
    {
        return view('store.home', [
            'featuredProducts' => Product::with('category')->where('is_active', true)->where('is_featured', true)->latest()->take(4)->get(),
            'categories' => Category::withCount(['products' => fn ($query) => $query->where('is_active', true)])->get(),
            'newProducts' => Product::with('category')->where('is_active', true)->latest()->take(6)->get(),
        ]);
    }

    public function products(Request $request): View
    {
        $products = Product::with('category')
            ->where('is_active', true)
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($category) => $category->where('slug', $request->string('category'))))
            ->when($request->filled('search'), fn ($query) => $query->where('name', 'like', '%' . $request->string('search') . '%'))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('store.products.index', [
            'products' => $products,
            'categories' => Category::orderBy('name')->get(),
            'currentCategory' => $request->string('category')->toString(),
            'search' => $request->string('search')->toString(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        return view('store.products.show', [
            'product' => $product->load(['category', 'activeVariants']),
            'relatedProducts' => Product::where('is_active', true)
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->take(4)
                ->get(),
        ]);
    }
}
