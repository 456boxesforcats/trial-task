<?php

namespace App\Classes\Repositories;

use App\Classes\Models\PropertyType;
use App\Classes\Repository;

class PropertyTypeRepository extends Repository
{
    /**
     * @var string
     */
    protected string $table = 'property_types';
    /**
     * @var string
     */
    protected string $class = PropertyType::class;
}
