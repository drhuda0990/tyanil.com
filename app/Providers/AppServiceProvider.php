<?php

namespace App\Providers;

use App\Support\StoreSettings;
use App\Observers\ProductObserver;
use App\Service;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View; // Correct facade
use Masbug\Flysystem\GoogleDriveAdapter;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
     Schema::defaultStringLength(125);
      Service::observe(ProductObserver::class);
      $this->app->bind('path.public', function() {
           return base_path().'/public';
       });
     

    View::composer('*', function ($view) {
        $view->with('gSetting', StoreSettings::get());
    });
       Storage::extend('google', function ($app, $config) {
        $client = new \Google_Client();
        $client->setClientId($config['clientId']);
        $client->setClientSecret($config['clientSecret']);
        $client->refreshToken($config['refreshToken']);

        $service = new \Google_Service_Drive($client);

        $adapter = new GoogleDriveAdapter($service, $config['folderId'] ?? null);

        // ✅ هذا الكائن لا يدعم put() مباشرةً، لذلك نستخدم Storage facade
        return new \Illuminate\Filesystem\FilesystemAdapter(
            new Filesystem($adapter),
            $adapter,
            $config
        );
    });
    }
    
        private function observers()
    {
    }
}
