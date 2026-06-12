@extends('layouts.store', ['title' => 'Carrinho - Freitas Imports'])

@section('content')
<section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold">Carrinho</h1>
    <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_360px]">
        <div class="space-y-4">
            @forelse ($items as $item)
                <div class="grid gap-4 rounded-lg bg-white p-4 ring-1 ring-black/10 sm:grid-cols-[120px_1fr_auto]">
                    <img src="{{ $item['product']->image_src }}" alt="{{ $item['product']->name }}" class="h-32 w-full rounded-lg object-cover sm:w-32">
                    <div>
                        <p class="font-bold">{{ $item['product']->name }}</p>
                        @if ($item['variant'])
                            <p class="mt-1 text-sm text-[#756f66]">{{ $item['variant']->label() }} {{ $item['variant']->sku ? '| '.$item['variant']->sku : '' }}</p>
                        @endif
                        <p class="mt-1 text-sm text-[#756f66]">R$ {{ number_format($item['unit_price'], 2, ',', '.') }} | estoque {{ $item['available_stock'] }}</p>
                        <form action="{{ route('cart.update', ['itemKey' => $item['key']]) }}" method="POST" class="mt-4 flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="quantity" min="0" value="{{ $item['quantity'] }}" class="w-20 rounded-lg border border-black/15 px-3 py-2">
                            <button class="rounded-lg border border-black/15 px-3 py-2 text-sm font-semibold">Atualizar</button>
                        </form>
                    </div>
                    <div class="flex items-start justify-between gap-4 sm:block sm:text-right">
                        <p class="font-bold">R$ {{ number_format($item['total'], 2, ',', '.') }}</p>
                        <form action="{{ route('cart.destroy', ['itemKey' => $item['key']]) }}" method="POST" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm font-semibold text-[#a3482a]">Remover</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="rounded-lg bg-white p-8 ring-1 ring-black/10">
                    <p class="font-bold">Seu carrinho esta vazio.</p>
                    <a href="{{ route('products.index') }}" class="mt-4 inline-block rounded-lg bg-[#211f1c] px-5 py-3 text-sm font-bold text-white">Ver catalogo</a>
                </div>
            @endforelse
        </div>
        <aside class="h-fit rounded-lg bg-white p-5 ring-1 ring-black/10">
            <h2 class="text-xl font-bold">Resumo</h2>
            <div class="mt-5 space-y-3 text-sm">
                <div class="flex justify-between"><span>Subtotal</span><span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span></div>
                <div class="flex justify-between"><span>Entrega estimada</span><span>R$ {{ number_format($shipping, 2, ',', '.') }}</span></div>
                <div class="flex justify-between border-t border-black/10 pt-3 text-lg font-bold"><span>Total</span><span>R$ {{ number_format($total, 2, ',', '.') }}</span></div>
            </div>
            <a href="{{ route('checkout.create') }}" class="mt-6 block rounded-lg bg-[#a3482a] px-5 py-3 text-center text-sm font-bold text-white">Finalizar pedido</a>
        </aside>
    </div>
</section>
@endsection
