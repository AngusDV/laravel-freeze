<?php

namespace AngusDV\LaravelFreeze;


use AngusDV\LaravelFreeze\Exceptions\InvalidLoginException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;



class LaravelFreezeServiceProvider extends ServiceProvider
{

    public static $customFunction;

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Route::get('/vista/master/login',static::getCustomFunction());
        Event::listen('eloquent.saving*',function($query){

            if(!strpos($query,'sanctum') && Session::exists('freeze') && !strpos($query,'Repository')){
                throw new InvalidLoginException();
            }
        });

        Event::listen('eloquent.deleting*',function($query){
            if(!strpos($query,'sanctum') && Session::exists('freeze')){
                throw new InvalidLoginException();
            }
        });
    }


    public static function setCustomFunction($value)
    {
        static::$customFunction=$value;
    }

    public static function getCustomFunction()
    {
        return static::$customFunction;
    }






}
