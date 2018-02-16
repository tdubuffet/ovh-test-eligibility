<?php
/**
 * Created by PhpStorm.
 * User: tdubuffet
 * Date: 16/02/2018
 * Time: 19:51
 */

class GimmeProxy
{

    private $proxyToProxy;

    public function __construct()
    {
    }

    /**
     * On récupére un proxy dérriere un proxy...
     * INCEPTION => http://www.allocine.fr/film/fichefilm_gen_cfilm=143692.html
     */
    public function getProxy()
    {

        $firstUrl = 'http://gimmeproxy.com/api/getProxy?supportsHttps=true&user-agent=true';

        $curlOptions = array(
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_URL => $firstUrl,
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

        if($this->proxyToProxy) {
            curl_setopt($curl, CURLOPT_PROXY, $this->proxyToProxy);
        }

        $data = curl_exec($curl);

        $data = json_decode($data, true);

        curl_close($curl);


        /**
         * On met le proxy en cache, je ne vais plus jamais requêter avec ce proxy...
         * Je ne suis pas fou.
         */
        if (!isset($data['error'])) {
            $this->proxyToProxy = $data['curl'];
        }

        return isset($data['error']) ? false : $data['curl'];

    }

}