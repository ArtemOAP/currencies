<?php

namespace App\Api;
use App\Api\Core\ControllerApp;
use App\Api\Core\Request;
use App\Api\Core\Response;
use App\Api\Core\Listener;

use App\Api\entity\Currency;
use App\Api\entity\History;
use App\Api\entity\User;
use Firebase\JWT\JWT;


class Controller implements ControllerApp
{
    const SECRET_KEY = "megaKey12345!@#$%";

    protected static $instance;
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __call($name, $arguments)
    {
        // log not found method $name or method not public
        Listener::$logger->err(' log not found method',['method'=>$name]);
    }


    public function currencies(Request $request):void
    {
        $dbManager = ManagerDb::Connect();
        $currency = Currency::getInstance($dbManager);
        $resp = !$dbManager->getErrorMessages()?$currency->currencies():$dbManager->getErrorMessages();
        $code = !$dbManager->getErrorMessages()?200:500;
        Response::getInstance()->renderJson($resp,$code);

    }

    public function currency(Request $request):void
    {
        $id = (int)$request->getNodesPath()['id'];

        $from = $request->getParam('d_from');
        $to = $request->getParam('d_to');
        $currencyHistory  = History::getInstance(ManagerDb::Connect());
        Response::getInstance()->renderJson($currencyHistory->find($id,$from,$to));
    }


    public function auth():void
    {
        $res = file_get_contents('php://input');
        $data = json_decode($res,true);
        if (is_null($data) || !isset($data['name']) || !isset($data['pass'])){
            $data = $data?$data:[];
            Listener::$logger->err("auth() require data empty",$data);
            Response::getInstance()->renderJson(['msg'=>"require data empty"]);
            return;
        }
        Listener::$logger->info("auth try ",$data);
        $user = User::getInstance(ManagerDb::Connect());
        $hash = $user->hasUser($data['name']);
        $verify = password_verify($data['pass'],$hash);
        if($verify){
            $token = array(
                "iss" => "http://example-api.org",
                "name" => $data['name'],
                "exp" => strtotime('+1 hour')
            );
            $jwt = JWT::encode($token, self::SECRET_KEY);
            Response::getInstance()->renderJson(['token'=>$jwt]);
            return;
        }
        Response::getInstance()->renderJson(['msg'=>"error auth"]);
    }

    public  function verification($token):bool
    {
        try{
            $res = JWT::decode($token,self::SECRET_KEY,array('HS256'));
        }catch (\Exception $exception){
            Listener::$logger->err($exception->getMessage());
            return false;
        }
        return true;
    }



}