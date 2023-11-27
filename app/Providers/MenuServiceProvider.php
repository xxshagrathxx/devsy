<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class MenuServiceProvider extends ServiceProvider
{
  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap services.
   *
   * @return void
   */
  public function boot()
  {
    $lang = LaravelLocalization::getCurrentLocale();
    if($lang == 'ar') {
      $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenuAr.json'));
      $verticalMenuData = json_decode($verticalMenuJson);
    } else {
      $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
      $verticalMenuData = json_decode($verticalMenuJson);
    }

    // Share all menuData to all the views
    \View::share('menuData', [$verticalMenuData]);
  }
}
