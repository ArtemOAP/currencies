<?php
/**
 * Created by PhpStorm.
 * User: Dev
 * Date: 11.12.2018
 * Time: 14:27
 */

namespace App\Api\Core;


interface ControllerApp
{
    public  function verification($token):bool;

}