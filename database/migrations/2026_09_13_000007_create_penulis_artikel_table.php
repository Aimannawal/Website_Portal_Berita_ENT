<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penulis_artikel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')->constrained('artikel')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role_in_content')->nullable();
            $table->timestamps();

            $table->unique(['artikel_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penulis_artikel');
    }
};
