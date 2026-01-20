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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('id_seller')->unique();
            $table->string('alamat')->nullable();
            $table->string('domisili')->nullable();
            $table->string('no_telpon')->nullable();
            $table->decimal('black_garlic_100g', 10, 2)->default(35000);
            $table->decimal('black_garlic_150g', 10, 2)->default(52500);
            $table->decimal('muliwater_ph_tinggi', 10, 2)->default(37500);
            $table->decimal('muliwater_ph9', 10, 2)->default(42500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
