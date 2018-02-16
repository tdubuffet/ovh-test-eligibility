<?php
/**
 * Created by PhpStorm.
 * User: tdubuffet
 * Date: 16/02/2018
 * Time: 19:56
 */

require "GimmeProxy.php";

class OvhRequest
{

    public function get($phone, $debug = false)
    {
        $proxy = new GimmeProxy();

        $selectedProxy = $proxy->getRandomProxy();

        if ($debug) {
            echo $selectedProxy . "\n";
        }


        $url = "https://www.ovhtelecom.fr/cgi-bin/ajax/ajaxEligibilityCheck.cgi?number=" . $phone;

        $curlOptions = array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => $url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 9,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => 0,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",
            CURLINFO_HEADER_OUT  => true,
        );
        $curl = curl_init();
        curl_setopt_array($curl, $curlOptions);
        if($selectedProxy) {
            curl_setopt($curl, CURLOPT_PROXY, $selectedProxy);
        }
        $data = curl_exec($curl);
        curl_close($curl);


        if ($debug) {
            echo $data . "\n";
        }


        return $data;
    }

    public function absoluteFullRequest($phone, $debug = false)
    {

        $maxRequest = 0;

        do {

            ++$maxRequest;

            $value = $this->get($phone, $debug);
        } while ($value == false && $maxRequest <= 10);

        return $value;

    }

}