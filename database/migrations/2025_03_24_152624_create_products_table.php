<?php

use App\Enums\ActiveStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('image')->nullable();
            $table->json('gallery')->nullable();
            $table->integer('price')->default(0);
            $table->integer('sale_price')->nullable();
            $table->string('slug')->unique();
            $table->text('desc')->nullable();
            $table->enum('status', ActiveStatus::getValues())->default(ActiveStatus::Active->value);
            $table->integer('stock')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
