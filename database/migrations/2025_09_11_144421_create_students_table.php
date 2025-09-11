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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
             $table->string('full_name');
            $table->string('email')->unique();
            $table->string('whatsapp_number')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->text('address')->nullable();
            $table->string('college')->nullable();
            $table->string('degree')->nullable();
            $table->string('year_of_passing')->nullable();
            $table->string('company')->nullable();
            $table->string('role')->nullable();
            $table->string('experience')->nullable();
            $table->string('upload_file')->nullable();
            $table->string('file_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
