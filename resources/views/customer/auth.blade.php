@extends('layouts.store', ['title' => 'Area do cliente - Freitas Imports'])

@section('content')
<section class="mx-auto grid max-w-6xl gap-6 px-4 py-10 sm:px-6 lg:grid-cols-2 lg:px-8">
    <div class="rounded-lg bg-white p-6 ring-1 ring-black/10 sm:p-8">
        <h1 class="text-3xl font-bold">Entrar</h1>
        <p class="mt-2 text-sm text-[#756f66]">Acompanhe seus pedidos e facilite novas compras.</p>
        <form action="{{ route('customer.login.store') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <label class="block text-sm font-semibold">Email<input name="email" type="email" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Senha<input name="password" type="password" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            @error('email')<p class="text-sm text-red-700">{{ $message }}</p>@enderror
            <button class="w-full rounded-lg bg-[#06166f] px-5 py-3 text-sm font-bold text-white">Entrar</button>
        </form>
    </div>

    <div class="rounded-lg bg-white p-6 ring-1 ring-black/10 sm:p-8">
        <h2 class="text-3xl font-bold">Criar conta</h2>
        <p class="mt-2 text-sm text-[#756f66]">Cadastro rapido para salvar historico de compras.</p>
        <form action="{{ route('customer.register') }}" method="POST" class="mt-6 space-y-4">
            @csrf
            <label class="block text-sm font-semibold">Nome<input name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Email<input name="email" type="email" value="{{ old('email') }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            <label class="block text-sm font-semibold">Senha<input name="password" type="password" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
            @if ($errors->any())<p class="text-sm text-red-700">Confira os dados informados.</p>@endif
            <button class="w-full rounded-lg bg-[#d40000] px-5 py-3 text-sm font-bold text-white">Cadastrar</button>
        </form>
    </div>
</section>
@endsection
