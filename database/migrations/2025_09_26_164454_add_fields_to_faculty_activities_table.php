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
        Schema::table('faculty_activities', function (Blueprint $table) {
            $table->time('in_time')->nullable()->after('faculty_id');
            $table->time('out_time')->nullable()->after('in_time');
            $table->decimal('hours_spend', 5, 2)->nullable()->after('out_time');
            $table->text('new_learning')->nullable()->after('hours_spend');
            $table->text('todo_list')->nullable()->after('new_learning');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty_activities', function (Blueprint $table) {
            $table->dropColumn(['in_time', 'out_time', 'hours_spend', 'new_learning', 'todo_list']);
        });
    }
};
