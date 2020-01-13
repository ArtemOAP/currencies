<?php
namespace App\Api;
use App\Api\Core\ManagerDbInterface;


class ManagerDb implements ManagerDbInterface
{
    /**
     * @var \PDO
     */
    public static $pdo;

    public static $config;

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
            if (!self::$config){
                throw new \ErrorException('not set config');
            }
            self::$instance = new self(self::$config['db_host'], self::$config['db_name'], self::$config['db_user'], self::$config['db_pass']);
        }
        return self::$instance;
    }
    public static function setConfig($config){
        self::$config = $config;
    }

    final protected function __clone()
    {
    }

    protected function __construct($db_host, $db_name, $db_user, $db_pass)
    {
        try {
         //   $db_host = 'localhost';
            self::$pdo = new \PDO('mysql:host=' . $db_host .';dbname=' . $db_name . ';charset=utf8', $db_user, $db_pass, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
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