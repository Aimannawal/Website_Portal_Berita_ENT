<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penulis_berita', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_id')->constrained('berita')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role_in_content')->nullable(); // ex: 'reporter', 'editor', 'fotografer'
            $table->timestamps();

            $table->unique(['berita_id', 'user_id']); // 1 user cuma muncul sekali per berita
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penulis_berita');
    }
};
