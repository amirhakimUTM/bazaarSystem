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
        Schema::create('food_weights', function (Blueprint $table) {
            $table->id();
            $table->string('bazaarName')->nullable();
            $table->foreign('bazaarName')->references('bazaarName')->on('bazaars')->nullable()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('year')->nullable();
            $table->integer('day')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_weights');
    }
};
