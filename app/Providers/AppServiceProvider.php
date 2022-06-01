<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
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

        // DB::listen(function($query) {
        //     Log::info(
        //         $query->sql . ' #TIME: ' . $query->time . ' #BINDINGS: ',
        //         $query->bindings
        //     );
        // });

        Schema::defaultStringLength('191');
        \URL::forceScheme('https');

        $options = LIBXML_COMPACT | LIBXML_PARSEHUGE;

//        \PHPExcel_Settings::setLibXmlLoaderOptions($options);

        // DB::listen(function ($query) {
        //     File::append(
        //         storage_path('/logs/query.log'),
        //         '==> ' . $query->sql . ' [' . implode(', ', $query->bindings) . ']' . ' [' . $query->time . ' ms]' . PHP_EOL
        //     );
        // });
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
