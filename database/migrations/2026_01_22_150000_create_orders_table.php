<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('address_id')->nullable()->constrained('addresses')->nullOnDelete();

            $table->string('order_number')->unique();

            $table->unsignedInteger('payment_attempt')->default(1);
            $table->string('midtrans_order_id')->unique();
            $table->string('snap_token')->nullable();

            $table->unsignedBigInteger('total_amount');
            $table->string('currency', 3)->default('IDR');

            $table->string('status')->default('pending'); // pending|paid|cancelled|failed

            $table->string('midtrans_transaction_status')->nullable();
            $table->string('midtrans_payment_type')->nullable();
            $table->string('midtrans_fraud_status')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
