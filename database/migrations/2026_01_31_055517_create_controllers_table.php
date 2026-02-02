<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('controllers', function (Blueprint $table) {
            $table->id();

            $table->boolean('status')->default(true); // true = active, false = inactive

            $table->string('status')->default('active');
            // allowed values: active, disabled

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('controllers');
    }
};
