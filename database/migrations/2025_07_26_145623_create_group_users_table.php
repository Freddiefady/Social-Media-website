<?php

declare(strict_types=1);

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
        Schema::create('group_users', function (Blueprint $table): void {
            $table->id();
            $table->string('role', 25);
            $table->string('status', 25); // e.g., 'approved', 'pending', 'banned'
            $table->string('token', 1024)->nullable();
            $table->string('token_expire_date', 1024)->nullable();
            $table->string('token_used', 1024)->nullable();
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_users');
    }
};
