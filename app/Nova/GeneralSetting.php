<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\Place;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;

class GeneralSetting extends Resource
{
  /**
   * The model the resource corresponds to.
   *
   * @var string
   */
  public static $model = \App\GeneralSetting::class;

  /**
   * The single value that should be used to represent the resource when being displayed.
   *
   * @var string
   */
  public static $group = 'عام';

  public static $title = 'title';
  public static function label()
  {
    return (' الإعدادات العامة');
  }

  public static function singularLabel()
  {
    return ('الأعدادات العامة');
  }


  /**
   * The columns that should be searched.
   *
   * @var array
   */
  public static $search = [
    'id',
  ];

  /**
   * Get the fields displayed by the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function fields(Request $request)
  {
    return [
      ID::make()->sortable(),
      Heading::make(' إعدادات الموقع العامة'),
      Text::make('اسم المتجر', 'name')
        ->sortable()
        ->rules('required', 'max:255'),
      Text::make('اسم المتجر بالانجليزي', 'name_en')
        ->sortable(),
      Text::make('لاحقة الاسم', 'slogan')
        ->rules('max:255')
        ->hideFromIndex(),

      Text::make('الدليل', 'slug')
        ->rules('max:255')
        ->hideFromIndex(),


      Text::make('الايميل الاساسي', 'email_1')
        ->rules('max:255')
        ->help('المرسل له وللاشعارات'),

      Text::make('الرقم الضريبي', 'commercial_register')
        ->rules('max:255')
        ->hideFromIndex(),

      Text::make('رقم السجل التجاري', 'business_register_number')
        ->rules('nullable', 'max:255')
        ->help('يظهر في فوتر الموقع ويمكن تعديله لاحقا')
        ->hideFromIndex(),

      Text::make(' الضريبة', 'tax')
        ->hideFromIndex(),



      Image::make('الشعار', 'logo')
        ->disk('public'),
      Image::make(' 2 الشعار', 'logo2')
        ->disk('public'),
      Image::make(' الصورو المصغرة ', 'favicon')
        ->disk('public'),
      Image::make(' الصورة الإفتراضية للمنتجات ', 'default_service_image')
        ->disk('public'),
      Text::make('اللون الأساسي', 'color_1')
        ->rules('max:255')
        ->hideFromIndex(),
      Text::make('اللون الثانوي', 'color_2')
        ->rules('max:255')
        ->hideFromIndex(),
      Text::make('اللون 3', 'color_3')
        ->rules('max:255')
        ->hideFromIndex(),
      //------- بيانات إضافية
      Heading::make('بيانات تعريفيه'),

      Trix::make('تعرف بسيط', 'summary')
        ->hideFromIndex(),

      Trix::make('عن المتجر', 'about')
        ->hideFromIndex(),


      Trix::make('الرؤية', 'vision')
        ->hideFromIndex(),

      Trix::make('الرسالة', 'message')
        ->hideFromIndex(),


      Select::make(' تعليمات وأنظمة المتجر الافتراضية ', 'instructions')
        ->options(\App\Definition::where('type_id', '=', 7)
          ->pluck('name', 'id'))
        ->hideFromIndex(),



      Text::make('المدير ', 'manager')
        ->rules('max:255'),

      Textarea::make('كلمة  المدير', 'word')
        ->hideFromIndex(),


      Image::make('التوقيع', 'signature')
        ->hideFromIndex(),

      // //------- أوقات الدوام
      // Heading::make('أوقات الدوام')
      //   ->hideFromIndex(),

      // Textarea::make('أيام العمل ', 'working_days')
      //     ->hideFromIndex(),

      // Textarea::make('أوقات الدوام ', 'working_hours')
      //     ->hideFromIndex(),

      BelongsTo::make('صفحة سياسة الخصوصية', 'page_policy', 'App\Nova\Post')
        ->nullable()
        ->hideFromIndex(),

      BelongsTo::make('صفحة الحسابات البنكية', 'page_bank_accounts', 'App\Nova\Post')
        ->nullable()
        ->hideFromIndex(),

      // Heading::make('هيدر الفاتورة'),
      // Trix::make('العمود الأول في الفاتورة','first_invoice_column')->hideFromIndex(),
      // Trix::make('العمود الثاني في الفاتورة','second_invoice_column')->hideFromIndex(),
      // Trix::make('العمود الثالث في الفاتورة','third_invoice_column')->hideFromIndex(),
      // Trix::make('العمود الرابع في الفاتورة','forth_invoice_column')->hideFromIndex(),


      //------- بيانات التواصل
      Heading::make('بيانات التواصل'),

      Text::make('الايميل الظاهر', 'email_2')
        ->rules('max:255')
        ->help('الذي يظهر في صحفات التواصل')
        ->hideFromIndex(),


      Text::make('رقم الهاتف', 'phone')
        ->rules('max:255')
        ->hideFromIndex(),

      Text::make('رقم الجوال', 'mobile')
        ->rules('max:255')
        ->hideFromIndex(),

      Text::make('رقم الواتساب', 'whatsapp')
        ->rules('max:255')
        ->hideFromIndex(),

      Text::make('صندوق البريد', 'pobox')
        ->rules('max:255')
        ->hideFromIndex(),

      Text::make('العنوان', 'address')
        ->hideFromIndex(),

      Place::make('المكان', 'place')
        ->hideFromIndex(),

      Text::make('الموقع الإلكتروني', 'website')
        ->hideFromIndex(),
      Number::make('قيمة الشحن', 'shipment_price')->hideFromIndex(),
      //------- بيانات مواقع التواصل الاجتماعي
      Heading::make('بيانات مواقع التواصل الاجتماعي'),


      Text::make('x', 'x')
        ->hideFromIndex(),
      Text::make('tiktok', 'tiktok')
        ->hideFromIndex(),
      Text::make('facebook', 'facebook')
        ->hideFromIndex(),

      Text::make('instagram', 'instagram')
        ->hideFromIndex(),

      Text::make('youtube', 'youtube')
        ->hideFromIndex(),

      Text::make('snapchat', 'snapchat')
        ->hideFromIndex(),

      Text::make('linkedin', 'linkedin')
        ->hideFromIndex(),

      Text::make('telegram', 'telegram')
        ->hideFromIndex(),

      Text::make('zoom', 'zoom')
        ->hideFromIndex(),

      Text::make('حساب منصة اكس', 'x_n')
        ->hideFromIndex(),
      Text::make('حساب تيك توك', 'tiktok_n')
        ->hideFromIndex(),
      Text::make('حساب الفيس بوك', 'facebook_n')
        ->hideFromIndex(),

      Text::make('حساب انستقرام', 'instagram_n')
        ->hideFromIndex(),

      Text::make('حساب اليوتيوب', 'youtube_n')
        ->hideFromIndex(),

      Text::make('حساب سناب شات', 'snapchat_n')
        ->hideFromIndex(),

      Text::make('حساب لينك ان', 'linkedin_n')
        ->hideFromIndex(),

      Text::make('حساب التلقرام', 'telegram_n')
        ->hideFromIndex(),

      Text::make('حساب الزوم', 'zoom_n')
        ->hideFromIndex(),

      //------- الإعدادات العامة


      Heading::make('إعدادات فور جوالي '),

      Text::make('App Id', 'sender_user')
        ->withMeta([
          'extraAttributes' => [
            'placeholder' => 'sender_user',
          ]
        ])
        ->hideFromIndex(),
      Text::make('App secret', 'sender_password')
        ->withMeta([
          'extraAttributes' => [
            'placeholder' => 'sender_password',
            'type' => 'password',
          ]
        ])
        ->onlyOnForms(),

      Text::make('sender name', 'sender_name')
        ->withMeta([
          'extraAttributes' => [
            'placeholder' => 'sender_name',
          ]
        ])
        ->hideFromIndex(),



      //-------






      // Heading::make('بيانات الدفع عن طريق تابي '),

      // Text::make('المفتاح الخاص','tabbySectretKey')
      //     ->hideFromIndex(),
      //       Text::make('المفتاح العام','tabbyPublicKey')
      //     ->hideFromIndex(),
      //       Boolean::make('تفعيل','tabbyPaymentActivate')
      //     ->hideFromIndex(),
      Heading::make('بيانات الدفع عن طريق تاب '),
      Text::make('المفتاح السري', 'tapSectretKey')
        ->hideFromIndex(),
      Text::make('المفتاح العام', 'tapPublicKey')
        ->hideFromIndex(),
      Boolean::make('تفعيل', 'tapPaymentActivate')
        ->hideFromIndex(),
      // Heading::make('بيانات الدفع عن طريق تمارا '),
      // Text::make('الرابط', 'tamaraApiUrl')
      //   ->hideFromIndex(),
      // Text::make(' التوكين', 'tamaraToken')
      //   ->hideFromIndex(),
      // Text::make(' توكين الإشعارات', 'tamaraNotificationToken')
      //   ->hideFromIndex(),
      // Text::make('المفتاح العام', 'tamaraPublicKey')
      //   ->hideFromIndex(),
      // Boolean::make('تفعيل', 'tamaraPaymentActivate')
      //   ->hideFromIndex(),
      // Heading::make('بيانات الدفع عن طريق امازون '),
      // Text::make(' رابط ال api', 'amazonGatewayHost')
      //   ->hideFromIndex(),
      // Text::make(' معرف التاجر في امازون', 'amazonMerchantIdentifier')
      //   ->hideFromIndex(),
      // Text::make(' كود الوصول ', 'amazonAccessCode')
      //   ->hideFromIndex(),
      // Text::make('amazonSHARequestPhrase ', 'amazonSHARequestPhrase')
      //   ->hideFromIndex(),
      // Text::make('amazon SHA Response Phrase ', 'amazonSHAResponsePhrase')
      //   ->hideFromIndex(),
      // Text::make('amazonSHAType', 'amazonSHAType')
      //   ->hideFromIndex(),
      // Boolean::make('تفعيل', 'amazonPaymentActivate')
      //   ->hideFromIndex(),
      // Heading::make('بيانات الدفع عن طريق تمام '),

      // Text::make('client_id', 'tamam_client_id')
      //   ->hideFromIndex(),
      // Text::make(' رابط طريقة الدفع', 'tamam_root_host')
      //   ->hideFromIndex(),
      // Text::make('secret_key', 'tamam_secret_key')
      //   ->hideFromIndex(),
      // Text::make('merchant_id', 'tamam_merchant_id')
      //   ->hideFromIndex(),
      // Boolean::make('تفعيل', 'tamam_activate')
      //   ->hideFromIndex(),

      // Heading::make('بيانات الدفع عن طريق مدفوع '),
      // Text::make('الرابط', 'madfu_url')
      //   ->hideFromIndex(),
      // Text::make(' اسم المستخدم', 'madfu_userName')
      //   ->hideFromIndex(),
      // Text::make('كلمة السر', 'madfu_password')
      //   ->hideFromIndex(),
      //   Text::make('الكود', 'madfu_appcode')
      //   ->hideFromIndex(),
      //   Text::make('PlatformTypeId', 'madfu_PlatformTypeId')
      //   ->hideFromIndex(),
      //   Text::make(' مفتاح ال api', 'madfu_apikey')
      //   ->hideFromIndex(),
      // Text::make('توكين التحقق', 'madfu_Authorization')
      //   ->hideFromIndex(),
      // Boolean::make('تفعيل', 'madfuPaymentActivate')
      //   ->hideFromIndex(),

      Heading::make('  إعدادات البريد الإلكتروني عن طريق mailgun '),
      Text::make('MAIL_MAILER ', 'MAIL_MAILER')
        ->hideFromIndex(),
      Text::make('MAIL_HOST', 'MAIL_HOST')
        ->hideFromIndex(),
      Text::make('MAIL_PORT ', 'MAIL_PORT')
        ->hideFromIndex(),
      Text::make('MAIL_USERNAME ', 'MAIL_USERNAME')
        ->hideFromIndex(),
      Text::make('MAIL_PASSWORD ', 'MAIL_PASSWORD')
        ->hideFromIndex(),
      Text::make('MAIL_ENCRYPTION', 'MAIL_ENCRYPTION')
        ->hideFromIndex(),
      Text::make('MAIL_FROM_ADDRESS', 'MAIL_FROM_ADDRESS')
        ->hideFromIndex(),
      Text::make('MAILGUN_DOMAIN', 'MAILGUN_DOMAIN')
        ->hideFromIndex(),
      Text::make('MAILGUN_SECRET', 'MAILGUN_SECRET')
        ->hideFromIndex(),
      Heading::make('  إعدادات zoom '),
      Text::make('ZOOM_API_URL ', 'ZOOM_API_URL')
        ->hideFromIndex(),
      Text::make('ZOOM_CLIENT_KEY', 'ZOOM_CLIENT_KEY')
        ->hideFromIndex(),
      Text::make('ZOOM_CLIENT_SECRET ', 'ZOOM_CLIENT_SECRET')
        ->hideFromIndex(),
      Text::make('ZOOM_JWT_TOKEN ', 'ZOOM_JWT_TOKEN')
        ->hideFromIndex(),


    ];
  }



  /**
   * Get the cards available for the request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function cards(Request $request)
  {
    return [];
  }

  /**
   * Get the filters available for the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function filters(Request $request)
  {
    return [];
  }

  /**
   * Get the lenses available for the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function lenses(Request $request)
  {
    return [];
  }

  /**
   * Get the actions available for the resource.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return array
   */
  public function actions(Request $request)
  {
    return [];
  }
}
