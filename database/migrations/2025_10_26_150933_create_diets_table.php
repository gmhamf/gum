<?php
// database/migrations/2024_01_01_000006_create_diets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDietsTable extends Migration
{
    public function up()
    {
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('meal_name');
            $table->text('description')->nullable();
            $table->integer('calories')->nullable();
            $table->string('time');
            $table->string('day');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('diets');
    }
}
