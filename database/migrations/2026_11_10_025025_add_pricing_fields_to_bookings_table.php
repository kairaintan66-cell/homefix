
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('service_cost', 12, 2)->default(0);
            $table->decimal('material_cost', 12, 2)->default(0);
            $table->decimal('additional_cost', 12, 2)->default(0);

            $table->text('inspection_notes')->nullable();

            $table->string('price_status')
                ->default('belum_diisi');

            $table->timestamp('price_submitted_at')->nullable();
            $table->timestamp('price_approved_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'service_cost',
                'material_cost',
                'additional_cost',
                'inspection_notes',
                'price_status',
                'price_submitted_at',
                'price_approved_at',
            ]);
        });
    }
};
