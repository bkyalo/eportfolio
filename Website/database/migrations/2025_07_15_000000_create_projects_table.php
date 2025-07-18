<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('url')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
