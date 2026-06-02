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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->string('slug')->nullable();
            $table->longText('body')->nullable();
            $table->string('tags')->nullable();
            $table->boolean('comments')->default(false);
            $table->integer('type')->default(1);
            $table->integer('type_user')->default(1);
            $table->integer('user_id')->default(1);
            $table->string('images')->nullable();
            $table->datetime('publish_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
