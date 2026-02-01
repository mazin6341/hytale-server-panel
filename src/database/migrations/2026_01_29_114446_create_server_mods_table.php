<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('server_mods', function (Blueprint $table) {
            $table->integer('curse_id')->unique()->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('author_name')->nullable();
            $table->text('summary')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->string('file_name');
            $table->string('version');
            $table->string('mod_url')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('server_mods');
    }
};