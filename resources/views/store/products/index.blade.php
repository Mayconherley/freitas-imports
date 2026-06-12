@extends('layouts.store', ['title' => 'Catalogo - Freitas Imports'])

@section('content')
<section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-5 border-b border-black/10 pb-6 md:flex-row md:items-end md:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[.16em] text-[#a3482a]">Catalogo</p>
            <h1 class="mt-2 text-4xl font-bold">Produtos da loja</h1>
        </div>
        <form class="grid gap-3 sm:grid-cols-[1fr_180px_auto]">
            <input name="search" value="{{ $search }}" placeholder="Buscar produto" class="rounded-lg border border-black/15 bg-white px-4 py-3 text-sm outline-none focus:border-[#a3482a]">
            <select name="category" class="rounded-lg border border-black/15 bg-white px-4 py-3 text-sm outline-none focus:border-[#a3482a]">
                <option value="">Todas categorias</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" @selected($currentCategory === $category->slug)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="rounded-lg bg-[#211f1c] px-5 py-3 text-sm font-bold text-white">Filtrar</button>
        </form>
    </div>

    <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($products as $product)
            @include('store.products.partials.card', ['product' => $product])
        @empty
            <div class="rounded-lg bg-white p-8 text-[#756f66] ring-1 ring-black/10">Nenhum produto encontrado.</div>
        @endforelse
    </div>

    <div class="mt-8">{{ $products->links() }}</div>
</section>
@endsection
