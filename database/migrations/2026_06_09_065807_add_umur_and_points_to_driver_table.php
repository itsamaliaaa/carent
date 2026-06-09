<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('driver', function (Blueprint $table) {
            // Menambahkan kolom umur jika belum ada
            if (!Schema::hasColumn('driver', 'umur')) {
                $table->integer('umur')->after('tgl_lahir')->nullable();
            }

            // Menambahkan kolom points untuk sistem Round Robin jika belum ada
            if (!Schema::hasColumn('driver', 'points')) {
                $table->integer('points')->default(0)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('driver', function (Blueprint $table) {
            $table->dropColumn(['umur', 'points']);
        });
    }
};
