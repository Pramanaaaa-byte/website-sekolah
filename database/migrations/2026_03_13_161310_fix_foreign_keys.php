<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class FixForeignKeys extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop existing foreign key constraints
        Schema::table('pelanggaran')->dropForeign(['id_guru']);
        Schema::table('pelanggaran')->dropForeign(['id_siswa']);
        
        // Add corrected foreign key constraints
        Schema::table('pelanggaran')->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
        Schema::table('pelanggaran')->foreignId('id_guru')->constrained('guru')->onDelete('cascade');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the new foreign key constraints
        Schema::table('pelanggaran')->dropForeign(['id_guru']);
        Schema::table('pelanggaran')->dropForeign(['id_siswa']);
        
        // Restore original foreign key constraints
        Schema::table('pelanggaran')->foreignId('id_siswa')->constrained('siswa')->onDelete('cascade');
        Schema::table('pelanggaran')->foreignId('id_guru')->nullable()->constrained('guru')->onDelete('set null');
    }
};
