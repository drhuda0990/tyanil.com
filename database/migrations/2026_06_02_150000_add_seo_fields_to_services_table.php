<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (!Schema::hasColumn('services', 'slug')) {
                $table->string('slug', 191)->nullable()->index();
            }

            if (!Schema::hasColumn('services', 'meta_title')) {
                $table->string('meta_title', 191)->nullable();
            }

            if (!Schema::hasColumn('services', 'meta_description')) {
                $table->string('meta_description', 170)->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'slug')) {
                $table->dropIndex(['slug']);
                $table->dropColumn('slug');
            }

            if (Schema::hasColumn('services', 'meta_title')) {
                $table->dropColumn('meta_title');
            }

            if (Schema::hasColumn('services', 'meta_description')) {
                $table->dropColumn('meta_description');
            }
        });
    }
};
