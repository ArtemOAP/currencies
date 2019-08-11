<?php
require_once '../vendor/autoload.php';

$client = new \App\Api\ClientAPI("https://currate.ru/api/","bbbb4e59d1a344b06417e829bd59f403");
$res = $client->getList();


if(!empty($res['data']) && !empty($res['status']) && $res['status'] == 200){
  $currency  = \App\Api\entity\Currency::getInstance(\App\Api\ManagerDb::Connect());
    foreach ($res['data'] as $code){
        $currency->createCurrency($code);
    }
};
