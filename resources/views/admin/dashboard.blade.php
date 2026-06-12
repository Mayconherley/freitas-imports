@extends('layouts.admin', ['title' => 'Dashboard - Freitas Imports'])

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <p class="text-sm font-semibold uppercase tracking-[.16em] text-[#7b5e2e]">Gestao</p>
        <h1 class="mt-2 text-3xl font-bold">Dashboard</h1>
    </div>
    <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-[#1f2421] px-4 py-3 text-center text-sm font-bold text-white">Novo produto</a>
</div>

<div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="rounded-lg bg-white p-5 ring-1 ring-black/10"><p class="text-sm text-black/55">Faturamento</p><p class="mt-2 text-2xl font-bold">R$ {{ number_format($revenue, 2, ',', '.') }}</p></div>
    <div class="rounded-lg bg-white p-5 ring-1 ring-black/10"><p class="text-sm text-black/55">Pedidos</p><p class="mt-2 text-2xl font-bold">{{ $ordersCount }}</p></div>
    <div class="rounded-lg bg-white p-5 ring-1 ring-black/10"><p class="text-sm text-black/55">Produtos</p><p class="mt-2 text-2xl font-bold">{{ $productsCount }}</p></div>
    <div class="rounded-lg bg-white p-5 ring-1 ring-black/10"><p class="text-sm text-black/55">Estoque baixo</p><p class="mt-2 text-2xl font-bold">{{ $lowStockCount }}</p></div>
</div>

<div class="mt-6 grid gap-6 xl:grid-cols-[1fr_380px]">
    <section class="rounded-lg bg-white p-5 ring-1 ring-black/10">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold">Pedidos recentes</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-[#7b5e2e]">Ver todos</a>
        </div>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-black/10 text-black/55"><tr><th class="py-3">Codigo</th><th>Cliente</th><th>Status</th><th>Total</th><th></th></tr></thead>
                <tbody class="divide-y divide-black/10">
                    @foreach ($recentOrders as $order)
                        <tr><td class="py-3 font-semibold">{{ $order->code }}</td><td>{{ $order->customer_name }}</td><td>{{ ucfirst($order->status) }}</td><td>R$ {{ number_format($order->total, 2, ',', '.') }}</td><td><a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-[#7b5e2e]">Abrir</a></td></tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <section class="rounded-lg bg-white p-5 ring-1 ring-black/10">
        <h2 class="text-xl font-bold">Atencao no estoque</h2>
        <div class="mt-4 space-y-3">
            @forelse ($lowStockProducts as $product)
                <div class="flex items-center justify-between rounded-lg bg-[#f4f5f2] p-3">
                    <div><p class="font-semibold">{{ $product->name }}</p><p class="text-sm text-black/55">{{ $product->category->name }}</p></div>
                    <span class="rounded-lg bg-white px-3 py-1 text-sm font-bold">{{ $product->stock }}</span>
                </div>
            @empty
                <p class="text-sm text-black/55">Nenhum item com estoque baixo.</p>
            @endforelse
        </div>
    </section>
</div>
@endsection
