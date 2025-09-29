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
        Schema::create('student_schedules', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('studentid');
        $table->string('day'); // e.g. Monday
        $table->date('date');  // actual date
        $table->string('time'); // e.g. 9-10 AM
        $table->timestamps();

        $table->foreign('studentid')->references('id')->on('students')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_schedules');
    }
};
