<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#61-title
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#62-favicon
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#63-logo
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#64-user-menu
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#65-layout
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#661-authentication-views-classes
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#662-admin-panel-classes
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#67-sidebar
    |
    */

    'sidebar_mini' => true,
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#68-control-sidebar-right-sidebar
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#69-urls
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#610-laravel-mix
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#611-menu
    |
    */

    'menu' => [
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
                [
                    'text'      => 'Hitung Kas',
                    'url'       => '/cash_count/create',
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
                [
                    'text'      => 'Opname',
                    'url'       => '/opname',
                ],
                [
                    'text'      => 'Retur',
                    'url'       => '/return_item',
                ],
                [
                    'text'      => 'Riwayat Hitung Kas',
                    'url'       => '/cash_count',
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#612-menu-filters
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
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
    | For more detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/#613-plugins
    |
    */

    'plugins' => [
        [
            'name' => 'Datatables',
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
        [
            'name' => 'Select2',
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
        [
            'name' => 'Chartjs',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        [
            'name' => 'Sweetalert2',
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@9',
                ],
            ],
        ],
        [
            'name' => 'Pace',
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
        [
            'name' => 'Custom',
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'plugins/custom/global.style.css',
                ],
            ]
        ],
    ],
];
