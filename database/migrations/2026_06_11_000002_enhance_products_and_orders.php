<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->unique()->after('slug');
            $table->decimal('cost_price', 10, 2)->nullable()->after('compare_at_price');
            $table->string('barcode')->nullable()->after('cost_price');
            $table->string('image_path')->nullable()->after('image_url');
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->decimal('price_adjustment', 10, 2)->default(0);
            $table->unsignedInteger('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('shipping_zip')->nullable()->after('shipping_address');
            $table->string('shipping_city')->nullable()->after('shipping_zip');
            $table->string('shipping_state')->nullable()->after('shipping_city');
            $table->string('payment_status')->default('aguardando')->after('status');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->nullable()->after('product_id')->constrained()->nullOnDelete();
            $table->string('variant_label')->nullable()->after('product_name');
            $table->string('sku')->nullable()->after('variant_label');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_variant_id');
            $table->dropColumn(['variant_label', 'sku']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_zip', 'shipping_city', 'shipping_state', 'payment_status']);
        });

        Schema::dropIfExists('product_variants');

        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['sku']);
            $table->dropColumn(['sku', 'cost_price', 'barcode', 'image_path']);
        });
    }
};
