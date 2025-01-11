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
        Schema::create('tbl_report_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('tbl_students')->cascadeOnDelete();
            $table->string('academic_year');
            $table->string('term');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_report_cards');
    }
};
