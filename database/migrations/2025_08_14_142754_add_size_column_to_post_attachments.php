<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_attachments', function (Blueprint $table): void {
            $table->integer('size')->after('mime');
        });
    }

    public function down(): void
    {
        Schema::table('post_attachments', function (Blueprint $table): void {
            $table->dropColumn('size');
        });
    }
};
