<?php

namespace App\Support;

use Throwable;

class MailSettings
{
    public static function apply(): void
    {
        try {
            $settings = StoreSettings::get();
        } catch (Throwable $exception) {
            report($exception);
            return;
        }

        $mailer = $settings->mail_provider ?: $settings->MAIL_MAILER ?: config('mail.default', 'smtp');
        $fromAddress = $settings->MAIL_FROM_ADDRESS ?: $settings->email_1 ?: config('mail.from.address');
        $fromName = $settings->MAIL_FROM_NAME ?: $settings->name ?: config('mail.from.name');

        config([
            'mail.default' => $mailer,
            'mail.from.address' => $fromAddress,
            'mail.from.name' => $fromName,
        ]);

        if ($mailer === 'smtp') {
            config([
                'mail.mailers.smtp.host' => $settings->MAIL_HOST ?: config('mail.mailers.smtp.host'),
                'mail.mailers.smtp.port' => $settings->MAIL_PORT ?: config('mail.mailers.smtp.port'),
                'mail.mailers.smtp.encryption' => $settings->MAIL_ENCRYPTION ?: config('mail.mailers.smtp.encryption'),
                'mail.mailers.smtp.username' => $settings->MAIL_USERNAME ?: config('mail.mailers.smtp.username'),
                'mail.mailers.smtp.password' => $settings->MAIL_PASSWORD ?: config('mail.mailers.smtp.password'),
            ]);
        }

        if ($mailer === 'mailgun') {
            config([
                'services.mailgun.domain' => $settings->MAILGUN_DOMAIN ?: config('services.mailgun.domain'),
                'services.mailgun.secret' => $settings->MAILGUN_SECRET ?: config('services.mailgun.secret'),
            ]);
        }
    }
}
