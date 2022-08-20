<?php

namespace App\Classes\Models;

use App\Classes\Model;

class PropertyDealType extends Model
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    protected string $table = 'property_deal_types';
}
