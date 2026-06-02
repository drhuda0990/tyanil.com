<?php

namespace App\Support;

use App\Contact;
use App\Customer;
use App\ServiceInvoice;
use App\ServiceInvoiceItem;
use App\StoreNotification;
use App\User;
use Laravel\Nova\Notifications\NovaNotification;

class InternalNotificationService
{
    public static function notifyAdmins(string $type, string $titleAr, ?string $bodyAr = null, array $options = []): void
    {
        if (!static::enabledFor($type)) {
            return;
        }

        User::query()->each(function (User $user) use ($type, $titleAr, $bodyAr, $options) {
            static::create([
                'audience' => 'admin',
                'user_id' => $user->id,
                'type' => $type,
                'title_ar' => $titleAr,
                'body_ar' => $bodyAr,
            ], $options);

            if ((bool) StoreSettings::get()->internalNotificationsActivate) {
                $user->notify(
                    NovaNotification::make()
                        ->message(trim($titleAr.PHP_EOL.($bodyAr ?? '')))
                        ->type($options['nova_type'] ?? static::novaType($options['priority'] ?? 'normal'))
                );
            }
        });
    }

    public static function notifyCustomer(Customer $customer, string $type, string $titleAr, ?string $bodyAr = null, array $options = []): StoreNotification
    {
        return static::create([
            'audience' => 'customer',
            'customer_id' => $customer->id,
            'type' => $type,
            'title_ar' => $titleAr,
            'body_ar' => $bodyAr,
        ], $options);
    }

    public static function orderCreated(ServiceInvoice $invoice): void
    {
        $customer = $invoice->customer;
        $customerName = $customer?->name ?: 'عميل';
        $amount = number_format((float) $invoice->amount, 2);
        $adminUrl = static::novaResourceUrl('service-invoices', $invoice->id);
        $customerUrl = route('customer.invoice', ['id' => encrypt($invoice->id)]);

        static::notifyAdmins(
            'order_created',
            'طلب جديد في المتجر',
            "قام {$customerName} بإنشاء طلب جديد بقيمة {$amount} SAR.",
            [
                'priority' => 'high',
                'service_invoice_id' => $invoice->id,
                'action_url' => $adminUrl,
                'data' => [
                    'invoice_id' => $invoice->id,
                    'amount' => $invoice->amount,
                    'customer_id' => $invoice->customer_id,
                ],
            ]
        );

        if ($customer && (bool) StoreSettings::get()->customerNotificationsActivate) {
            static::notifyCustomer(
                $customer,
                'order_created',
                'تم إنشاء طلبك بنجاح',
                "تم استلام طلبك رقم #{$invoice->id} ويمكنك متابعة تفاصيله من لوحة العميل.",
                [
                    'service_invoice_id' => $invoice->id,
                    'action_url' => $customerUrl,
                    'data' => [
                        'invoice_id' => $invoice->id,
                        'amount' => $invoice->amount,
                    ],
                ]
            );
        }
    }

    public static function contactCreated(Contact $contact): void
    {
        static::notifyAdmins(
            'contact_created',
            'رسالة تواصل جديدة',
            "وصلت رسالة من {$contact->name} بعنوان: {$contact->subject}",
            [
                'priority' => 'normal',
                'contact_id' => $contact->id,
                'action_url' => static::novaResourceUrl('contacts', $contact->id),
                'data' => [
                    'contact_id' => $contact->id,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                ],
            ]
        );
    }

    public static function serviceItemUpdated(ServiceInvoiceItem $item): void
    {
        static::notifyAdmins(
            'service_item_updated',
            'تحديث تفاصيل منتج مطلوب',
            "قام العميل بتحديث تفاصيل المنتج: {$item->title}",
            [
                'priority' => 'normal',
                'service_invoice_id' => $item->service_invoice_id,
                'action_url' => static::novaResourceUrl('service-invoice-items', $item->id),
                'data' => [
                    'service_invoice_item_id' => $item->id,
                    'customer_id' => $item->customer_id,
                ],
            ]
        );
    }

    private static function create(array $payload, array $options = []): StoreNotification
    {
        return StoreNotification::create(array_merge($payload, [
            'priority' => $options['priority'] ?? 'normal',
            'status' => 'unread',
            'title_en' => $options['title_en'] ?? null,
            'body_en' => $options['body_en'] ?? null,
            'service_invoice_id' => $options['service_invoice_id'] ?? null,
            'contact_id' => $options['contact_id'] ?? null,
            'action_url' => $options['action_url'] ?? null,
            'channels' => $options['channels'] ?? ['internal'],
            'data' => $options['data'] ?? [],
            'sent_at' => now(),
        ]));
    }

    private static function enabledFor(string $type): bool
    {
        $settings = StoreSettings::get();

        if (!(bool) $settings->internalNotificationsActivate) {
            return false;
        }

        if (str_starts_with($type, 'order_')) {
            return (bool) $settings->orderNotificationsActivate;
        }

        if (str_starts_with($type, 'contact_')) {
            return (bool) $settings->contactNotificationsActivate;
        }

        return true;
    }

    private static function novaType(string $priority): string
    {
        return match ($priority) {
            'critical', 'high' => 'warning',
            'success' => 'success',
            default => 'info',
        };
    }

    private static function novaResourceUrl(string $resource, int $id): string
    {
        return url(trim(config('nova.path', '/adminPanel'), '/')."/resources/{$resource}/{$id}");
    }
}
