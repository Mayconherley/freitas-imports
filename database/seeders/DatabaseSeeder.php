<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Gestor da Loja',
            'email' => 'admin@freitasimports.test',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $customer = User::create([
            'name' => 'Cliente Exemplo',
            'email' => 'cliente@freitasimports.test',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '(11) 97777-0000',
        ]);

        $categories = collect([
            ['name' => 'Roupas', 'slug' => 'roupas', 'description' => 'Vestuario selecionado para o dia a dia e ocasioes especiais.'],
            ['name' => 'Perfumes', 'slug' => 'perfumes', 'description' => 'Fragrancias importadas e inspiradas para presentes marcantes.'],
            ['name' => 'Acessorios', 'slug' => 'acessorios', 'description' => 'Bolsas, carteiras, relogios e detalhes que completam o visual.'],
            ['name' => 'Beleza', 'slug' => 'beleza', 'description' => 'Cuidados pessoais e kits para rotina de beleza.'],
        ])->mapWithKeys(fn (array $category) => [
            $category['slug'] => Category::create($category),
        ]);

        $products = [
            [
                'category_id' => $categories['roupas']->id,
                'name' => 'Jaqueta Urban Fit',
                'slug' => 'jaqueta-urban-fit',
                'sku' => 'ROUP-JAQ-URB',
                'description' => 'Jaqueta leve com caimento moderno, bolsos funcionais e acabamento premium.',
                'price' => 289.90,
                'compare_at_price' => 349.90,
                'cost_price' => 165.00,
                'stock' => 18,
                'size' => 'P ao GG',
                'color' => 'Preto',
                'image_url' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?auto=format&fit=crop&w=900&q=80',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['roupas']->id,
                'name' => 'Vestido Serena',
                'slug' => 'vestido-serena',
                'sku' => 'ROUP-VES-SER',
                'description' => 'Vestido midi elegante, tecido fluido e modelagem confortavel para eventos e trabalho.',
                'price' => 219.90,
                'compare_at_price' => 259.90,
                'cost_price' => 118.00,
                'stock' => 12,
                'size' => 'P ao G',
                'color' => 'Verde oliva',
                'image_url' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=900&q=80',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['perfumes']->id,
                'name' => 'Essence Noir 100ml',
                'slug' => 'essence-noir-100ml',
                'sku' => 'PERF-ESS-NOIR',
                'description' => 'Perfume intenso com notas amadeiradas, especiarias suaves e alta fixacao.',
                'price' => 189.90,
                'compare_at_price' => null,
                'cost_price' => 92.00,
                'stock' => 26,
                'size' => '100ml',
                'color' => null,
                'image_url' => 'https://images.unsplash.com/photo-1541643600914-78b084683601?auto=format&fit=crop&w=900&q=80',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['perfumes']->id,
                'name' => 'Aura Bloom 75ml',
                'slug' => 'aura-bloom-75ml',
                'sku' => 'PERF-AUR-BLOOM',
                'description' => 'Fragrancia floral fresca com toque frutado, pensada para uso diario.',
                'price' => 159.90,
                'compare_at_price' => 199.90,
                'cost_price' => 79.00,
                'stock' => 21,
                'size' => '75ml',
                'color' => null,
                'image_url' => 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539?auto=format&fit=crop&w=900&q=80',
                'is_featured' => false,
            ],
            [
                'category_id' => $categories['acessorios']->id,
                'name' => 'Bolsa Mini Classic',
                'slug' => 'bolsa-mini-classic',
                'sku' => 'ACES-BOL-MINI',
                'description' => 'Bolsa compacta estruturada com alca transversal e ferragens douradas.',
                'price' => 249.90,
                'compare_at_price' => 299.90,
                'cost_price' => 134.00,
                'stock' => 9,
                'size' => 'Unico',
                'color' => 'Caramelo',
                'image_url' => 'https://images.unsplash.com/photo-1594223274512-ad4803739b7c?auto=format&fit=crop&w=900&q=80',
                'is_featured' => true,
            ],
            [
                'category_id' => $categories['beleza']->id,
                'name' => 'Kit Glow Care',
                'slug' => 'kit-glow-care',
                'sku' => 'BEAU-KIT-GLOW',
                'description' => 'Kit com hidratante, body splash e necessaire para presente pronto.',
                'price' => 129.90,
                'compare_at_price' => null,
                'cost_price' => 58.00,
                'stock' => 15,
                'size' => '3 itens',
                'color' => null,
                'image_url' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=900&q=80',
                'is_featured' => false,
            ],
        ];

        collect($products)->each(fn (array $product) => Product::create($product));

        Product::where('slug', 'jaqueta-urban-fit')->first()?->variants()->createMany([
            ['name' => 'P preto', 'sku' => 'ROUP-JAQ-URB-P', 'size' => 'P', 'color' => 'Preto', 'stock' => 6],
            ['name' => 'M preto', 'sku' => 'ROUP-JAQ-URB-M', 'size' => 'M', 'color' => 'Preto', 'stock' => 7],
            ['name' => 'G preto', 'sku' => 'ROUP-JAQ-URB-G', 'size' => 'G', 'color' => 'Preto', 'stock' => 5],
        ]);

        Product::where('slug', 'essence-noir-100ml')->first()?->variants()->createMany([
            ['name' => '100ml', 'sku' => 'PERF-ESS-NOIR-100', 'size' => '100ml', 'stock' => 16],
            ['name' => '50ml', 'sku' => 'PERF-ESS-NOIR-050', 'size' => '50ml', 'price_adjustment' => -54.90, 'stock' => 10],
        ]);

        $order = Order::create([
            'user_id' => $customer->id,
            'code' => 'IMP-1001',
            'customer_name' => 'Marina Alves',
            'customer_email' => 'marina@example.com',
            'customer_phone' => '(11) 98888-1212',
            'status' => 'separacao',
            'payment_method' => 'pix',
            'shipping_method' => 'entrega',
            'shipping_address' => 'Rua das Flores, 120 - Centro',
            'subtotal' => 379.80,
            'shipping_total' => 18.00,
            'total' => 397.80,
            'notes' => 'Cliente pediu embalagem para presente.',
        ]);

        $order->items()->createMany([
            ['product_id' => Product::where('slug', 'essence-noir-100ml')->value('id'), 'product_name' => 'Essence Noir 100ml', 'unit_price' => 189.90, 'quantity' => 2, 'total' => 379.80],
        ]);

        $order->histories()->create([
            'user_id' => User::where('email', 'admin@freitasimports.test')->value('id'),
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'notes' => 'Pedido de exemplo importado no seed.',
        ]);
    }
}
