<?php
namespace App\Api\Core;
class Benchmark
{
    protected static $time_start;
    protected static $memory_start;

    public static function begin()
    {
        self::$time_start  = microtime(true);
        self::$memory_start = memory_get_usage();
        echo "\n" . 'start benchmark' . "\n";
        echo   date('Y-m-d H:i') . "\n";
    }

    protected static function _convert($size)
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    public static function end()
    {
        $time_end = microtime(true);
        echo "\n".'time :'.round($time_end-self::$time_start,3)." ms \n";
        echo 'memory :'.self::_convert((memory_get_usage()-self::$memory_start))."\n";

    }

    public static function countProcess($command)
    {
        exec('ps -ef|grep -v grep|grep '.$command,$output);
        return count($output);
    }

    public static function countFinishProcess($command)
    {
        exec('ps -ef|grep -v grep|grep '.$command,$output);
        $ps = count($output);
        if($ps>2){
            var_export($output);
            echo 'Max Process 1 working '.$ps ."\n";
            die();
        }
    }
}