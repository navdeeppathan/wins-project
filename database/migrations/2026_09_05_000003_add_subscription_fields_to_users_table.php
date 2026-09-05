<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'plan_id')) {
                $table->unsignedBigInteger('plan_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('users', 'plan_status')) {
                $table->string('plan_status', 50)->default('inactive')->after('plan_id');
            }
            if (!Schema::hasColumn('users', 'plan_expires_at')) {
                $table->date('plan_expires_at')->nullable()->after('plan_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['plan_id', 'plan_status', 'plan_expires_at']);
        });
    }
};
