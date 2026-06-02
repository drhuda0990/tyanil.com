<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\General;
use Laravel\Nova\Fields\Text;
use Mailgun\Mailgun;
use App\Customer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
    $mg = Mailgun::create(env('MAILGUN_SECRET'));
    $domain = env('MAILGUN_DOMAIN');

    // Send to all opted-in store customers.
    if ($fields->all_customers) {

      // Fetch valid emails only
      $customers = Customer::query()
        ->where('prevent_advertising_emails', '!=', 1)
        ->whereNotNull('email')
        ->where('email', '!=', '')
        ->whereNotIn('email', ['@', '#', '0', '+', '&'])
        ->pluck('email')
        ->toArray();

      // Gmail-safe batch size
      $customers = array_chunk($customers, 50);

      foreach ($customers as $batch) {

        $mg->messages()->send($domain, [
          'from'  => env('APP_NAME') . '<' . env('MAIL_FROM_ADDRESS') . '>',
          'to'    => env('MAIL_FROM_ADDRESS'),
          'bcc'   => $batch,
          'subject' => $fields->title,
          'template' => $fields->template_name,
          'h:Message-Id' => '<' . Str::uuid() . '@' . env('MAIL_FROM_ADDRESS') . '>',
          'h:List-Unsubscribe' => '<mailto:unsubscribe@' . $domain . '>',
          'h:List-Unsubscribe-Post' => 'List-Unsubscribe=One-Click',
        ]);

        // Slow down to avoid Gmail rate limits
        sleep(4);
      }
    }

    // Send to specific email
    if ($fields->specific_email_boolean) {
      $mg->messages()->send($domain, [
        'from'  => env('APP_NAME') . '<' . env('MAIL_FROM_ADDRESS') . '>',
        'to'    => env('MAIL_FROM_ADDRESS'),
        'bcc'   => $fields->specific_email,
        'subject' => $fields->title,
        'template' => $fields->template_name,
        'h:Message-Id' => '<' . Str::uuid() . '@' . env('MAIL_FROM_ADDRESS') . '>',
      ]);
    }
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
      Text::make('اسم القالب المستخدم في الايميل من mailgun', 'template_name')->help('template2')->rules('required'),
      Text::make('الايميل الذي يتم ارسال الرسالة إلية', 'specific_email'),
      Boolean::make('إرسال  الرسالة لإيميل محدد', 'specific_email_boolean'),
      Boolean::make('إرسال الرسالة لجميع عملاء المتجر', 'all_customers')->help('قد تأخذ عملية الإرسال دقائق حسب عدد العملاء'),
      // Heading::make('<p>هل أنت متأكد من إرسال الرسالة للعملاء المحددين؟</p>')->asHtml(),
    ];
  }
}
