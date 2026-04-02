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
        Schema::create('egg_production', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bird_id')->constrained()->onDelete('cascade');
            $table->date('production_date');
            $table->integer('eggs_collected');
            $table->integer('damaged_eggs')->default(0);
            $table->integer('good_eggs')->default(0);
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
        Schema::dropIfExists('egg_production');
    }
};
