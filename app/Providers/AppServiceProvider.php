<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\AuthRepo\AuthRepo;
use App\Repositories\AuthRepo\AuthRepoInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use TimWassenburg\RepositoryGenerator\Repository\BaseRepository;
use TimWassenburg\RepositoryGenerator\Repository\EloquentRepositoryInterface;

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
        $this->app->bind(EloquentRepositoryInterface::class,BaseRepository::class);
        $this->app->bind(AuthRepoInterface::class,AuthRepo::class);

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
