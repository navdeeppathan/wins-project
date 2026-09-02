<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('analysis_of_rates')) {
            Schema::create('analysis_of_rates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('item_code', 50)->nullable()->index();
                $table->text('description');
                $table->string('unit', 20)->default('SQM');
                $table->decimal('material_cost', 12, 2)->default(0.00);
                $table->decimal('labour_cost', 12, 2)->default(0.00);
                $table->decimal('carriage_cost', 12, 2)->default(0.00);
                $table->decimal('machinery_cost', 12, 2)->default(0.00);
                $table->decimal('water_charges_percent', 5, 2)->default(1.00);
                $table->decimal('contractor_profit_percent', 5, 2)->default(15.00);
                $table->decimal('gst_percent', 5, 2)->default(18.00);
                $table->decimal('total_rate', 12, 2)->default(0.00);
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('analysis_of_rates');
    }
};
