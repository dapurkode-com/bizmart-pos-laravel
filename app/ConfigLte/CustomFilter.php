<?php

namespace App\ConfigLte;

use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Menu\Builder;
use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;

class CustomFilter implements FilterInterface
{
    public function transform($item, Builder $builder)
    {
        if (isset($item['previlege']) && !in_array(Auth::user()->privilege_code, explode(',', $item['previlege']))) {
            return [];
        }

        if (isset($item['black_previlege']) && in_array(Auth::user()->privilege_code, explode(',', $item['black_previlege']))) {
            return [];
        }

        return $item;
    }
}
