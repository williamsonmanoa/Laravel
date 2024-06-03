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
        Schema::table('coureurs', function (Blueprint $table) {
            $table->foreignId('equipe_id')->nullable()->index()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coureurs', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Equipe::class);
        });
    }
};
