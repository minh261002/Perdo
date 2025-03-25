<?php

use App\Enums\Transport\TransportStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transport_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transport_id')->constrained()->onDelete('cascade');
            $table->enum('status', TransportStatus::getValues())->default(TransportStatus::Pending->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_statuses');
    }
};