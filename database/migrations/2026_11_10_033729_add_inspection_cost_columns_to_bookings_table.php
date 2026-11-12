<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            if (!Schema::hasColumn('bookings', 'service_cost')) {
                $table->decimal('service_cost', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('bookings', 'material_cost')) {
                $table->decimal('material_cost', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('bookings', 'additional_cost')) {
                $table->decimal('additional_cost', 12, 2)->default(0);
            }

            if (!Schema::hasColumn('bookings', 'inspection_notes')) {
                $table->text('inspection_notes')->nullable();
            }

            if (!Schema::hasColumn('bookings', 'price_status')) {
                $table->string('price_status')->default('belum_diisi');
            }

            if (!Schema::hasColumn('bookings', 'price_submitted_at')) {
                $table->timestamp('price_submitted_at')->nullable();
            }

            if (!Schema::hasColumn('bookings', 'price_approved_at')) {
                $table->timestamp('price_approved_at')->nullable();
            }

        });
    }

    public function down(): void
    {
        // Tidak menghapus kolom agar data dari migration sebelumnya aman.
    }
};