<?php

namespace App\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    /**
     * @param $requestUrl
     * @param array $params
     * @return array
     */
    public static function get($requestUrl, array $params = []) : array
    {
        $client = new Client();

        sleep(1);

        $request = $client->get($requestUrl, $params);
        $result = json_decode($request->getBody(), true);

        return is_array($result) ? $result : [];
    }
}
