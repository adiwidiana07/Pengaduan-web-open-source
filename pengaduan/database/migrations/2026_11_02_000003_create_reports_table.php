<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aspiration_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->char('reporter_hash', 64);
            $table->string('alasan', 40);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['aspiration_id', 'reporter_hash']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
