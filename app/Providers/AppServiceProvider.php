<?php

namespace App\Providers;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add(
                ['header' => 'account_settings'],
                [
                    'text' => 'Profile',
                    'url'  => route('profile.show',\Auth::user()),
                    'icon' => 'fas fa-user fa-lg mr-1 my-2',
                    
                ],
            );//END EVENT->MENU->ADD
        });//END EVENTS->LISTEN
    }
}
