<?php

namespace App\Providers;

use App\Models\KKPK\Kkpk;
use App\Models\LKHP\LkhpFinal;
use App\Models\RiskEvent\RiskEvent;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // BantuanTSI::class => BantuanTSIPolicy::class,
        // PemDeposito::class => PemDepositoPolicy::class,
        RiskEvent::class => UserPolicy::class,
        Kkpk::class => UserPolicy::class,
        LkhpFinal::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // //
    }
}
