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
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('quality', 'relevance', 'satisfaction');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->tinyInteger('quality')->nullable();
            $table->tinyInteger('relevance')->nullable();
            $table->tinyInteger('satisfaction')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('quality', 'relevance', 'satisfaction');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->tinyInteger('quality')->nullable(false);
            $table->tinyInteger('relevance')->nullable(false);
            $table->tinyInteger('satisfaction')->nullable(false);
        });
    }
};
