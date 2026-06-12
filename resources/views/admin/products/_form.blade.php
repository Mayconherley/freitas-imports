@csrf
<div class="grid gap-4 rounded-lg bg-white p-5 ring-1 ring-black/10 md:grid-cols-2">
    <label class="text-sm font-semibold">Nome<input name="name" value="{{ old('name', $product->name) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Categoria<select name="category_id" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal">@foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
    <label class="text-sm font-semibold">SKU<input name="sku" value="{{ old('sku', $product->sku) }}" placeholder="COD-001" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Codigo de barras<input name="barcode" value="{{ old('barcode', $product->barcode) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Preco<input name="price" type="number" step="0.01" value="{{ old('price', $product->price) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Preco antigo<input name="compare_at_price" type="number" step="0.01" value="{{ old('compare_at_price', $product->compare_at_price) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Preco de custo<input name="cost_price" type="number" step="0.01" value="{{ old('cost_price', $product->cost_price) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Estoque<input name="stock" type="number" value="{{ old('stock', $product->stock ?? 0) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Tamanho<input name="size" value="{{ old('size', $product->size) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Cor<input name="color" value="{{ old('color', $product->color) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Imagem URL<input name="image_url" value="{{ old('image_url', $product->image_url) }}" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold">Upload de imagem<input name="image" type="file" accept="image/*" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal"></label>
    <label class="text-sm font-semibold md:col-span-2">Descricao<textarea name="description" rows="5" class="mt-2 w-full rounded-lg border border-black/15 px-4 py-3 font-normal">{{ old('description', $product->description) }}</textarea></label>

    <section class="md:col-span-2">
        <div class="mb-3 flex items-center justify-between gap-4">
            <div>
                <h2 class="font-bold">Variacoes</h2>
                <p class="text-sm text-black/55">Use para tamanhos, cores ou perfumes com volumes diferentes.</p>
            </div>
        </div>
        <div class="grid gap-3">
            @php
                $oldVariants = old('variants');
                $variants = collect($oldVariants ?? $product->variants ?? [])->values();
                while ($variants->count() < 3) {
                    $variants->push([]);
                }
            @endphp
            @foreach ($variants->take(3) as $index => $variant)
                @php
                    $variant = is_array($variant) ? $variant : $variant->toArray();
                @endphp
                <div class="grid gap-3 rounded-lg bg-[#f4f5f2] p-3 md:grid-cols-6">
                    <input name="variants[{{ $index }}][name]" value="{{ $variant['name'] ?? '' }}" placeholder="Nome" class="rounded-lg border border-black/15 bg-white px-3 py-2 text-sm md:col-span-2">
                    <input name="variants[{{ $index }}][sku]" value="{{ $variant['sku'] ?? '' }}" placeholder="SKU" class="rounded-lg border border-black/15 bg-white px-3 py-2 text-sm">
                    <input name="variants[{{ $index }}][size]" value="{{ $variant['size'] ?? '' }}" placeholder="Tamanho" class="rounded-lg border border-black/15 bg-white px-3 py-2 text-sm">
                    <input name="variants[{{ $index }}][color]" value="{{ $variant['color'] ?? '' }}" placeholder="Cor" class="rounded-lg border border-black/15 bg-white px-3 py-2 text-sm">
                    <input name="variants[{{ $index }}][stock]" type="number" min="0" value="{{ $variant['stock'] ?? '' }}" placeholder="Estoque" class="rounded-lg border border-black/15 bg-white px-3 py-2 text-sm">
                    <input name="variants[{{ $index }}][price_adjustment]" type="number" step="0.01" value="{{ $variant['price_adjustment'] ?? '' }}" placeholder="+ preco" class="rounded-lg border border-black/15 bg-white px-3 py-2 text-sm md:col-span-2">
                </div>
            @endforeach
        </div>
    </section>

    <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))> Destaque na vitrine</label>
    <label class="flex items-center gap-2 text-sm font-semibold"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Ativo na loja</label>
    @if ($errors->any())<div class="rounded-lg bg-red-50 p-4 text-sm text-red-700 md:col-span-2">Confira os dados do produto.</div>@endif
</div>
<div class="mt-5 flex gap-3">
    <button class="rounded-lg bg-[#1f2421] px-5 py-3 text-sm font-bold text-white">Salvar</button>
    <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-black/15 px-5 py-3 text-sm font-bold">Cancelar</a>
</div>
