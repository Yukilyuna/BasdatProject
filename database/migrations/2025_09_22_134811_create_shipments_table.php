<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shipments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('order_id')->constrained()->cascadeOnDelete();
            $t->string('courier_name')->nullable();
            $t->string('tracking_number')->nullable();
            $t->timestamp('shipped_at')->nullable();
            $t->timestamp('delivered_at')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('shipments');
    }
};
