<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technicians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technicians');
    }
};