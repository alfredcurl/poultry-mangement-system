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
        Schema::table('feeds', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('expiry_date');
        });

        Schema::table('medications', function (Blueprint $table) {
            $table->text('notes')->nullable()->after('expiry_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feeds', function (Blueprint $table) {
            $table->dropColumn('notes');
        });

        Schema::table('medications', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};

