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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');

            $table->integer('qty_blackgarlic_100g')->default(0);
            $table->integer('qty_blackgarlic_150g')->default(0);
            $table->integer('qty_muliwater_ph_tinggi')->default(0);
            $table->integer('qty_muliwater_ph9')->default(0);

            $table->string('category');

            $table->integer('total_price')->default(0);

            $table->date('tanggal');

            $table->enum('metode_pembayaran', ['cash','transfer','qris']);
            $table->enum('status', ['lunas','belum_lunas',])
            ->default('belum_lunas');

            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');

            $table->timestamps();

        });
    }
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
