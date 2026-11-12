<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->string('booking_code')->unique();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('technician_id')
                ->nullable()
                ->constrained('technicians')
                ->nullOnDelete();

            $table->foreignId('address_id')
                ->constrained('addresses')
                ->restrictOnDelete();

            $table->date('booking_date');
            $table->time('booking_time');

            $table->text('notes')->nullable();

            $table->decimal('total_price', 12, 2)->default(0);

            $table->string('status')->default('menunggu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};