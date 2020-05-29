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
            if(\Auth::check())
            {
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
                if(\Auth::user()->role == 0)
                {
                    $event->menu->add(
                    ['header'=>'PHAMACIST'],
                        [
                            'text' => 'PRODUCTS',
                            'icon'    => 'fab fa-product-hunt fa-lg my-2 mr-1 fa-inverse',
                            'submenu' => 
                            [
                                [
                                    'text' => 'All Products',
                                    'url' => route('product.all'),
                                    'icon' => 'fas fa-list my-2 mr-1',
                                  ],
                              [
                                'text' => 'Add Products',
                                'url' => route('product.create'),
                                'icon' => 'fas fa-plus-circle my-2 mr-1',
                              ], 
                            ]
                          ],
                          [
                            'text' => 'Orders',
                            'icon'    => 'fas fa-shopping-bag my-2 mr-1 fa-inverse',
                            'submenu' => 
                            [
                              [
                                'text' => 'Active Orders',
                                'url' => route('order.all'),
                                'icon' => 'fas fa-list my-2 mr-1',
                              ],
                              [
                                'text' => 'Orders History',
                                'url' => route('order.history'),
                                'icon' => 'fas fa-history my-2 mr-1 ',
                              ],
                              [
                                'text' => 'Create Order',
                                'url' => route('order.create'),
                                'icon' => 'fas fa-cart-plus my-2 mr-1',
                              ],
                            ]
                          ],
                          [
                            'text' => 'Deliveries',
                                'icon' => 'fas fa-truck my-2 mr-1 fa-inverse',
                            'submenu' => 
                            [
                              [
                                'text' => 'All Delivery',
                                'url' => route('delivery.all'),
                                'icon'    => 'fas fa-fw fa-users my-2 mr-1',
                              ],
                              [
                                'text' => 'Add Delivery',
                                'url' => route('delivery.create'),
                                'icon' => 'fas fa-plus-circle my-2 mr-1 ',
                                // 'icon_color' => 'blue',
                              ],
                            ]
                          ],
                    );//END PHARMASICST MENU
                }//END IF USER PHARMASICST
                if(\Auth::user()->role == 1)
                {
                    $event->menu->add(
                    ['header'=>'CUSTOMER'],
                          [
                            'text' => 'Orders',
                            'icon'    => 'fas fa-shopping-bag my-2 mr-1 fa-inverse',
                            'submenu' => 
                            [
                              [
                                'text' => 'My Orders',
                                'url' => route('order.myOrders'),
                                'icon' => 'fas fa-bars my-2 mr-1',
                              ],
                              [
                                'text' => 'Orders History',
                                'url' => route('order.history'),
                                'icon' => 'fas fa-history my-2 mr-1',
                              ],
                              [
                                'text' => 'Create Order',
                                'url' => route('order.create'),
                                'icon' => 'fas fa-cart-plus my-2 mr-1',
                              ],
                            ]
                          ],
                    );//END CUSTOMER MENU
                }//END IF USER IS CUSTOMER

            }//END IF AUTH 
        });//END EVENTS->LISTEN
    }
}
