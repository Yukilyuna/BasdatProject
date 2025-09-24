<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();

            // status utama sesuai flow "seluruh order tertahan bila ada Rx"
            // jalur: (jika Rx) awaiting_prescription_upload -> prescription_under_review -> awaiting_payment
            // umum: awaiting_payment -> payment_under_review -> paid -> processing -> shipped -> delivered
            // reject/cancel: prescription_rejected, payment_rejected, cancelled
            $t->string('status')->default('awaiting_payment');

            $t->decimal('total_amount', 12, 2)->default(0);

            // data pengiriman sederhana
            $t->string('recipient_name')->nullable();
            $t->string('recipient_phone')->nullable();
            $t->text('shipping_address')->nullable();

            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
