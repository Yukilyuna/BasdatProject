<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('medicines', function (Blueprint $t) {
            $t->id();
            $t->foreignId('category_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->decimal('price', 12, 2);
            $t->unsignedInteger('stock')->default(999999); // untuk belajar: praktis "tak habis"
            $t->boolean('is_prescription_only')->default(false); // butuh resep?
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('medicines');
    }
};
