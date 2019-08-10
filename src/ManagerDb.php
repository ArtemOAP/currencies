<?php
namespace App\Api;
use App\Api\Core\ManagerDbInterface;


class ManagerDb implements ManagerDbInterface
{
    /**
     * @var \PDO
     */
    public static $pdo;
    public $patches = array();
    public $error_messages = null;

    protected static $instance = null;

    final public static function Connect()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function createCurrency($code)
    {
        try {

            $prep = self::$pdo->prepare("INSERT INTO list (code) values (:code )");
            $prep->execute(['code'=>$code]);

        } catch (\PDOException $e) {
            //log TODO
            $this->error_messages= ['msg' => $e->getMessage() ] ;
        }
    }

    public function findIdCurrency($code){
        $stat = self::$pdo->prepare('SELECT id from list WHERE code = :code');
        $stat->execute(['code'=>$code]);
       return $stat->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAllCurrency()
    {
        $queryBild = self::$pdo->query('SELECT code from list');
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

    public function addCurrencySalary($code,$salary)
    {
        try {
            $row  = $this->findIdCurrency($code);
            if(!empty($row['id'])){
                $prep = self::$pdo->prepare("INSERT INTO history (id_currency,course) values (:id_currency,:course )");
                $prep->execute(['id_currency'=>(int)$row['id'],'course'=>$salary]);
            }
        } catch (\PDOException $e) {
            //log TODO
            $this->error_messages= ['msg' => $e->getMessage() ] ;
        }
    }


    public function currencies():array
    {
        $queryBild = self::$pdo->query('SELECT id, code from list');
        $queryBild->setFetchMode(\PDO::FETCH_OBJ);
        return $queryBild->fetchAll(\PDO::FETCH_OBJ);
    }

    public function find(int $id,$from = null,$to = null):array
    {
        if($from && $to){
            $stat = self::$pdo->prepare('SELECT course, `date` from history WHERE id_currency = :id AND DATE(`date`)  between :f AND :t  order by date desc  limit 360');
            $stat->execute(['id'=>$id, 'f'=>$from,'t'=>$to]);

        }else{
            $stat = self::$pdo->prepare('SELECT course, `date` from history WHERE id_currency = :id order by `date` desc limit 360');
            $stat->execute(['id'=>$id]);
        }

        return $stat->fetchAll(\PDO::FETCH_OBJ);
    }


    final protected function __clone()
    {
    }

    protected function __construct()
    {
        try {
            self::$pdo = new \PDO('mysql:host=localhost;dbname=currencies;charset=utf8', 'manager', 'passwd',[\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        } catch (\PDOException $e) {
            //TODO log
            //echo 'Error BD';
            $this->error_messages= ['msg' => 'Error BD' ] ;
            return null;
        }
    }

    /**
     * @return null|string
     */
    public function getErrorMessages(): ?array
    {
        return $this->error_messages;
    }


}