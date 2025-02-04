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
        Schema::create('logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->enum('log_type', ['sign in', 'sign out', 'add clock', 'remove clock', 'update clock', 'configure clock', 'clock went offline', 'clock went online', 'add user', 'remove user', 'update user', 'activate user', 'deactivate user', 'add line', 'remove line', 'update line', 'misc']);
            $table->text('description');
            $table->foreignId('actor')->nullable()->index();
            $table->string('ip_address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
