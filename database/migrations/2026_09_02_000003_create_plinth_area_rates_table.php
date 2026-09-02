<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('plinth_area_rates')) {
            Schema::create('plinth_area_rates', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('category', 100)->nullable()->index();
                $table->string('building_type', 255);
                $table->string('no_of_storeys', 50)->nullable();
                $table->decimal('plinth_area', 12, 2)->default(0.00);
                $table->string('unit', 20)->default('SQM');
                $table->decimal('basic_rate', 12, 2)->default(0.00);
                $table->decimal('cost_index', 6, 2)->default(100.00);
                $table->decimal('effective_rate', 12, 2)->default(0.00);
                $table->text('remarks')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('plinth_area_rates');
    }
};
