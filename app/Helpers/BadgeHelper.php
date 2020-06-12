<?php

namespace App\Helpers;

class BadgeHelper
{
    public static function getBadgeClass($id)
    {
        $classes = [
            'badge-primary',
            'badge-success',
            'badge-danger',
            'badge-warning',
            'badge-info'
        ];

        return $classes[$id % 5];
    }
}
