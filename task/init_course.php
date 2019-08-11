<?php
require_once '../vendor/autoload.php';

$client = new \App\Api\ClientAPI("https://currate.ru/api/","bbbb4e59d1a344b06417e829bd59f403");
$currency  = \App\Api\entity\Currency::getInstance(\App\Api\ManagerDb::Connect());
$currencyHistory  = \App\Api\entity\History::getInstance(\App\Api\ManagerDb::Connect());
$list = $currency->fetchAllCurrency();
$data = $client->getCourse(implode(',',$list));
if(!empty($data['data']) && !empty($data['status']) && $data['status'] == 200){
    foreach ($data['data'] as $code=> $sal){
        $currencyHistory->addCurrencySalary($code,$sal);
    }
};