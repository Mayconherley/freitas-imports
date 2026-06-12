@extends('layouts.store', ['title' => $product->name . ' - Freitas Imports'])

@section('content')
<section class="mx-auto grid max-w-7xl gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[.95fr_1.05fr] lg:px-8">
    <div class="overflow-hidden rounded-lg bg-white ring-1 ring-black/10">
        <img src="{{ $product->image_src }}" alt="{{ $product->name }}" class="h-full max-h-[720px] w-full object-cover">
    </div>
    <div class="lg:py-8">
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-sm font-semibold uppercase tracking-[.16em] text-[#a3482a]">{{ $product->category->name }}</a>
        <h1 class="mt-3 text-4xl font-bold">{{ $product->name }}</h1>
        <div class="mt-4 flex flex-wrap items-baseline gap-3">
            <p class="text-3xl font-bold">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            @if ($product->compare_at_price)
                <p class="text-lg text-[#756f66] line-through">R$ {{ number_format($product->compare_at_price, 2, ',', '.') }}</p>
            @endif
        </div>
        <p class="mt-6 leading-7 text-[#5f5a52]">{{ $product->description }}</p>
        <dl class="mt-6 grid gap-3 sm:grid-cols-3">
            <div class="rounded-lg bg-white p-4 ring-1 ring-black/10"><dt class="text-xs text-[#756f66]">Estoque</dt><dd class="font-bold">{{ $product->stock }} un.</dd></div>
            <div class="rounded-lg bg-white p-4 ring-1 ring-black/10"><dt class="text-xs text-[#756f66]">Tamanho</dt><dd class="font-bold">{{ $product->size ?? 'Unico' }}</dd></div>
            <div class="rounded-lg bg-white p-4 ring-1 ring-black/10"><dt class="text-xs text-[#756f66]">Cor</dt><dd class="font-bold">{{ $product->color ?? 'Variado' }}</dd></div>
        </dl>
        <form action="{{ route('cart.store', $product) }}" method="POST" class="mt-8 grid gap-3 sm:grid-cols-[1fr_120px]">
            @csrf
            @if ($product->activeVariants->isNotEmpty())
                <select name="variant_id" class="rounded-lg border border-black/15 bg-white px-4 py-3">
                    <option value="">Escolha uma variacao</option>
                    @foreach ($product->activeVariants as $variant)
                        <option value="{{ $variant->id }}">{{ $variant->label() }} | estoque {{ $variant->stock }} | R$ {{ number_format($product->price + $variant->price_adjustment, 2, ',', '.') }}</option>
                    @endforeach
                </select>
            @else
                <div class="rounded-lg border border-black/15 bg-white px-4 py-3 text-sm text-[#756f66]">Produto padrao</div>
            @endif
            <input type="number" name="quantity" min="1" max="{{ max($product->stock, 1) }}" value="1" class="rounded-lg border border-black/15 bg-white px-4 py-3">
            <button class="rounded-lg bg-[#a3482a] px-6 py-3 text-sm font-bold text-white sm:col-span-2">Adicionar ao carrinho</button>
            <a href="{{ route('products.index') }}" class="rounded-lg border border-black/15 px-6 py-3 text-center text-sm font-bold sm:col-span-2">Continuar comprando</a>
        </form>
    </div>
</section>

@if ($relatedProducts->isNotEmpty())
    <section class="mx-auto mt-8 max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold">Tambem combina</h2>
        <div class="mt-5 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($relatedProducts as $product)
                @include('store.products.partials.card', ['product' => $product])
            @endforeach
        </div>
    </section>
@endif
@endsection
