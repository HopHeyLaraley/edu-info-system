<?php

function output($info){
    echo "<pre>";
    var_dump($info);
    echo "</pre>";
}

class Files{

    protected $token = "y0_AgAAAAB2jKkAAAvriQAAAAEG5AFJAAA_0Q5tkLhEcbYSQAWkmGUmeVdqTA";

    public function sendQueryYaDisk(string $urlQuery, array $arrQuery = [], string $methodQuery = 'GET'): array
    {
        if($methodQuery == 'POST') {
            $fullUrlQuery = $urlQuery;
        } else {
            $fullUrlQuery = $urlQuery . '?' . http_build_query($arrQuery);
        }

        $ch = curl_init($fullUrlQuery);
        switch ($methodQuery) {
            case 'PUT':
                curl_setopt($ch, CURLOPT_PUT, true);
                break;

            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arrQuery));
                break;

            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: OAuth ' . $this->token]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $resultQuery = curl_exec($ch);
        curl_close($ch);

        return (!empty($resultQuery)) ? json_decode($resultQuery, true) : [];
    }

    public function disk_getInfo(): array
    {   
        $urlQuery = 'https://cloud-api.yandex.net/v1/disk/';
        return $this->sendQueryYaDisk($urlQuery);
    }


    public function disk_resources(array $arrParams, string $typeDir = ''): array
    {
        switch ($typeDir) {
            case 'trash':
                /* запрос для директорий в корзине */
                $urlQuery = 'https://cloud-api.yandex.net/v1/disk/trash/resources';
                break;

            case 'standart':
                /* запрос для активных директорий */
                $urlQuery = 'https://cloud-api.yandex.net/v1/disk/resources';
                break;
        }

        return $this->sendQueryYaDisk($urlQuery, $arrParams);
    }
}

$params = [];

$test = new Files();
$result = $test->disk_getInfo();
output($result);