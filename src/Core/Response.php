<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 05.12.2018
 * Time: 15:16
 */

namespace App\Api\Core;


class Response
{
    const BAD_REQUEST = ' 400';
    const E_MSG_ID = 'ID not';

    protected static $instance;

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function renderJson($data,$statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data,JSON_PRETTY_PRINT);
    }

}