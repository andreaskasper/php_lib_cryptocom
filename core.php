<?php

/*
 * Core Functions to request at crypto.com API v2
 */

namespace cryptocom;

class core {

    private static $_appkey = null;
    private static $_secret = null;
    private static $_sandbox = false;

    public static function setAPIToken($appkey,$secret) {
        self::$_appkey = $appkey;
        self::$_secret = $secret;
    }


    public static function request(string $method, Array $params, bool $signed = null) : Array{

        if (self::$_sandbox) $urlroot = "https://uat-api.3ona.co/v2/";
        else $urlroot = "https://api.crypto.com/v2/";

        if (is_null($signed) OR !$signed) {
            $str = file_get_contents($urlroot.$method."?".http_build_query($params));
            return json_decode($str, true);
        } else {
            if (is_null(self::$_appkey)) throw new \Exception("Missing App Key");
            if (is_null(self::$_secret)) throw new \Exception("Missing App Secret");

            $w = array();
            $w["id"] = rand(0,9999999);
            $w["method"] = $method;
            $b = "";
            if (empty($params)) $w["params"] = new \stdClass; 
            else {
                $w["params"] = $params;
                ksort($params);
                foreach ($params as $k => $v) $b .= $k.$v;
            }
            $w["api_key"] = self::$_appkey;
            $w["nonce"] = time()*1000;
          
            $presig = $w["method"].$w["id"].$w["api_key"].$b.$w["nonce"];
            $w["sig"] = hash_hmac("sha256", $presig, self::$_secret); 
    
            /*print_r($params);
            echo($b.PHP_EOL);
            echo($presig.PHP_EOL);*/
    
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlroot.$w["method"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($w));
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    
            //curl_setopt($ch, CURLOPT_VERBOSE, true);
            $resp = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
    
            $resp2 = json_decode($resp, true);
            if ($resp2["code"] == 10002) {
                print_r($params);
                echo($b.PHP_EOL);
                echo($presig.PHP_EOL);
                print_r($resp2);
                throw new \Exception("Error");
            }
    
            $resp2 = json_decode($resp, true);
            if ($resp2["code"] == 10004) { //BAD_REQUEST
                print_r($params);
                echo($b.PHP_EOL);
                echo($presig.PHP_EOL);
                print_r($resp2);
                throw new \Exception("Bad Request");
            }
            return $resp2;
        }
    }
}
