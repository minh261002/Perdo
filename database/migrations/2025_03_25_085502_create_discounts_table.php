<?php

use App\Enums\ActiveStatus;
use App\Enums\Discount\DiscountApplyFor;
use App\Enums\Discount\DiscountType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->char('code', 50)->nullable();
            $table->dateTime('date_start');
            $table->dateTime('date_end');
            $table->integer('max_usage')->nullable();
            $table->double('min_order_amount')->nullable();
            $table->enum('type', DiscountType::getValues())->default(DiscountType::Percentage->value);
            $table->double('discount_value')->nullable();
            $table->double('percent_value')->nullable();
            $table->enum('apply_for', DiscountApplyFor::getValues())->default(DiscountApplyFor::All->value);
            $table->enum('status', ActiveStatus::getValues())->default(ActiveStatus::Active->value);
            $table->text('description')->nullable();
            $table->boolean('show_home')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};