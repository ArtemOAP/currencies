<?php
namespace App\Api;


class ClientAPI
{
    public $url;
    public $key;
    public $conf;

    public function __construct($url,$key)
    {
        $this->url = $url;
        $this->key = $key;
    }

    public function getList()
    {
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $this->url."?get=currency_list&key=".$this->key );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        $data = curl_exec( $ch );
        curl_close( $ch );

        var_dump($data);
        return json_decode($data,true);
    }

    public function getCourse(string $code)
    {
        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_URL, $this->url."?get=rates&pairs=".$code."&key=".$this->key );
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );

        $data = curl_exec( $ch );
        curl_close( $ch );

        return json_decode($data,true);
    }

}