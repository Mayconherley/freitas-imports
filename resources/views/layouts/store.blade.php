<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Freitas Imports' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f7f4ef] text-[#211f1c] antialiased">
    <header class="sticky top-0 z-30 border-b border-black/10 bg-[#f7f4ef]/95 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/freitas-imports-logo.png') }}" alt="Freitas Imports" class="h-12 w-12 rounded-full object-cover ring-1 ring-black/10">
                <span>
                    <span class="block text-base font-bold">Freitas Imports</span>
                    <span class="block text-xs text-[#756f66]">moda, perfumes e presentes</span>
                </span>
            </a>
            <nav class="hidden items-center gap-6 text-sm font-medium md:flex">
                <a href="{{ route('products.index') }}" class="hover:text-[#d40000]">Catalogo</a>
                <a href="{{ route('cart.index') }}" class="hover:text-[#d40000]">Carrinho ({{ collect(session('cart', []))->sum() }})</a>
                <a href="{{ auth()->check() ? route('customer.dashboard') : route('customer.login') }}" class="hover:text-[#d40000]">Minha conta</a>
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-black/15 px-4 py-2 hover:border-[#d40000] hover:text-[#d40000]">Gestao</a>
            </nav>
            <a href="{{ route('cart.index') }}" class="rounded-lg bg-[#d40000] px-4 py-2 text-sm font-semibold text-white md:hidden">Carrinho</a>
        </div>
    </header>

    @if (session('success'))
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="mt-16 border-t border-black/10 bg-[#211f1c] text-white">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 py-10 text-sm sm:px-6 md:grid-cols-3 lg:px-8">
            <div>
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/freitas-imports-logo.png') }}" alt="Freitas Imports" class="h-12 w-12 rounded-full object-cover">
                    <p class="text-lg font-bold">Freitas Imports</p>
                </div>
                <p class="mt-2 text-white/65">Uma base pronta para vender online e controlar pedidos, estoque e atendimento.</p>
            </div>
            <div>
                <p class="font-semibold">Atendimento</p>
                <p class="mt-2 text-white/65">WhatsApp, retirada local e entrega combinada no checkout.</p>
            </div>
            <div>
                <p class="font-semibold">Gestao</p>
                <a href="{{ route('admin.dashboard') }}" class="mt-2 inline-block text-white/65 hover:text-white">Abrir painel administrativo</a>
            </div>
        </div>
    </footer>
</body>
</html>
