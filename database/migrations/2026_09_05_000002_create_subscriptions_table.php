<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->string('plan_name', 100);
            $table->integer('duration_months');
            $table->decimal('amount', 10, 2);
            $table->string('transaction_number', 191);
            $table->string('reference_number', 191);
            $table->string('payment_screenshot', 255);
            $table->enum('payment_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('subscription_status', ['pending', 'active', 'expired', 'rejected'])->default('pending');
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('action_by')->nullable();
            $table->timestamp('action_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('payment_status');
            $table->index('subscription_status');
            $table->index('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
