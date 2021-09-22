<?php

namespace App\Providers;

use DB;
use Exception;
use Illuminate\Support\ServiceProvider;
use PDOException;
use Log;

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
        try {
            DB::connection()->getPdo();
        } catch (Exception $e) {
			//return response()->view('errors.databaseConnectionError');
			abort( response()->view('errors.databaseConnectionError'));
        }
    }
}
