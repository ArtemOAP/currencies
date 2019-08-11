<?php
namespace App\Api;
use App\Api\Core\ManagerDbInterface;


class ManagerDb implements ManagerDbInterface
{
    /**
     * @var \PDO
     */
    public static $pdo;

    /**
     * @return \PDO
     */
    public static function getPdo(): \PDO
    {
        return self::$pdo;
    }
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