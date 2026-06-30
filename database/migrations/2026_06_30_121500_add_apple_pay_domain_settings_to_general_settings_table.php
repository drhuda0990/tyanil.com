<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('general_settings', 'moyasarApplePayDomainName')) {
                $table->text('moyasarApplePayDomainName')->nullable();
            }

            if (! Schema::hasColumn('general_settings', 'moyasarApplePayDomainAssociation')) {
                $table->longText('moyasarApplePayDomainAssociation')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            foreach ([
                'moyasarApplePayDomainName',
                'moyasarApplePayDomainAssociation',
            ] as $column) {
                if (Schema::hasColumn('general_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
