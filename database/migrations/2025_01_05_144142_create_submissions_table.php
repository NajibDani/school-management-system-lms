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
        Schema::create('tbl_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('tbl_assignments')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('tbl_students')->cascadeOnDelete();
            $table->string('file_url')->nullable();
            $table->float('grade')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('submitted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_submissions');
    }
};
