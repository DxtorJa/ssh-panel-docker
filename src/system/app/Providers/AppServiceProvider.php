<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Notif;
use App\Admin;
use DB;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        Schema::defaultStringLength(191);

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            echo "<h1>Error establishing database connection.";
            die();
        }

        $site = Admin::where('id', 1)->first();
        if(!$site)
        {
            if($request->path() == 'install')
            {
                return;
            }
            return redirect('/install')->send();
        }

        View::composer('*', function ($view) {
            if(Auth::check())
            {
                $user = Auth::user();
                $view->with('user', $user);
                $view->with('notifs', Notif::where('user_email', $user->email)->get());
            }

            $site = Admin::where('id', 1)->first();
            $view->with('site_setting', $site);
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
