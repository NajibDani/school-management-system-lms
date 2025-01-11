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
        Schema::create('tbl_report_card_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_card_id')->constrained('tbl_report_cards')->cascadeOnDelete();
            $table->string('subject');
            $table->string('grade');
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_report_card_details');
    }
};
