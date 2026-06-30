<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\General;
use App\Mail\MainMail;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use App\Customer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendEmail extends Action
{
  use InteractsWithQueue, Queueable;

  public function name()
  {
    return 'إرسال بريد لعملاء المتجر';
  }


  /**
   * Perform the action on the given models.
   *
   * @param  \Laravel\Nova\Fields\ActionFields  $fields
   * @param  \Illuminate\Support\Collection  $models
   * @return mixed
   */
  public function handle(ActionFields $fields, Collection $models)
  {
    $title = trim((string) $fields->title);
    $body = General::sanitizeEmailHtml(nl2br(e((string) $fields->body)));
    $sent = 0;

    if ($fields->all_customers) {
      Customer::query()
        ->where('prevent_advertising_emails', '!=', 1)
        ->whereNotNull('email')
        ->where('email', '!=', '')
        ->whereNotIn('email', ['@', '#', '0', '+', '&'])
        ->orderBy('id')
        ->chunk(25, function ($customers) use ($title, $body, &$sent) {
          foreach ($customers as $customer) {
            if (! filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
              continue;
            }

            Mail::to($customer->email)->send(new MainMail([
              'title' => $title,
              'body' => $body,
              'mail_category' => 'marketing',
              'unsubscribe_url' => URL::signedRoute('email.unsubscribe', ['customer' => $customer->id]),
            ]));

            $sent++;
          }

          sleep(2);
        });
    }

    if ($fields->specific_email_boolean) {
      $email = trim((string) $fields->specific_email);

      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $customer = Customer::where('email', $email)->first();

        Mail::to($email)->send(new MainMail([
          'title' => $title,
          'body' => $body,
          'mail_category' => $customer ? 'marketing' : 'transactional',
          'unsubscribe_url' => $customer ? URL::signedRoute('email.unsubscribe', ['customer' => $customer->id]) : null,
        ]));

        $sent++;
      }
    }

    return Action::message('تم إرسال ' . $sent . ' رسالة بريد عبر إعدادات البريد الحالية للمتجر.');
  }


  /**
   * Get the fields available on the action.
   *
   * @return array
   */
  public function fields(?NovaRequest $request = null)
  {
    return [
      Text::make('العنوان', 'title')->rules('required'),
      Textarea::make('محتوى الرسالة', 'body')
        ->help('اكتب نص الرسالة بدون مبالغة في الروابط أو الصور لضمان وصول أفضل للبريد الوارد.')
        ->rules('required'),
      Text::make('الايميل الذي يتم ارسال الرسالة إلية', 'specific_email'),
      Boolean::make('إرسال  الرسالة لإيميل محدد', 'specific_email_boolean'),
      Boolean::make('إرسال الرسالة لجميع عملاء المتجر', 'all_customers')->help('قد تأخذ عملية الإرسال دقائق حسب عدد العملاء'),
      // Heading::make('<p>هل أنت متأكد من إرسال الرسالة للعملاء المحددين؟</p>')->asHtml(),
    ];
  }
}
