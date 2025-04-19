<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable(false);
            $table->text('photo')->nullable(true)->default(null);
            $table->longText('description')->nullable(false);
            $table->float('price')->nullable(false)->default(0);
            $table->enum('status', ['active', 'draft'])->default('active');
            $table->unsignedInteger('stock')->nullable(false)->default(0);
            $table->timestamps();
            $table->softDeletes();
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
