<?php

namespace App\Classes\Repositories;

use App\Classes\Api;
use App\Classes\Models\Property;
use App\Classes\Models\PropertyDealType;
use App\Classes\Models\PropertyType;
use App\Classes\Repository;
use Simplon\Mysql\MysqlException;

class PropertyRepository extends Repository
{
    /**
     * @const string
     */
    const API_GET_ALL_URL = 'https://trial.craig.mtcserver15.com/api/properties';

    /**
     * @const array
     */
    const DEAL_TYPES_MAPPING = [
        'sale' => 1,
        'rent' => 2
    ];

    /**
     * @const int
     */
    const API_BUNCH_SIZE = 100;

    /**
     * @var string
     */
    protected string $table = 'properties';

    /**
     * @var string
     */
    protected string $class = Property::class;

    /**
     * @return array
     */
    public function getFromApi(int $pageNumber): array
    {
        $params = [
            'query' => [
                'api_key' => $_ENV['API_KEY'],
                'page[number]' => $pageNumber,
                'page[size]' => self::API_BUNCH_SIZE
            ]
        ];

        return Api::get(self::API_GET_ALL_URL, $params);
    }

    /**
     * @param int $pageNumber
     * @return void
     * @throws \Simplon\Mysql\MysqlException
     */
    public function saveAllFromApi(int $pageNumber = 1)
    {
        $apiData = $this->getFromApi($pageNumber);

        if (empty($apiData['data'])) {
            return;
        }

        $pageCount = (int)ceil($apiData['total'] / $apiData['per_page']);

        $propertyTypes = [];
        $properties = [];

        foreach ($apiData['data'] as $row) {
            $propertyType = new PropertyType();
            $propertyType->fillFromApi($row['property_type']);
            $propertyTypes[] = $propertyType->toArray();

            $property = new $this->class();
            $property->fillFromApi($row);
            $property->dealTypeId = self::DEAL_TYPES_MAPPING[$row['type']];
            $properties[] = $property->toArray();
        }

        // Insert or update property types first
        $propertyTypeRepository = new PropertyTypeRepository();
        $propertyTypeRepository->insertOrUpdate($propertyTypes);

        // Then properties
        $this->insertOrUpdate($properties);

        if ($pageNumber <= $pageCount) {
            $this->saveAllFromApi($pageNumber + 1);
        }
    }

    /**
     * @param int|null $itemsPerPage
     * @param int $offset
     * @param array $where
     * @return array
     * @throws \Simplon\Mysql\MysqlException
     */
    public function getWithRelations(int $itemsPerPage = null, int $offset = 0, array $where = []): array
    {
        $models = [];

        $query = 'SELECT `' . $this->table . '`.*, 
        `property_deal_types`.`id` AS `deal_type_id`, 
        `property_deal_types`.`title` AS `deal_type_title`,
        `property_types`.`id` AS `property_type_id`, 
        `property_types`.`title` AS `property_type_title`,
        `property_types`.`description` AS `property_type_description`,
        `property_types`.`created_at` AS `property_type_created_at`,
        `property_types`.`updated_at` AS `property_type_updated_at`
        FROM `' . $this->table . '` 
        LEFT JOIN `property_deal_types` ON `deal_type_id` = `property_deal_types`.`id`
        LEFT JOIN `property_types` ON `type_id` = `property_types`.`id` 
        WHERE 1 ' . $where['query'];

        if ($itemsPerPage !== null) {
            $query .= ' LIMIT ' . $offset . ',' . $itemsPerPage;
        }

        try {
            $rows = $this->connection->fetchRowMany($query, $where['params']);
        } catch (MysqlException $e) {
            return [];
        }

        if (empty($rows)) {
            return [];
        }

        foreach ($rows as $row) {
            $property = new $this->class($row);

            $property->propertyDealType = new PropertyDealType([
                'id' => $row['deal_type_id'],
                'title' => $row['deal_type_title']
            ]);

            if ($row['property_type_id']) {
                $property->propertyType = new PropertyType([
                    'id' => $row['property_type_id'],
                    'title' => $row['property_type_title'],
                    'description' => $row['property_type_description'],
                    'created_at' => $row['property_type_created_at'],
                    'updated_at' => $row['property_type_updated_at']
                ]);
            }

            $models[] = $property;
        }

        return $models;
    }
}
