<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar na gestao - Freitas Imports</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f5f2] text-[#1f2421] antialiased">
    <main class="mx-auto grid min-h-screen max-w-6xl items-center gap-8 px-4 py-8 sm:px-6 lg:grid-cols-[1fr_440px] lg:px-8">
        <section class="hidden min-h-[620px] rounded-lg bg-[#1f2421] p-10 text-white lg:flex lg:flex-col lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[.16em] text-[#e3b77b]">Area interna</p>
                <h1 class="mt-5 max-w-xl text-5xl font-bold leading-tight">Controle pedidos, produtos e estoque com menos atrito.</h1>
                <p class="mt-5 max-w-lg text-white/65">A gestao fica separada da loja para evitar alteracoes acidentais e manter a rotina de atendimento mais organizada.</p>
            </div>
            <a href="{{ route('home') }}" class="text-sm font-semibold text-white/70 hover:text-white">Voltar para a loja</a>
        </section>

        <section class="rounded-lg bg-white p-6 shadow-sm ring-1 ring-black/10 sm:p-8">
            <div class="mb-8">
                <img src="{{ asset('images/freitas-imports-logo.png') }}" alt="Freitas Imports" class="h-16 w-16 rounded-full object-cover ring-1 ring-black/10">
                <h2 class="mt-5 text-3xl font-bold">Entrar na gestao</h2>
                <p class="mt-2 text-sm text-black/55">Use o email e senha do administrador.</p>
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf
                <label class="block text-sm font-semibold">
                    Email
                    <input name="email" type="email" value="{{ old('email') }}" autofocus class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal outline-none focus:border-[#7b5e2e]">
                    @error('email')<span class="mt-1 block text-xs text-red-700">{{ $message }}</span>@enderror
                </label>
                <label class="block text-sm font-semibold">
                    Senha
                    <input name="password" type="password" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal outline-none focus:border-[#7b5e2e]">
                    @error('password')<span class="mt-1 block text-xs text-red-700">{{ $message }}</span>@enderror
                </label>
                <label class="flex items-center gap-2 text-sm text-black/65">
                    <input type="checkbox" name="remember" value="1" class="rounded border-black/20">
                    Manter conectado
                </label>
                <button class="w-full rounded-lg bg-[#1f2421] px-5 py-3 text-sm font-bold text-white">Entrar</button>
            </form>

            <div class="mt-6 rounded-lg bg-[#f4f5f2] p-4 text-sm text-black/65">
                <p class="font-semibold text-black">Acesso inicial</p>
                <p class="mt-1">Email: admin@freitasimports.test<br>Senha: password</p>
            </div>
        </section>
    </main>
</body>
</html>
