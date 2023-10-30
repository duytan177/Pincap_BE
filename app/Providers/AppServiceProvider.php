<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

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
        //
        Validator::extend('phone_vietnam', function ($attribute, $value, $parameters, $validator) {
            // Sử dụng biểu thức chính quy để kiểm tra định dạng số điện thoại Việt Nam (10 số)
            return preg_match('/^0[0-9]{9}$/', $value);
        });
    }
}
