<?php
/**
 * Created by PhpStorm.
 * User: tonis_o
 * Date: 17.04.17
 * Time: 18:22
 */

namespace app\models;


use yii\base\Model;

class Response extends Model
{
    public static function getResponse($url)
    {
        $agent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
        $options = array(
            CURLOPT_RETURNTRANSFER => true,   // return web page
            CURLOPT_HEADER         => false,  // don't return headers
            CURLOPT_FOLLOWLOCATION => true,   // follow redirects
            CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
            CURLOPT_ENCODING       => "",     // handle compressed
            CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
            CURLOPT_TIMEOUT        => 120,    // time-out on response
            CURLOPT_USERAGENT => $agent,
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content  = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
}
