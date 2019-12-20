<?php
namespace Daesk\Api\Providers;

use Daesk\Api\Client;

class LaravelServiceProvider extends \Illuminate\Support\ServiceProvider
{
  public function boot()
  {

  }

  public function register()
  {
    $this->app->bind(
      \Daesk\Api\Contracts\Client::class,
      \Daesk\Api\Client::class
    );
  }

  public function provides()
  {
    return [
        \Daesk\Api\Client::class
    ];
  }
}
