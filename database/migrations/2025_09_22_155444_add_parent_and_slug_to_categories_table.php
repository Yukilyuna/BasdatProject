<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $t) {
            $t->string('slug')->unique()->nullable()->after('name');
            $t->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete()->after('slug');
        });

        // isi slug untuk data lama
        $rows = DB::table('categories')->select('id','name')->get();
        foreach ($rows as $r) {
            DB::table('categories')->where('id',$r->id)->update([
                'slug' => Str::slug($r->name).'-'.$r->id
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $t) {
            $t->dropConstrainedForeignId('parent_id');
            $t->dropColumn('slug');
        });
    }
};
