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
        Schema::table('task_files', function (Blueprint $table) {
            $table->string('original_name'); // Поле для хранения оригинального имени файла
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_files', function (Blueprint $table) {
            $table->dropColumn('original_name'); // Удаляем поле при откате миграции
        });
    }
};
