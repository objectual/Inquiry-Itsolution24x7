<?php

namespace App\Providers;

use App\Models\Module;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\NotificationUser;
use App\Observers\ModuleObserver;
use App\Observers\NotificationObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::setLocale('en');
        Schema::defaultStringLength(191);
        Module::observe(ModuleObserver::class);
        NotificationUser::observe(NotificationObserver::class);

        //<editor-fold desc="Custom Validation">

        // Validation Condition
        Validator::extend('route', function ($attribute, $value, $parameters, $validator) {
            return Route::has('admin.' . $value);
        });

        //Validation failure message
        Validator::replacer('route', function ($message, $attribute, $rule, $parameters) {
            $attribute = ucwords(str_replace('_', ' ', $attribute));
            return str_replace(':attribute', $attribute, ':attribute should be valid route name & defined in routes/admin.php');
        });

        //</editor-fold>
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
