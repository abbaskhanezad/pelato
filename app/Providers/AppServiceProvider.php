<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        //
        Blade::directive('metronic_datatables_managed', function($arguments){
/*
          return "<?php if ({$arguments}[0]){
            echo {$arguments}[1];
          }; ?>";*/
            /*return '<?php echo $arguments; ?>';**/
            return view('metronic.datatables.managed');
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      if ($this->app->environment() == 'local') {
        $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
      }
    }
}
