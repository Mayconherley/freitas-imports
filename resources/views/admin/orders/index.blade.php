@extends('layouts.admin', ['title' => 'Pedidos - Freitas Imports'])

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div><h1 class="text-3xl font-bold">Pedidos</h1><p class="mt-1 text-sm text-black/55">Acompanhe separacao, entrega e conclusao.</p></div>
    <form>
        <select name="status" onchange="this.form.submit()" class="rounded-lg border border-black/15 bg-white px-4 py-3 text-sm">
            <option value="">Todos</option>
            @foreach (['novo', 'separacao', 'enviado', 'concluido', 'cancelado'] as $option)
                <option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>
            @endforeach
        </select>
    </form>
</div>
<section class="mt-5 overflow-hidden rounded-lg bg-white ring-1 ring-black/10">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-sm">
            <thead class="border-b border-black/10 bg-black/[.03] text-black/55"><tr><th class="px-4 py-3">Pedido</th><th>Cliente</th><th>Status</th><th>Pagamento</th><th>Total</th><th></th></tr></thead>
            <tbody class="divide-y divide-black/10">
                @forelse ($orders as $order)
                    <tr>
                        <td class="px-4 py-3 font-semibold">{{ $order->code }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ ucfirst($order->payment_method) }} / {{ ucfirst($order->payment_status) }}</td>
                        <td>R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.orders.show', $order) }}" class="font-semibold text-[#7b5e2e]">Abrir</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-black/55">Nenhum pedido encontrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
<div class="mt-5">{{ $orders->links() }}</div>
@endsection
