<?php

namespace App\Api\entity;


use App\Api\ManagerDb;

class Currency
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



    public function createCurrency($code)
    {
        try {

            $prep = $this->md::getPdo()->prepare("INSERT INTO list (code) values (:code )");
            $prep->execute(['code'=>$code]);

        } catch (\PDOException $e) {
            //log TODO
            $this->md->error_messages= ['msg' => $e->getMessage() ] ;
        }
    }

    public function findIdCurrency($code){
        $stat = $this->md::getPdo()->prepare('SELECT id from list WHERE code = :code');
        $stat->execute(['code'=>$code]);
        return $stat->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAllCurrency()
    {
        $queryBild = $this->md::getPdo()->query('SELECT code from list');
        $queryBild->setFetchMode(\PDO::FETCH_OBJ);
        $res =  $queryBild->fetchAll(\PDO::FETCH_ASSOC);

        $cur = [];
        if(!empty($res)){
            foreach ($res as $item){
                $cur[] = $item['code'];
            }
        }
        return $cur;
    }

    public function currencies():array
    {
        $queryBild = $this->md::getPdo()->query('SELECT id, code from list');
        $queryBild->setFetchMode(\PDO::FETCH_OBJ);
        return $queryBild->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return ManagerDb
     */
    public function getMd(): ManagerDb
    {
        return $this->md;
    }




}