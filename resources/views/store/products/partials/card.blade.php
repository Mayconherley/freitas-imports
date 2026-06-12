<a href="{{ route('products.show', ['product' => $product->slug]) }}" class="group overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-black/10">
    <div class="aspect-square max-h-[260px] overflow-hidden bg-[#e8e1d8] sm:max-h-[300px]">
        <img src="{{ $product->image_src }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
    </div>
    <div class="p-3 sm:p-5">
        <p class="text-xs font-semibold uppercase text-[#a3482a]">{{ $product->category->name }}</p>
        <h3 class="mt-1 text-sm font-bold sm:text-base">{{ $product->name }}</h3>
        <p class="mt-2 text-xs text-[#756f66] sm:text-sm">{{ $product->size }} {{ $product->color ? ' | '.$product->color : '' }}</p>
        <div class="mt-3 flex flex-col gap-1 sm:mt-4 sm:flex-row sm:items-end sm:justify-between">
            <p class="text-base font-bold sm:text-lg">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
            @if ($product->compare_at_price)
                <p class="text-xs text-[#756f66] line-through sm:text-sm">R$ {{ number_format($product->compare_at_price, 2, ',', '.') }}</p>
            @endif
        </div>
    </div>
</a>
