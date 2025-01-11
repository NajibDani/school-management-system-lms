<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_class_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('tbl_students')->cascadeOnDelete();
            $table->foreignId('class_id')->constrained('tbl_classes')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_class_histories');
    }
};
