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
        Schema::create('tbl_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('tbl_students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('tbl_courses')->cascadeOnDelete();
            $table->string('status')->default('active');
            $table->timestamp('enrolled_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_enrollments');
    }
};
