@extends('layouts.store', ['title' => 'Freitas Imports'])

@section('content')
<section class="mx-auto grid max-w-7xl gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[1.1fr_.9fr] lg:px-8">
    <div class="flex min-h-[520px] flex-col justify-between rounded-lg bg-[#06166f] p-8 text-white sm:p-10">
        <div>
            <img src="{{ asset('images/freitas-imports-logo.png') }}" alt="Freitas Imports" class="h-24 w-24 rounded-full object-cover ring-4 ring-white/15">
            <p class="mt-6 text-sm font-semibold uppercase tracking-[.16em] text-white/70">O essencial para se vestir bem</p>
            <h1 class="mt-5 max-w-2xl text-4xl font-bold leading-tight sm:text-6xl">Freitas Imports</h1>
            <p class="mt-5 max-w-xl text-base text-white/75">Moda, perfumes e achados selecionados com compra simples, atendimento direto e retirada ou entrega local.</p>
        </div>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="rounded-lg bg-[#d40000] px-5 py-3 text-sm font-bold text-white">Comprar agora</a>
            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-white/25 px-5 py-3 text-sm font-semibold text-white">Abrir gestao</a>
        </div>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
        @foreach ($featuredProducts->take(2) as $product)
            <a href="{{ route('products.show', ['product' => $product->slug]) }}" class="group overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-black/10">
                <img src="{{ $product->image_src }}" alt="{{ $product->name }}" class="h-44 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-52 lg:h-56">
                <div class="p-5">
                    <p class="text-xs font-semibold uppercase text-[#a3482a]">{{ $product->category->name }}</p>
                    <div class="mt-1 flex items-center justify-between gap-4">
                        <h2 class="font-bold">{{ $product->name }}</h2>
                        <p class="font-bold">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="rounded-lg border border-black/10 bg-white p-5 hover:border-[#a3482a]">
                <p class="font-bold">{{ $category->name }}</p>
                <p class="mt-1 text-sm text-[#756f66]">{{ $category->products_count }} produtos</p>
            </a>
        @endforeach
    </div>
</section>

<section class="mx-auto mt-14 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[.16em] text-[#a3482a]">Catalogo</p>
            <h2 class="mt-2 text-3xl font-bold">Chegou agora</h2>
        </div>
        <a href="{{ route('products.index') }}" class="text-sm font-semibold text-[#a3482a]">Ver todos</a>
    </div>
    <div class="mt-6 grid grid-cols-2 gap-3 sm:gap-5 lg:grid-cols-3">
        @foreach ($newProducts as $product)
            @include('store.products.partials.card', ['product' => $product])
        @endforeach
    </div>
</section>
@endsection
