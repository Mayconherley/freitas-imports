<a href="{{ route('products.show', ['product' => $product->slug]) }}" class="group overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-black/10">
    <div class="aspect-[4/5] overflow-hidden bg-[#e8e1d8]">
        <img src="{{ $product->image_src }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
    </div>
    <div class="p-5">
        <p class="text-xs font-semibold uppercase text-[#a3482a]">{{ $product->category->name }}</p>
        <h3 class="mt-1 font-bold">{{ $product->name }}</h3>
        <p class="mt-2 text-sm text-[#756f66]">{{ $product->size }} {{ $product->color ? ' | '.$product->color : '' }}</p>
        <div class="mt-4 flex items-end justify-between">
            <p class="text-lg font-bold">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            @if ($product->compare_at_price)
                <p class="text-sm text-[#756f66] line-through">R$ {{ number_format($product->compare_at_price, 2, ',', '.') }}</p>
            @endif
        </div>
    </div>
</a>
