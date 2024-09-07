<?php
namespace App\Providers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{

    // public function boot()
    // {
    //     JsonResource::withoutWrapping();
    // }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        JsonResource::withoutWrapping();


    }
}