<?php

namespace base\Providers;

use Illuminate\Support\ServiceProvider;

use Validator;
use base\Model\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('correct_category', function ($attribute, $value, $parameters){
            try {
                $category = Category::where('id', $value)->get();
                if (!is_null($category[0])) {
                    return true;
                } else {
                    return false;
                }
            }catch (\Exception $e){
                return false;
            }
        });
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
