<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('event', 30); // login, failed, logout, lockout
            $table->string('email')->nullable();

            $table->string('ip', 45)->nullable();
            $table->text('user_agent')->nullable();

            $table->string('guard', 30)->nullable();
            $table->boolean('success')->default(false);

            $table->string('failure_reason')->nullable(); // inactive, wrong_credentials, throttled...
            $table->timestamps();

            $table->index(['user_id', 'event']);
            $table->index(['email', 'event']);
            $table->index(['ip', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_logs');
    }
};
