<?php
require_once '../vendor/autoload.php';

$client = new \App\Api\ClientAPI("https://currate.ru/api/","bbbb4e59d1a344b06417e829bd59f403");
$list = \App\Api\ManagerDb::Connect()->fetchAllCurrency();
$data = $client->getCourse(implode(',',$list));
if(!empty($data['data']) && !empty($data['status']) && $data['status'] == 200){
    foreach ($data['data'] as $code=> $sal){
        \App\Api\ManagerDb::Connect()->addCurrencySalary($code,$sal);
    }
};