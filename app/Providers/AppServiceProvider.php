<?php

declare(strict_types=1);

namespace App\Providers;

use App\NeedNavigator\HttpClient;
use App\NeedNavigator\NeedNavigatorClient;
use App\NeedNavigator\StubClient;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(NeedNavigatorClient::class, function (): NeedNavigatorClient {
            return match (config('sitehub.need_navigator.driver')) {
                'http' => new HttpClient,
                default => new StubClient,
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
