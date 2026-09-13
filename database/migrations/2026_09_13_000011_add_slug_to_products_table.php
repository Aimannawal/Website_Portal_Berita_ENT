<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('title');
        });

        DB::table('products')->orderBy('id')->each(function (object $product): void {
            $baseSlug = Str::slug($product->title) ?: 'product';
            $slug = $baseSlug;
            $counter = 2;

            while (DB::table('products')->where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $baseSlug.'-'.$counter++;
            }

            DB::table('products')->where('id', $product->id)->update(['slug' => $slug]);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
