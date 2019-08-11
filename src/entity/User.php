<?php

namespace App\Api\entity;


use App\Api\ManagerDb;

class User
{
    /**
     * @var ManagerDb
     */
    protected $md;


    protected static $instance = null;

    public static function getInstance(ManagerDb $md)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self( $md);
        }
        return self::$instance;
    }
    /**
     * User constructor.
     * @param ManagerDb $md
     */
    public function __construct(ManagerDb $md)
    {
        $this->md = $md;
    }


    public function addUser($name,$hash)
    {
        try {
            $prep = $this->md::getPdo()->prepare("INSERT INTO user (name,hash) values (:name,:hash )");
            $prep->execute(['name'=>$name,'hash'=>$hash]);
        } catch (\PDOException $e) {
            //log TODO
            $this->md->error_messages= ['msg' => $e->getMessage() ] ;
        }
    }

    /**
     * @param $name
     * @return null|string
     */
    public function hasUser( string $name) :?string
    {
        $hash = null;
        try {
            $prep = $this->md::getPdo()->prepare("SELECT name,hash FROM user where  name = :name");
            $prep->execute(['name'=>$name]);
            $res =  $prep->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            //log TODO
            $this->md->error_messages= ['msg' => $e->getMessage() ] ;
        }

        if(!empty($res)){
            $hash =  $res->hash;
        }
        return $hash;
    }

    /**
     * @return ManagerDb
     */
    public function getMd(): ManagerDb
    {
        return $this->md;
    }

}