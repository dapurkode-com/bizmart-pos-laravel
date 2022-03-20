<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Bizmart POS',
    'title_prefix' => '',
    'title_postfix' => ' | BizPos ',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => true,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => 'Bizmart <b>POS</b>',
    'logo_img' => '/images/logo.png',
    'logo_img_class' => 'brand-image elevation-3 img-circle',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Bizmart logo',

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-orange',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-orange',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => 'navbar-orange',
    'classes_brand_text' => 'text-white',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-orange elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-orange navbar-dark',
    'classes_topnav_nav' => 'navbar-expand-md',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'login_url' => 'login',

    'register_url' => '',

    'password_reset_url' => '',

    'password_email_url' => '',

    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [
        // Navbar items:
        [
            'text'      => 'Penjualan',
            'url'       => '/sell/create',
            'topnav'    => 'true',
        ],
        [
            'text'      => 'Pembelian',
            'url'       => '/buy/create',
            'topnav'    => 'true',
        ],
        [
            'text'      => 'Opname',
            'url'       => '/opname',
            'topnav'    => 'true',
        ],
        [
            'text'      => 'Retur',
            'url'       => '/return_item',
            'topnav'    => 'true',
        ],
        [
            'text'      => 'Dashboard',
            'url'       => '/home',
            'icon'      => 'fas fa-fw fa-tachometer-alt'
        ],
        ['header' => 'DATA MASTER'],
        [
            'text'    => 'Pengguna',
            'icon'    => 'fas fa-fw  fa-user-cog',
            'url'     => '/user',
        ],
        [
            'text'    => 'Barang',
            'icon'    => 'fas fa-fw fa-box',
            'url'     => '/item',
        ],
        [
            'text'    => 'Supplier',
            'icon'    => 'fas fa-fw fa-truck',
            'url'     => '/supplier',
        ],
        [
            'text'    => 'Member',
            'icon'    => 'fas fa-fw fa-user',
            'url'     => '/member',
        ],
        [
            'text'      => 'Kategori Barang',
            'url'       => 'category',
            'icon'      => 'fas fa-fw fa-list',
        ],
        [
            'text'    => 'Satuan Barang',
            'url'     => '/unit',
            'icon'    => 'fas fa-fw fa-list',
        ],
        ['header' => 'TRANSAKSI'],
        [
            'text'      => 'Pembelian',
            'icon'      => 'fas fa-fw fa-truck',
            'submenu' => [
                [
                    'text'      => 'Pembelian Baru',
                    'url'       => '/buy/create',
                ],
                [
                    'text'      => 'Pembayaran Hutang',
                    'url'       => '/buy_payment_hs',
                ],
            ]
        ],
        [
            'text'      => 'Penjualan',
            'icon'      => 'fas fa-fw fa-shopping-cart',
            'submenu' => [
                [
                    'text'      => 'Penjualan Baru',
                    'url'       => '/sell/create',
                ],
                [
                    'text'      => 'Penagihan Piutang',
                    'url'       => '/sell_payment_hs',
                ],
            ]
        ],
        [
            'text'    => 'Lainnya',
            'icon'    => 'fas fa-fw fa-caret-square-down',
            'submenu' => [
                [
                    'text'    => 'Biaya',
                    'url'     => '/other_expense/create',
                ],
                [
                    'text'      => 'Retur',
                    'url'       => '/return_item',
                ],
                [
                    'text'      => 'Opname',
                    'url'       => '/opname',
                ],
            ]
        ],
        ['header' => 'DATA TRANSAKSI'],
        [
            'text'    => 'Daftar Pembelian',
            'icon'    => 'fas fa-fw fa-clipboard-list',
            'url'     => '/buy',
        ],
        [
            'text'    => 'Daftar Penjualan',
            'icon'    => 'fas fa-fw fa-clipboard-list',
            'url'     => '/sell',
        ],
        [
            'text'    => 'Lainnya',
            'icon'    => 'fas fa-fw fa-caret-square-down',
            'submenu' => [
                [
                    'text'    => 'Daftar Biaya',
                    'url'     => '/other_expense',
                ],
                [
                    'text'    => 'Daftar Piutang',
                    'url'     => '/sell_payment_hs',
                ],
                [
                    'text'    => 'Daftar Hutang',
                    'url'     => '/buy_payment_hs',
                ],
            ],
        ],
        ['header' => 'LAPORAN'],
        [
            'text'    => 'Laporan Pembelian',
            'icon'    => 'fas fa-fw  fa-chart-line',
            'url'     => '/buy_report',
        ],
        [
            'text'    => 'Laporan Penjualan',
            'icon'    => 'fas fa-fw  fa-chart-line',
            'url'     => '/sell_report',
        ],
        [
            'text'    => 'Laporan Arus Kas',
            'icon'    => 'fas fa-fw fa-money-bill-wave',
            'url'     => '/cashflow',
        ],
        [
            'text'    => 'Laporan Stok Barang',
            'icon'    => 'fas fa-fw fa-boxes',
            'url'     => '/item_report',
        ],
        [
            'text'    => 'Laporan Laba-Rugi',
            'icon'    => 'fas fa-fw fa-money-bill-wave',
            'url'     => '/profit_loss',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,

        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
        App\ConfigLte\CustomFilter::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        "Custom" => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'plugins/custom/global.style.css',
                ],
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
