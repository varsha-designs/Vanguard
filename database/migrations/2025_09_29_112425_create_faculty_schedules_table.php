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
        Schema::create('faculty_schedules', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('studentid');
    $table->unsignedBigInteger('faculty_id');
    $table->string('day');
    $table->date('date');
    $table->string('time');
    $table->timestamps();

    $table->foreign('studentid')->references('id')->on('students')->onDelete('cascade');
    $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_schedules');
    }
};
