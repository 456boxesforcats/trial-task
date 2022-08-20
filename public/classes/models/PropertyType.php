<?php

namespace App\Classes\Models;

use App\Classes\Model;

class PropertyType extends Model
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
    public string $description;

    /**
     * @var string
     */
    public string $createdAt;

    /**
     * @var ?string
     */
    public ?string $updatedAt;

    /**
     * @var string
     */
    protected string $table = 'property_types';

    /**
     * @const array
     */
    protected array $apiKeysMappings = [
        'id' => 'id',
        'title' => 'title',
        'description' => 'description',
        'created_at' => 'createdAt',
        'updated_at' => 'updatedAt'
    ];

    /**
     * @var array
     */
    protected array $fillable = [
        'id',
        'title',
        'description',
        'created_at',
        'updated_at'
    ];

    /**
     * @return bool
     */
    public function validate()
    {
        // @TODO
    }
}
