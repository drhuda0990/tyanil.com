<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\CourseCount;
use App\Nova\Metrics\CourseTraineeCount;
use App\Nova\Metrics\FinancialCount;
use App\Nova\Metrics\NewUsersCount;
use Anaseqal\NovaImport\NovaImport;
use App\Nova\Dashboards\Main;
use App\Nova\Dashboards\UserInsights;
use SimonHamp\LaravelNovaCsvImport\LaravelNovaCsvImport;
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        parent::boot();


        Nova::style('custome',asset('css/app-RTL.css'));
        Nova::style('custome',asset('css/admin.css'));

        Nova::mainMenu(function ($request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('المتجر والمنتجات', [
                    MenuItem::resource(\App\Nova\Service::class),
                    MenuItem::resource(\App\Nova\ServiceCategory::class),
                    MenuItem::resource(\App\Nova\AdditionalFeatures::class),
                    MenuItem::resource(\App\Nova\Advertisement::class),
                    MenuItem::resource(\App\Nova\Discount::class),
                    MenuItem::resource(\App\Nova\Rating::class),
                ])->icon('shopping-bag')->collapsable(),

                MenuSection::make('الطلبات والمدفوعات', [
                    MenuItem::resource(\App\Nova\ServiceInvoice::class),
                    MenuItem::resource(\App\Nova\ServiceInvoiceItem::class),
                    MenuItem::resource(\App\Nova\SerInvoiceItemsFeature::class),
                    MenuItem::resource(\App\Nova\PaymentRequest::class),
                    MenuItem::resource(\App\Nova\PaymentResponse::class),
                ])->icon('credit-card')->collapsable(),

                MenuSection::make('العملاء والفريق', [
                    MenuItem::resource(\App\Nova\Customer::class),
                    MenuItem::resource(\App\Nova\ServiceAdmind::class),
                    MenuItem::resource(\App\Nova\User::class),
                    MenuItem::resource(\App\Nova\Team::class),
                ])->icon('users')->collapsable(),

                MenuSection::make('المحتوى والتواصل', [
                    MenuItem::resource(\App\Nova\Post::class),
                    MenuItem::resource(\App\Nova\Contact::class),
                    MenuItem::resource(\App\Nova\Message::class),
                    MenuItem::resource(\App\Nova\Partner::class),
                    MenuItem::resource(\App\Nova\Definition::class),
                ])->icon('document-text')->collapsable(),

                MenuSection::make('مركز الإشعارات', [
                    MenuItem::resource(\App\Nova\StoreNotification::class),
                    MenuItem::resource(\App\Nova\NotificationSetting::class),
                ])->icon('bell')->collapsable(),

                MenuSection::make('التكاملات والإعدادات', [
                    MenuItem::resource(\App\Nova\GeneralSetting::class),
                    MenuItem::resource(\App\Nova\PaymentGatewaySetting::class),
                    MenuItem::resource(\App\Nova\EmailProviderSetting::class),
                    MenuItem::resource(\App\Nova\SmsProviderSetting::class),
                ])->icon('cog')->collapsable(),

                MenuSection::make('السجلات', [
                    MenuItem::resource(\App\Nova\ActionEvent::class),
                ])->icon('clipboard-list')->collapsable(),
            ];
        });

    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */

    public static $model = 'App\Admin';
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return (bool) $user->activate;
        });
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            //new Help,
            // new CourseCount,
            // new CourseTraineeCount,
            // new FinancialCount,
            // new NewUsersCount,
        ];
    }

    /**
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
      return [
 Main::make(),
      
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
             new LaravelNovaCsvImport,
             new \Badinansoft\LanguageSwitch\LanguageSwitch(),
            //   new NovaImport,
            //   \Mirovit\NovaNotifications\NovaNotifications::make(),

    ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
