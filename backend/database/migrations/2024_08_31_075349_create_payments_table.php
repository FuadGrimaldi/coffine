<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->enum('payment_method', ['BCA', 'Mandiri', 'QRIS', 'PayPal', 'Cash']);
            $table->decimal('amount', 10, 2);
            $table->dateTime('payment_date')->useCurrent();
            $table->enum('status', ['successful', 'pending', 'failed']);
            $table->string('transaction_code', 20)->unique();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
