@extends('layouts.store', ['title' => 'Pedido criado - Freitas Imports'])

@section('content')
<section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="rounded-lg bg-white p-8 text-center ring-1 ring-black/10">
        <p class="text-sm font-semibold uppercase tracking-[.16em] text-[#a3482a]">Pedido recebido</p>
        <h1 class="mt-3 text-4xl font-bold">{{ $order->code }}</h1>
        <p class="mt-4 text-[#756f66]">O pedido foi salvo no painel de gestao. Agora a equipe pode separar os produtos e atualizar o status.</p>
        <div class="mt-6 rounded-lg bg-[#f7f4ef] p-4 text-left">
            <p class="font-bold">Total: R$ {{ number_format($order->total, 2, ',', '.') }}</p>
            <p class="mt-1 text-sm text-[#756f66]">{{ $order->items->sum('quantity') }} item(ns) para {{ $order->customer_name }}</p>
        </div>
        @if ($order->payment_method === 'pix')
            <div class="mt-4 rounded-lg border border-[#d40000]/20 bg-[#fff7f7] p-4 text-left text-sm">
                <p class="font-bold text-[#06166f]">Pagamento por Pix</p>
                <p class="mt-1 text-[#756f66]">Chave Pix: <strong class="text-[#211f1c]">{{ env('STORE_PIX_KEY', 'freitasimports@example.com') }}</strong></p>
                <p class="mt-1 text-[#756f66]">Envie o comprovante pelo WhatsApp para agilizar a separacao.</p>
            </div>
        @endif
        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-center">
            <a href="{{ route('products.index') }}" class="rounded-lg border border-black/15 px-5 py-3 text-sm font-bold">Continuar comprando</a>
            @php
                $message = rawurlencode("Ola! Fiz o pedido {$order->code} na Freitas Imports. Total: R$ " . number_format($order->total, 2, ',', '.'));
            @endphp
            <a href="https://wa.me/{{ preg_replace('/\D/', '', env('STORE_WHATSAPP', '5511999999999')) }}?text={{ $message }}" target="_blank" class="rounded-lg border border-[#a3482a] px-5 py-3 text-sm font-bold text-[#a3482a]">Chamar no WhatsApp</a>
            <a href="{{ route('admin.orders.show', $order) }}" class="rounded-lg bg-[#211f1c] px-5 py-3 text-sm font-bold text-white">Ver na gestao</a>
        </div>
    </div>
</section>
@endsection
