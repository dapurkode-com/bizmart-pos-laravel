<?php

namespace App\Helpers;

/**
 * BadgeHelper
 *
 * Helper untuk customize class badge
 *
 * @package Helpers
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
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
