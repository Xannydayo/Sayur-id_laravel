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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type'); // percentage atau fixed
            $table->decimal('value', 10, 2); // nilai diskon
            $table->decimal('min_order', 10, 2)->nullable(); // minimum order untuk menggunakan kupon
            $table->integer('max_uses')->nullable(); // maksimum penggunaan kupon
            $table->integer('used_count')->default(0); // jumlah penggunaan kupon
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
