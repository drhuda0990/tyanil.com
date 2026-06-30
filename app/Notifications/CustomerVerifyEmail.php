<?php

namespace App\Notifications;

use App\Definition;
use App\General;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class CustomerVerifyEmail extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $body = $this->renderBody($notifiable, $verificationUrl);

        return (new MailMessage)
            ->subject('تفعيل بريدك الإلكتروني في تيانيل')
            ->view(['emails.customer-template', 'emails.customer-template-text'], [
                'title' => 'تفعيل بريدك الإلكتروني',
                'body' => $body,
                'actionText' => 'تفعيل البريد الإلكتروني',
                'actionUrl' => $verificationUrl,
            ])
            ->withSymfonyMessage(function ($message) {
                $headers = $message->getHeaders();
                $headers->addTextHeader('Auto-Submitted', 'auto-generated');
                $headers->addTextHeader('X-Auto-Response-Suppress', 'All');
            });
    }

    protected function verificationUrl(MustVerifyEmail $notifiable): string
    {
        return URL::temporarySignedRoute(
            'customer.verification.verify',
            now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    protected function renderBody($notifiable, string $verificationUrl): string
    {
        $template = Definition::where('slug', 'email_verification')
            ->where('activate', 1)
            ->value('content');

        if (! $template) {
            $template = '<p>مرحباً [customer_name]،</p><p>يسعدنا انضمامك إلى تيانيل. اضغطي على الزر التالي لتفعيل بريدك الإلكتروني وإكمال تجربة التسوق بثقة.</p><p>إذا لم تقومي بإنشاء حساب في تيانيل، يمكنك تجاهل هذه الرسالة.</p>';
        }

        $body = str_replace(
            ['[customer_name]', '[verify_url]', '[site_url]', '[store_name]'],
            [e($notifiable->name ?: 'عميلتنا'), e($verificationUrl), e(url('/')), e(config('app.name', 'تيانيل'))],
            $template
        );

        return General::sanitizeEmailHtml($body);
    }
}
