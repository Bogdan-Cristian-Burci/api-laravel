<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_category_id');
            $table->unsignedBigInteger('training_type_id');
            $table->float('total_price')->default(20);
            $table->foreign('training_category_id')->references('id')->on('training_categories');
            $table->foreign('training_type_id')->references('id')->on('training_types');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trainings');
    }
};
