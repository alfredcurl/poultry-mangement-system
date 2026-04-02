<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name', 50)->unique(); // e.g., "Large Eggs - 30 Pack"
            $table->enum('egg_size', ['small', 'medium', 'large', 'extra_large'])->default('medium');
            $table->integer('quantity_per_unit')->default(30); // eggs per tray/pack
            $table->text('description');
            $table->decimal('price', 10, 2); // price per unit
            $table->integer('stock'); // available units in stock
            $table->integer('discount')->default(0); // discount percentage
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
