<?php

namespace App\Api\Core;


final class Router
{
    protected $method;
    protected $url;
    protected $mathe;
    /**
     * @var array Request
     */
    protected $aloweRequests = [];

    protected static $route;

    public static function getInstance(){
        if(!isset(self::$route)){
            self::$route = new self();
        }
        return self::$route;
    }
    protected function __construct()
    {
    }
    protected function __clone()
    {
    }

    public function addAllowableRequest(RequestInterface $request)
    {
        $this->aloweRequests[] =  $request;
    }
    public function countAllowableRequest():int
    {
        return count($this->aloweRequests);
    }

    public function search(array $nodes):?RequestInterface
    {

        $map = [];
        foreach ($this->aloweRequests as $req){
          array_map(function ($el1,$el2) use(&$map){
               if ($el1 == $el2 && !empty($el2)){
                   $map[$el1] = $el2;
                   return $el2;
               }elseif(strpos($el1,'}') && $el2){
                   $map[str_replace(['{','}'],['',''],$el1)] = $el2;
                   return $el2;
               }elseif($el1 != $el2){
                   $map =null;
                   return null;
               }
            },$req->getNodesPath(),$nodes);
            if(!empty($map)){
                $req->setNodesPath($map);
                return $req;
            }

        }
        return null;
    }

}