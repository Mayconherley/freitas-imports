<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Gestao - Freitas Imports' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f4f5f2] text-[#1f2421] antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="border-b border-black/10 bg-[#1f2421] text-white lg:min-h-screen lg:border-b-0">
            <div class="flex items-center justify-between px-5 py-5 lg:block">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 text-lg font-bold">
                    <img src="{{ asset('images/freitas-imports-logo.png') }}" alt="Freitas Imports" class="h-10 w-10 rounded-full object-cover">
                    Freitas Imports
                </a>
                <div class="mt-1 flex items-center gap-3 lg:mt-2 lg:block">
                    <a href="{{ route('home') }}" class="text-sm text-white/65 hover:text-white">Ver loja</a>
                    <form action="{{ route('logout') }}" method="POST" class="lg:mt-2">
                        @csrf
                        <button class="text-sm text-white/65 hover:text-white">Sair</button>
                    </form>
                </div>
            </div>
            <nav class="flex gap-2 overflow-x-auto px-3 pb-4 text-sm lg:block lg:space-y-1 lg:px-3">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10">Produtos</a>
                <a href="{{ route('admin.orders.index') }}" class="block rounded-lg px-3 py-2 hover:bg-white/10">Pedidos</a>
            </nav>
        </aside>
        <main class="px-4 py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</body>
</html>
