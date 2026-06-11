<?php

namespace App\Providers;

use App\Repositories\Interfaces\LoanRepositoryInterface;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\LoanRepository;
use App\Repositories\RepaymentRepository;
use App\Repositories\UserRepository;
use App\Services\LoanService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services and interface bindings.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
        $this->app->bind(RepaymentRepositoryInterface::class, RepaymentRepository::class);
        $this->app->singleton(LoanService::class);
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
