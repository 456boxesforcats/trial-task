<?php

namespace App\Classes\Models;

use App\Classes\Model;

class Property extends Model
{
    /**
     * @var string
     */
    public string $uuid;

    /**
     * @var int
     */
    public int $typeId;

    /**
     * @var string
     */
    public string $county;

    /**
     * @var string
     */
    public string $country;

    /**
     * @var string
     */
    public string $town;

    /**
     * @var string
     */
    public string $description;

    /**
     * @var string
     */
    public string $address;

    /**
     * @var string
     */
    public string $imageFull;

    /**
     * @var string
     */
    public string $imageThumbnail;

    /**
     * @var float
     */
    public float $latitude;

    /**
     * @var float
     */
    public float $longitude;

    /**
     * @var int
     */
    public int $numBedrooms;

    /**
     * @var int
     */
    public int $numBathrooms;

    /**
     * @var float
     */
    public float $price;

    /**
     * @var int
     */
    public int $dealTypeId;

    /**
     * @var PropertyDealType
     */
    public PropertyDealType $propertyDealType;

    /**
     * @const array
     */
    protected array $apiKeysMappings = [
        'uuid' => 'uuid',
        'property_type_id' => 'typeId',
        'county' => 'county',
        'country' => 'country',
        'town' => 'town',
        'description' => 'description',
        'address' => 'address',
        'image_full' => 'imageFull',
        'image_thumbnail' => 'imageThumbnail',
        'latitude' => 'latitude',
        'longitude' => 'longitude',
        'num_bedrooms' => 'numBedrooms',
        'num_bathrooms' => 'numBathrooms',
        'price' => 'price',
    ];

    /**
     * @var string
     */
    protected string $table = 'properties';

    /**
     * @var array
     */
    protected array $fillable = [
        'uuid',
        'type_id',
        'county',
        'country',
        'town',
        'description',
        'address',
        'image_full',
        'image_thumbnail',
        'latitude',
        'longitude',
        'num_bedrooms',
        'num_bathrooms',
        'price',
        'deal_type_id'
    ];

    /**
     * @return bool
     */
    public function validate()
    {
        // @TODO
    }
}
