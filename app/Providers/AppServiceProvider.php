<?php

namespace App\Providers;

use App\Models\Product;

use App\Policies\AdminProductPolicy;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    /**

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
        Blade::directive('money', function ($cents) {
            return "<?php echo number_format(($cents)/100, 2, '.', ' ') . ' €'; ?>";
        });
        Gate::policy(Product::class, AdminProductPolicy::class);
    }

}
