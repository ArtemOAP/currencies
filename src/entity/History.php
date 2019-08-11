<?php

namespace App\Api\entity;


use App\Api\ManagerDb;

class History
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
     *
     * @param ManagerDb $md
     */
    public function __construct(ManagerDb $md)
    {
        $this->md = $md;
    }



    public function addCurrencySalary($code,$salary)
    {
        try {
            $row  = Currency::getInstance($this->md)->findIdCurrency($code);
            if(!empty($row['id'])){
                $prep = $this->md::getPdo()->prepare("INSERT INTO history (id_currency,course) values (:id_currency,:course )");
                $prep->execute(['id_currency'=>(int)$row['id'],'course'=>$salary]);
            }
        } catch (\PDOException $e) {
            //log TODO
            $this->error_messages= ['msg' => $e->getMessage() ] ;
        }
    }


    public function find(int $id,$from = null,$to = null):array
    {
        if($from && $to){
            $stat = $this->md::getPdo()->prepare('SELECT course, `date` from history WHERE id_currency = :id AND DATE(`date`)  between :f AND :t  order by date desc  limit 360');
            $stat->execute(['id'=>$id, 'f'=>$from,'t'=>$to]);

        }else{
            $stat = $this->md::getPdo()->prepare('SELECT course, `date` from history WHERE id_currency = :id order by `date` desc limit 360');
            $stat->execute(['id'=>$id]);
        }

        return $stat->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return ManagerDb
     */
    public function getMd(): ManagerDb
    {
        return $this->md;
    }

}