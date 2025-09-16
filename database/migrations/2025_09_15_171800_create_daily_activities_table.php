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

            Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->onDelete('casade');
            $table->unsignedBigInteger('faculty_id')->onDelete('casade');
            $table->timestamp('date')->useCurrent();
            $table->time('in_time');
            $table->time('out_time');
            $table->decimal('hours_spent', 5, 2)->nullable();
            $table->json('activities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
