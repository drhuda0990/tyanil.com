<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('general_settings', 'moyasarPaymentActivate')) {
                $table->boolean('moyasarPaymentActivate')->nullable();
            }

            if (! Schema::hasColumn('general_settings', 'moyasarMerchantId')) {
                $table->text('moyasarMerchantId')->nullable();
            }

            if (! Schema::hasColumn('general_settings', 'moyasarPublicKey')) {
                $table->text('moyasarPublicKey')->nullable();
            }

            if (! Schema::hasColumn('general_settings', 'moyasarSecretKey')) {
                $table->text('moyasarSecretKey')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('general_settings', function (Blueprint $table) {
            foreach ([
                'moyasarPaymentActivate',
                'moyasarMerchantId',
                'moyasarPublicKey',
                'moyasarSecretKey',
            ] as $column) {
                if (Schema::hasColumn('general_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
