<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_en')->nullable();
            $table->string('slogan')->nullable();
            $table->string('favicon')->nullable();
            $table->string('slug')->nullable();
            $table->text('embeded_video')->nullable();
            $table->text('logo')->nullable();
            $table->text('logo2')->nullable();
            $table->text('color_1')->nullable();
            $table->text('color_2')->nullable();
            $table->text('color_3')->nullable();
            $table->double('shipment_price')->nullable();
            $table->double('tax')->nullable();
            $table->longText('about')->nullable();
            $table->text('default_service_image')->nullable();
            $table->text('summary')->nullable();
            $table->text('vision')->nullable();
            $table->text('message')->nullable();
            $table->string('commercial_register')->nullable();
            $table->string('email_1')->nullable();
            $table->string('email_2')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('pobox')->nullable();
            $table->text('address')->nullable();
            $table->text('place')->nullable();
            $table->text('working_days')->nullable();
            $table->text('working_hours')->nullable();

            $table->string('x')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('snapchat')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('telegram')->nullable();
            $table->string('zoom')->nullable();

            $table->string('x_n')->nullable();
            $table->string('tiktok_n')->nullable();
            $table->string('facebook_n')->nullable();
            $table->string('instagram_n')->nullable();
            $table->string('youtube_n')->nullable();
            $table->string('snapchat_n')->nullable();
            $table->string('linkedin_n')->nullable();
            $table->string('telegram_n')->nullable();
            $table->string('zoom_n')->nullable();
            $table->string('website')->nullable();
            $table->longText('instructions')->nullable();
            $table->string('sender_user')->nullable();
            $table->text('sender_password')->nullable();
            $table->string('sender_name')->nullable();
            $table->string('page_policy_id')->nullable();
            $table->string('page_bank_accounts_id')->nullable();
            $table->string('manager')->nullable();
            $table->text('word')->nullable();
            $table->text('signature')->nullable();
            $table->text('first_invoice_column')->nullable();
            $table->text('second_invoice_column')->nullable();
            $table->text('third_invoice_column')->nullable();
            $table->text('forth_invoice_column')->nullable();
            $table->integer('user_id')->unsigned()->default(1);
            //payment
            $table->text('tabbySectretKey')->nullable();
            $table->text('tabbyPublicKey')->nullable();
            $table->boolean('tabbyPaymentActivate')->nullable();
            $table->text('tapSectretKey')->nullable();
            $table->text('tapPublicKey')->nullable();
            $table->boolean('tapPaymentActivate')->nullable();
            $table->text('tamaraApiUrl')->nullable();
            $table->text('tamaraToken')->nullable();
            $table->text('tamaraNotificationToken')->nullable();
            $table->text('tamaraPublicKey')->nullable();
            $table->boolean('tamaraPaymentActivate')->nullable();
            $table->text('madfu_userName')->nullable();
            $table->text('madfu_password')->nullable();
            $table->text('madfu_Authorization')->nullable();
            $table->text('madfu_appcode')->nullable();
            $table->text('madfu_apikey')->nullable();
            $table->text('madfu_PlatformTypeId')->nullable();
            $table->text('madfu_url')->nullable();
            $table->boolean('madfuPaymentActivate')->nullable();
            $table->text('amazonGatewayHost')->nullable();
            $table->text('amazonMerchantIdentifier')->nullable();
            $table->text('amazonAccessCode')->nullable();
            $table->text('amazonSHARequestPhrase')->nullable();
            $table->text('amazonSHAResponsePhrase')->nullable();
            $table->text('amazonSHAType')->nullable();
            $table->boolean('amazonPaymentActivate')->nullable();
            $table->text('MAIL_MAILER')->nullable();
            $table->text('MAIL_HOST')->nullable();
            $table->text('MAIL_PORT')->nullable();
            $table->text('MAIL_USERNAME')->nullable();
            $table->text('MAIL_PASSWORD')->nullable();
            $table->text('MAIL_ENCRYPTION')->nullable();
            $table->text('MAIL_FROM_NAME')->nullable();
            $table->text('MAIL_FROM_ADDRESS')->nullable();
            $table->text('MAILGUN_DOMAIN')->nullable();
            $table->text('MAILGUN_SECRET')->nullable();
            $table->text('ZOOM_API_URL')->nullable();
            $table->text('ZOOM_JWT_TOKEN')->nullable();
            $table->text('ZOOM_CLIENT_KEY')->nullable();
            $table->text('ZOOM_CLIENT_SECRET')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
