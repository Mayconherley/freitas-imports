@extends('layouts.admin', ['title' => 'Produtos - Freitas Imports'])

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div><h1 class="text-3xl font-bold">Produtos</h1><p class="mt-1 text-sm text-black/55">Cadastro, estoque e exibicao na loja.</p></div>
    <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-[#1f2421] px-4 py-3 text-center text-sm font-bold text-white">Novo produto</a>
</div>
<form class="mt-5 flex gap-3">
    <input name="search" value="{{ $search }}" placeholder="Buscar produto" class="w-full rounded-lg border border-black/15 bg-white px-4 py-3 text-sm">
    <button class="rounded-lg border border-black/15 bg-white px-4 py-3 text-sm font-bold">Buscar</button>
</form>
<section class="mt-5 overflow-hidden rounded-lg bg-white ring-1 ring-black/10">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[920px] text-left text-sm">
            <thead class="border-b border-black/10 bg-black/[.03] text-black/55"><tr><th class="px-4 py-3">Produto</th><th>Categoria</th><th>Preco</th><th>Estoque</th><th>Margem</th><th>Status</th><th class="text-right">Acoes</th></tr></thead>
            <tbody class="divide-y divide-black/10">
                @foreach ($products as $product)
                    <tr>
                        <td class="px-4 py-3"><div class="flex items-center gap-3"><img src="{{ $product->image_src }}" alt="" class="h-12 w-12 rounded-lg object-cover"><span><span class="block font-semibold">{{ $product->name }}</span><span class="text-xs text-black/45">{{ $product->sku ?: 'Sem SKU' }}</span></span></div></td>
                        <td>{{ $product->category->name }}</td>
                        <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->profit_margin ? $product->profit_margin.'%' : '-' }}</td>
                        <td>{{ $product->is_active ? 'Ativo' : 'Oculto' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" class="font-semibold text-[#7b5e2e]">Editar</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="ml-3 inline">@csrf @method('DELETE')<button class="font-semibold text-red-700">Excluir</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
<div class="mt-5">{{ $products->links() }}</div>
@endsection
