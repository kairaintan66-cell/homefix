<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technician_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('technician_id')
                ->constrained('technicians')
                ->cascadeOnDelete();

            $table->string('day');

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->boolean('is_available')->default(true);

            $table->timestamps();

            $table->unique(['technician_id', 'day']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technician_schedules');
    }
};