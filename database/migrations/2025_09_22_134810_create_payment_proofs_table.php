<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('payment_proofs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();

            // under_review | approved | rejected
            $t->string('status')->default('under_review');
            $t->string('file_path');
            $t->text('reviewer_note')->nullable();

            $t->timestamp('uploaded_at')->useCurrent();
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('payment_proofs');
    }
};
