<?php

namespace PayPro;

use PayPro\Error;

/**
 * Class Client
 *
 * @package PayPro
 */

class Client {
    private $apikey = null;
    private $command = null;
    private $params = array();

    function __construct($apikey) {
        $this->apikey = $apikey;
    }

    function execute() {
        $data_to_post = array(
            'apikey'  => $this->apikey,
            'command' => $this->command,
            'params'  => json_encode($this->params)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, PayPro::$apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post);
        curl_setopt($ch, CURLOPT_CAINFO, realpath(PayPro::$caBundleFile));

        $body = curl_exec($ch);

        if ($body === false) {
            $errno = curl_errno($ch);
            $message = curl_error($ch);

            curl_close($ch);

            $msg = "Could not connect to the PayPro API - [errno: $errno]: $message";
            throw new Error\Connection($msg);
        }

        $decodedResponse = json_decode($body, true); 

        if (is_null($decodedResponse)) {
            curl_close($ch);
            $msg = "The response is not valid: $body";
            throw new Error\InvalidResponse($msg);
        }
        
        $params = array();
        return $decodedResponse;
    }

    function setCommand($command) {
        $this->command = $command;
    }

    function setParam($param, $value) {
        $this->params[$param] = $value;
    }

    function setParams($params) {
        foreach($params as $param => $value) {
            $this->params[$param] = $value;
        }
    }
}
