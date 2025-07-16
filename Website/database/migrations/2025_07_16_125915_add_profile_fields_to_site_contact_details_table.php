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
        Schema::table('site_contact_details', function (Blueprint $table) {
            $table->text('saying')->nullable()->after('bio');
            $table->string('saying_author')->nullable()->after('saying');
            $table->string('tags')->nullable()->after('saying_author');
            $table->text('home_description')->nullable()->after('tags');
            $table->text('contact_description')->nullable()->after('home_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_contact_details', function (Blueprint $table) {
            $table->dropColumn([
                'saying',
                'saying_author',
                'tags',
                'home_description',
                'contact_description'
            ]);
        });
    }
};
