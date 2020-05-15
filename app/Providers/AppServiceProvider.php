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
                ['header'=>'HOME PAGE'],
                [
                    'text' => 'Home',
                    'url'  => 'home',
                    'icon' => 'fas fa-fw fa-home fa-lg fa-inverse',
                    
                ],
                ['header'=>'account_settings'],
                [
                'text' => 'account_settings',
                'icon'    => 'fas fa-user ', 
                'icon' => 'fas fa-cog fa-spin fa-lg my-2 mr-1 fa-inverse ',
                'submenu' => 
                [
                    [
                        'text' => 'Profile',
                        'url'  => route('profile.show',\Auth::user()),
                        'icon' => 'fas fa-user fa-lg mr-1 my-2',
                        
                    ],
                  [
                    'text' => 'Edit Profile',
                    'url'  => route('profile.edit'),
                    'icon' => 'far fa-edit my-2 ',
                ], 
                [
                    'text' => 'Change Password',
                    'url'  => route('profile.change.password'),
                    'icon' => 'fas fa-fw fa-lock my-2',
                ], 
                ]
              ],
            );//END EVENT->MENU->ADD
        });//END EVENTS->LISTEN
    }
}
