<?php

namespace NickDeKruijk\Oxxa;

use GuzzleHttp\Client;

class Oxxa
{
    const API_ENDPOINT = "https://api.oxxa.com/command.php";

    public static function call(array $arguments)
    {
        $client = new Client([
            'base_uri' => self::API_ENDPOINT,
            'timeout'  => 10.0,
        ]);

        $query = [
            'apiuser' => config('oxxa.auth.username'),
            'apipassword' => config('oxxa.auth.password'),
        ];

        $query = array_merge($query, $arguments);

        $res = $client->get('command.php', [
            'query' => $query,
        ]);

        $xml = simplexml_load_string($res->getBody());
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);
        return $array;
    }

    public static function domain_list($take = -1)
    {
        $order = self::call([
            'command' => 'domain_list',
            'records' => $take,
        ]);

        if ($order['order']['status_code'] != 'XMLOK18') {
            throw new \Exception($order['order']['status_description']);
        };

        return collect($order['order']['details']['domain']);
    }
}
