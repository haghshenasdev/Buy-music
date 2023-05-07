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
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('amount');
            $table->foreignId('user')->constrained('users');
            $table->foreignId('music')->nullable()->constrained('musics')->nullOnDelete();
            $table->foreignId('comment')->nullable()->constrained('comments')->nullOnDelete();
            $table->string('RefID');
            $table->boolean('is_presell')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};
