<?php

namespace base\Providers;

use Illuminate\Support\ServiceProvider;

use Validator;
use base\Model\Category;
use base\Model\Client;
use base\Model\Agent;
use base\Model\Activity;

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
        Validator::extend('correct_client', function ($attribute, $value, $parameters){
            try {
                $client = Client::where('id', $value)->get();
                if (!is_null($client[0])) {
                    return true;
                } else {
                    return false;
                }
            }catch (\Exception $e){
                return false;
            }
        });
        Validator::extend('correct_agent', function ($attribute, $value, $parameters){
            try {
                $agent = Agent::where('id', $value)->get();
                if (!is_null($agent[0])) {
                    return true;
                } else {
                    return false;
                }
            }catch (\Exception $e){
                return false;
            }
        });
        Validator::extend('correct_activity', function ($attribute, $value, $parameters){
            try {
                $activity = Activity::where('id', $value)->get();
                if (!is_null($activity[0])) {
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
