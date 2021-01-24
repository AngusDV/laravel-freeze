<?php

namespace AngusDV\DiscoveryClient;


use AngusDV\LaravelFreeze\Exceptions\InvalidLoginException;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;



class LaravelFreezeServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen('eloquent.saving*',function($query){
            if(!strpos($query,'sanctum') && Session::exists('freeze')){
                throw new InvalidLoginException();
            }
        });

        Event::listen('eloquent.deleting*',function($query){
            if(!strpos($query,'sanctum') && Session::exists('freeze')){
                throw new InvalidLoginException();
            }
        });
    }






}
