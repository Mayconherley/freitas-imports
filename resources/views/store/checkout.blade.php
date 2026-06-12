@extends('layouts.store', ['title' => 'Checkout - Freitas Imports'])

@section('content')
<section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold">Finalizar pedido</h1>
    <form action="{{ route('checkout.store') }}" method="POST" class="mt-8 grid gap-6 lg:grid-cols-[1fr_360px]">
        @csrf
        <div class="grid gap-4 rounded-lg bg-white p-5 ring-1 ring-black/10 sm:grid-cols-2">
            <label class="block text-sm font-semibold">Nome<input name="customer_name" value="{{ old('customer_name') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Email<input name="customer_email" type="email" value="{{ old('customer_email') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Telefone<input name="customer_phone" value="{{ old('customer_phone') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Forma de pagamento<select name="payment_method" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"><option value="pix">Pix</option><option value="cartao">Cartao</option><option value="dinheiro">Dinheiro</option></select></label>
            <label class="block text-sm font-semibold">Entrega<select name="shipping_method" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"><option value="retirada">Retirada na loja</option><option value="entrega">Entrega local</option></select></label>
            <label class="block text-sm font-semibold">CEP<input name="shipping_zip" value="{{ old('shipping_zip') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Rua<input name="shipping_street" value="{{ old('shipping_street') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Numero<input name="shipping_number" value="{{ old('shipping_number') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Complemento<input name="shipping_complement" value="{{ old('shipping_complement') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Bairro<input name="shipping_neighborhood" value="{{ old('shipping_neighborhood') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Cidade<input name="shipping_city" value="{{ old('shipping_city') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">UF<input name="shipping_state" maxlength="2" value="{{ old('shipping_state') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold sm:col-span-2">Observacoes<textarea name="notes" rows="3" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal">{{ old('notes') }}</textarea></label>
            @if ($errors->any())
                <div class="rounded-lg bg-red-50 p-4 text-sm text-red-700 sm:col-span-2">Confira os campos obrigatorios antes de continuar.</div>
            @endif
        </div>
        <aside class="h-fit rounded-lg bg-white p-5 ring-1 ring-black/10">
            <h2 class="text-xl font-bold">Seu pedido</h2>
            <div class="mt-4 space-y-3">
                @foreach ($items as $item)
                    <div class="flex justify-between gap-4 text-sm">
                        <span>{{ $item['quantity'] }}x {{ $item['product']->name }} @if($item['variant']) <small class="block text-black/50">{{ $item['variant']->label() }}</small> @endif</span>
                        <span>R$ {{ number_format($item['total'], 2, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 space-y-3 border-t border-black/10 pt-4 text-sm">
                <div class="flex justify-between"><span>Subtotal</span><span>R$ {{ number_format($subtotal, 2, ',', '.') }}</span></div>
                <div class="flex justify-between"><span>Entrega</span><span>R$ {{ number_format($shipping, 2, ',', '.') }}</span></div>
                <div class="flex justify-between text-lg font-bold"><span>Total</span><span>R$ {{ number_format($total, 2, ',', '.') }}</span></div>
            </div>
            <button class="mt-6 w-full rounded-lg bg-[#a3482a] px-5 py-3 text-sm font-bold text-white">Criar pedido</button>
        </aside>
    </form>
</section>
@endsection
