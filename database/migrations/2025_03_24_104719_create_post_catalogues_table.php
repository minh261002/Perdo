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
        Schema::create('post_catalogues', function (Blueprint $table) {
            $table->id();
            $table->integer('_lft');
            $table->integer('_rgt');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('slug')->unique();
            $table->integer('position')->default(0);
            $table->enum('status', ActiveStatus::getValues())->default(ActiveStatus::Active->value);
            $table->boolean('show_menu')->default(false);
            $table->longText('desc')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('parent_id')
                ->references('id')
                ->on('post_catalogues')
                ->onUpdate('NO ACTION')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_catalogues');
    }
};