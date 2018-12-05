<?php

namespace EZLocate;

use \Curl\Curl;
use \Common\Util;

class EZLocate {

    const API_URL = 'https://ezlocate.app/api';

    private $_curl;

    public function __construct($usernname, $password) {
        $this->_curl = new Curl();
        $this->_curl->setBasicAuthentication($usernname, $password);
        $this->_curl->setHeader('Content-Type', 'application/json');
    }

    /**
     * Creates an order
     *
     * @param $data
     * The data required for an order
     *
     * @return Order
     *
     */
    public function createOrder($data) {
        $response = $this->_curl->post(self::API_URL.'/orders', $data);
        if ($this->_curl->error) {
            throw new ProtocolException($response, $this->_curl);
            return false;
        } else {
            return new Order($response);
        }
    }

    /**
     * Get a single order
     *
     * @param $id
     * The order id
     *
     * @return Order
     *
     */
    public function getOrder($id) {
        $response = $this->_curl->get(self::API_URL.'/orders/'.$id);
        if ($this->_curl->error) {
            throw new ProtocolException($response, $this->_curl);
            return false;
        } else {
            return new Order($response);
        }
    }
}