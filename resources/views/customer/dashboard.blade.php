@extends('layouts.store', ['title' => 'Meus pedidos - Freitas Imports'])

@section('content')
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 border-b border-black/10 pb-6 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[.16em] text-[#d40000]">Area do cliente</p>
            <h1 class="mt-2 text-4xl font-bold">Meus pedidos</h1>
        </div>
        <form action="{{ route('logout') }}" method="POST">@csrf<button class="rounded-lg border border-black/15 px-4 py-3 text-sm font-bold">Sair</button></form>
    </div>

    <div class="mt-6 grid gap-4">
        @forelse ($orders as $order)
            <article class="rounded-lg bg-white p-5 ring-1 ring-black/10">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <p class="font-bold">{{ $order->code }}</p>
                        <p class="mt-1 text-sm text-[#756f66]">{{ $order->items->sum('quantity') }} item(ns) | {{ ucfirst($order->status) }} | Pagamento {{ $order->payment_status }}</p>
                    </div>
                    <p class="text-lg font-bold">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                </div>
                <div class="mt-4 border-t border-black/10 pt-4 text-sm text-[#756f66]">
                    @foreach ($order->items as $item)
                        <p>{{ $item->quantity }}x {{ $item->product_name }} @if($item->variant_label) - {{ $item->variant_label }} @endif</p>
                    @endforeach
                </div>
            </article>
        @empty
            <div class="rounded-lg bg-white p-8 ring-1 ring-black/10">
                <p class="font-bold">Voce ainda nao tem pedidos vinculados a esta conta.</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block rounded-lg bg-[#06166f] px-5 py-3 text-sm font-bold text-white">Ver produtos</a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
</section>
@endsection
