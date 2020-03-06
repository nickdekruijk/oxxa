<?php
namespace NickDeKruijk\Oxxa;

use GuzzleHttp\Client;

class Oxxa
{
    const API_ENDPOINT = "https://api.oxxa.com/command.php";

    public function call(Array $arguments)
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
        $array = json_decode($json,TRUE);
        return $array;
    }

    public function domain_list($records = -1)
    {
        return $this->call([
            'command' => 'domain_list',
            'records' => $records,
        ])['order']['details']['domain'];
    }
}
