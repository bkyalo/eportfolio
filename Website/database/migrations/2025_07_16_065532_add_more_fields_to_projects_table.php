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
        Schema::table('projects', function (Blueprint $table) {
            $table->string('stack');
            $table->boolean('is_live')->default(false);
            $table->string('github_url')->nullable();
            $table->enum('status', ['complete', 'in_progress'])->default('in_progress');
            $table->boolean('is_small_project')->default(false);
            $table->renameColumn('url', 'live_url');
            $table->renameColumn('description', 'brief_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['stack', 'is_live', 'github_url', 'status', 'is_small_project']);
            $table->renameColumn('live_url', 'url');
            $table->renameColumn('brief_description', 'description');
        });
    }
};
