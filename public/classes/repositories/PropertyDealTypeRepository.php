<?php

namespace App\Classes\Repositories;

use App\Classes\Models\PropertyDealType;
use App\Classes\Repository;

class PropertyDealTypeRepository extends Repository
{
    /**
     * @var string
     */
    protected string $table = 'property_deal_types';
    /**
     * @var string
     */
    protected string $class = PropertyDealType::class;
}
