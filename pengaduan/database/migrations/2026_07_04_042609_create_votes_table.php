<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('votes', function (Blueprint $table) {
    $table->id();

    $table->foreignId('aspiration_id')
          ->constrained()
          ->cascadeOnUpdate()
          ->cascadeOnDelete();

    $table->enum('vote_type', ['upvote', 'downvote']);

    $table->uuid('voter_token');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
