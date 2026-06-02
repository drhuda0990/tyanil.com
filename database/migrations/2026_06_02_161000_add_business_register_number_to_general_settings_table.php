<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('general_settings', 'business_register_number')) {
            Schema::table('general_settings', function (Blueprint $table) {
                $table->string('business_register_number')->nullable()->after('commercial_register');
            });
        }

        DB::table('general_settings')
            ->whereNull('business_register_number')
            ->update(['business_register_number' => '7033071270']);
    }

    public function down(): void
    {
        if (Schema::hasColumn('general_settings', 'business_register_number')) {
            Schema::table('general_settings', function (Blueprint $table) {
                $table->dropColumn('business_register_number');
            });
        }
    }
};
