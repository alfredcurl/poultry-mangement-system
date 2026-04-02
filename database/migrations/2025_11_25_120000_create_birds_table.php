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
        Schema::create('birds', function (Blueprint $table) {
            $table->id();
            $table->string('bird_type'); // e.g., Layer, Broiler
            $table->string('breed'); // e.g., Rhode Island Red, Leghorn
            $table->integer('quantity');
            $table->date('acquisition_date');
            $table->decimal('acquisition_cost', 10, 2);
            $table->integer('age_in_weeks')->default(0);
            $table->enum('status', ['active', 'sold', 'deceased'])->default('active');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('birds');
    }
};
