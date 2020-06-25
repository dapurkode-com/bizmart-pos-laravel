<?php

namespace App\Traits;

use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;

/**
 * UniqID
 *
 * Generate otomatis UUID versi 4 pada field uniq_id
 *
 * @package Trait
 * @author Satya Wibawa <i.g.b.n.satyawibawa@gmail.com>
 */
trait UniqID
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->uniq_id = Generator::uuid4()->toString();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
