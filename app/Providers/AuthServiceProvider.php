<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Buys;
use App\Models\Music;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        Gate::define('admin',function (User $user){
            return $user->is_admin == 1;
        });

        Gate::define('payed',function (User $user,Music $music){
            return (Buys::query()->where('user', $user->id)->where('music', $music->id)->count() != 0);
        });

        Gate::define('download',function (User $user,Music $music){
            return ($music->is_active == 1 &&
                $music->presell != 1 &&
                Gate::allows('payed',$music));
        });


    }
}
