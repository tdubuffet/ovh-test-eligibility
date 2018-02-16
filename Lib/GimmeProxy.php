<?php
/**
 * Created by PhpStorm.
 * User: tdubuffet
 * Date: 16/02/2018
 * Time: 19:51
 */

class GimmeProxy
{

    public function __construct()
    {
    }

    public function getRandomProxy()
    {
        $data = json_decode(file_get_contents('http://gimmeproxy.com/api/getProxy?get=true&supportsHttps=true&maxCheckPeriod=3600'), 1);
        if(isset($data['error'])) {
            echo $data['error']."\n";
        }
        return isset($data['error']) ? false : $data['curl'];
    }

    public function getCacheProxy()
    {

    }

}