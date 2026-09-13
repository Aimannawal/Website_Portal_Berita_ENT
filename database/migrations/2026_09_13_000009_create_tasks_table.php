<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('assigned_by')->constrained('users')->cascadeOnDelete(); // PK yang assign
            $table->foreignId('assigned_to_division')->constrained('divisions')->cascadeOnDelete();
            $table->foreignId('assigned_to_user')->nullable()->constrained('users')->nullOnDelete(); // opsional, ke user spesifik

            // relasi opsional ke konten yang sedang dikerjakan
            $table->foreignId('berita_id')->nullable()->constrained('berita')->nullOnDelete();
            $table->foreignId('artikel_id')->nullable()->constrained('artikel')->nullOnDelete();

            $table->enum('status', ['pending', 'in_progress', 'done', 'rejected'])->default('pending');
            $table->date('deadline')->nullable();
            $table->text('notes')->nullable(); // catatan update dari divisi pelaksana
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
