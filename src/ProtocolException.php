<?php

namespace EZLocate;

class ProtocolException extends \Exception {

    public function __construct($response, $curl) {
    	$message = is_object($response) ? $response->message : $response;
        $message = 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage.'. Message: '.($message ? : 'Unknown error');
        parent::__construct($message);
    }
}