<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Aspirasi lama (berbasis token) tidak punya akun pemilik, jadi author_hash-nya NULL:
    // tetap tampil publik dan bisa dimoderasi, tetapi tidak bisa diedit siapa pun.
    public function up(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            $table->dropColumn('owner_token');
        });

        Schema::table('aspirations', function (Blueprint $table) {
            $table->char('author_hash', 64)->nullable()->after('isi')->index();
        });
    }

    public function down(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            $table->dropIndex(['author_hash']);
            $table->dropColumn('author_hash');
        });

        Schema::table('aspirations', function (Blueprint $table) {
            $table->uuid('owner_token')->nullable()->after('isi');
        });
    }
};
