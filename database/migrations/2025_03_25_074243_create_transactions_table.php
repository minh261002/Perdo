<?php

use App\Enums\Transaction\PaymentMethod;
use App\Enums\Transaction\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_code')->unique();
            $table->enum('payment_method', PaymentMethod::getValues())->default(PaymentMethod::COD->value);
            $table->enum('payment_status', PaymentStatus::getValues())->default(PaymentStatus::Pending->value);
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
