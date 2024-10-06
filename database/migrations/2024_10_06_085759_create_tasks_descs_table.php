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
        Schema::create('tasks_descs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained(
                table: 'tasks'
            );
            $table->foreignId('desc_id')->constrained(
                table: 'descs'
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks_descs');
    }
};
