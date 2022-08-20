<?php

namespace App\Classes;

use App\Classes\Helpers\StringHelper;

class Model extends Db
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @var array
     */
    protected array $apiKeysMappings = [];

    /**
     * @var array
     */
    protected array $fillable = [];

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        foreach ($params as $key => $value) {
            $propKey = StringHelper::toCamelCase($key);

            if (property_exists($this, $propKey)) {
                $this->$propKey = $value;
            }
        }
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        $array = [];

        foreach ($this as $key => $value) {
            $arrayKey = StringHelper::toSnakeCase($key);

            if (!in_array($arrayKey, $this->fillable)) {
                continue;
            }

            $array[$arrayKey] = $value;
        }

        return $array;
    }

    /**
     * @param array $data
     * @return void
     */
    public function fillFromApi(array $data)
    {
        foreach ($data as $key => $value) {
            if (!isset($this->apiKeysMappings[$key])) {
                continue;
            }
            $propKey = $this->apiKeysMappings[$key];
            if (property_exists($this, $propKey)) {
                $this->$propKey = $value;
            }
        }
    }
}
