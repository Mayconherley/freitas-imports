@extends('layouts.admin', ['title' => $order->code . ' - Freitas Imports'])

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div>
        <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-[#7b5e2e]">Voltar para pedidos</a>
        <h1 class="mt-2 text-3xl font-bold">{{ $order->code }}</h1>
        <p class="mt-1 text-sm text-black/55">{{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="flex gap-3">
        @csrf
        @method('PATCH')
        <select name="status" class="rounded-lg border border-black/15 bg-white px-4 py-3 text-sm">
            @foreach (['novo', 'separacao', 'enviado', 'concluido', 'cancelado'] as $status)
                <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
        <select name="payment_status" class="rounded-lg border border-black/15 bg-white px-4 py-3 text-sm">
            @foreach (['aguardando', 'pago', 'estornado'] as $paymentStatus)
                <option value="{{ $paymentStatus }}" @selected($order->payment_status === $paymentStatus)>{{ ucfirst($paymentStatus) }}</option>
            @endforeach
        </select>
        <button class="rounded-lg bg-[#1f2421] px-4 py-3 text-sm font-bold text-white">Atualizar</button>
    </form>
</div>
<div class="mt-6 grid gap-6 xl:grid-cols-[1fr_360px]">
    <section class="rounded-lg bg-white p-5 ring-1 ring-black/10">
        <h2 class="text-xl font-bold">Itens</h2>
        <div class="mt-4 divide-y divide-black/10">
            @foreach ($order->items as $item)
                <div class="grid gap-3 py-4 sm:grid-cols-[1fr_auto_auto]">
                    <div>
                        <p class="font-semibold">{{ $item->product_name }}</p>
                        <p class="text-sm text-black/55">
                            @if ($item->variant_label){{ $item->variant_label }} | @endif
                            {{ $item->sku ?: 'Sem SKU' }} | R$ {{ number_format($item->unit_price, 2, ',', '.') }} cada
                        </p>
                    </div>
                    <p>{{ $item->quantity }} un.</p>
                    <p class="font-bold">R$ {{ number_format($item->total, 2, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-5 space-y-2 border-t border-black/10 pt-4 text-sm">
            <div class="flex justify-between"><span>Subtotal</span><span>R$ {{ number_format($order->subtotal, 2, ',', '.') }}</span></div>
            <div class="flex justify-between"><span>Entrega</span><span>R$ {{ number_format($order->shipping_total, 2, ',', '.') }}</span></div>
            <div class="flex justify-between text-lg font-bold"><span>Total</span><span>R$ {{ number_format($order->total, 2, ',', '.') }}</span></div>
        </div>
    </section>
    <aside class="space-y-5">
        <section class="rounded-lg bg-white p-5 ring-1 ring-black/10">
            <h2 class="text-xl font-bold">Cliente</h2>
            <div class="mt-4 space-y-2 text-sm text-black/70">
                <p><strong class="text-black">Nome:</strong> {{ $order->customer_name }}</p>
                <p><strong class="text-black">Email:</strong> {{ $order->customer_email }}</p>
                <p><strong class="text-black">Telefone:</strong> {{ $order->customer_phone }}</p>
            </div>
        </section>
        <section class="rounded-lg bg-white p-5 ring-1 ring-black/10">
            <h2 class="text-xl font-bold">Entrega</h2>
            <div class="mt-4 space-y-2 text-sm text-black/70">
                <p><strong class="text-black">Metodo:</strong> {{ ucfirst($order->shipping_method) }}</p>
                @if ($order->shipping_zip)<p><strong class="text-black">CEP:</strong> {{ $order->shipping_zip }}</p>@endif
                <p>{{ $order->shipping_address ?: 'Retirada na loja' }}</p>
                @if ($order->notes)<p><strong class="text-black">Obs:</strong> {{ $order->notes }}</p>@endif
            </div>
        </section>
        <section class="rounded-lg bg-white p-5 ring-1 ring-black/10">
            <h2 class="text-xl font-bold">Historico</h2>
            <div class="mt-4 space-y-3">
                @forelse ($order->histories->sortByDesc('created_at') as $history)
                    <div class="rounded-lg bg-[#f4f5f2] p-3 text-sm">
                        <p class="font-semibold">{{ ucfirst($history->status) }} @if($history->payment_status) | Pagamento {{ $history->payment_status }} @endif</p>
                        <p class="mt-1 text-black/55">{{ $history->notes }} {{ $history->user ? 'por '.$history->user->name : '' }}</p>
                        <p class="mt-1 text-xs text-black/45">{{ $history->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                @empty
                    <p class="text-sm text-black/55">Nenhum historico registrado.</p>
                @endforelse
            </div>
        </section>
    </aside>
</div>
@endsection
