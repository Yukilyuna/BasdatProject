<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('prescriptions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete(); // pemilik order

            // awaiting_prescription_upload | prescription_under_review | approved | rejected
            $t->string('status')->default('awaiting_prescription_upload');
            $t->text('note')->nullable();         // alasan/review admin
            $t->json('attachments')->nullable();  // array path file gambar resep

            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('prescriptions');
    }
};
