<?php

namespace App\Classes\Helpers;

class PropertyHelper
{
    /**
     * @param array $filters
     * @return array
     */
    public static function getFiltersWhere(array $filters = []): array
    {
        $where = '';
        $params = [];

        if (!empty($filters['town'])) {
            $where .= ' AND `town` LIKE :town ';
            $params['town'] = '%' . trim($filters['town'] . '%');
        }

        if (!empty($filters['num_bedrooms'])) {
            $where .= ' AND `num_bedrooms` =' . (int)$filters['num_bedrooms'] . ' ';
        }

        if (!empty($filters['min_price'])) {
            $where .= ' AND `price` >=' . (float)$filters['min_price'] . ' ';
        }

        if (!empty($filters['max_price'])) {
            $where .= ' AND `price` <=' . (float)$filters['min_price'] . ' ';
        }

        if (!empty($filters['property_type_id'])) {
            $where .= ' AND `type_id` =' . (int)$filters['property_type_id'] . ' ';
        }

        if (!empty($filters['property_deal_type_id'])) {
            $where .= ' AND `deal_type_id` =' . (int)$filters['property_deal_type_id'] . ' ';
        }

        return [
            'query' => $where,
            'params' => $params
        ];
    }
}
