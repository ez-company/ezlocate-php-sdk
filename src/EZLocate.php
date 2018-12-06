<?php

namespace EZLocate;

use \Curl\Curl;
use \Common\Util;

class EZLocate {

    private $_curl;
    private $_api_url;

    public function __construct($usernname, $password, $url = 'https://ezlocate.app/api') {
        $this->_api_url = $url;

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
        $response = $this->_curl->post($this->_api_url.'/orders', $data);
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
        $response = $this->_curl->get($this->_api_url.'/orders/'.$id);
        if ($this->_curl->error) {
            throw new ProtocolException($response, $this->_curl);
            return false;
        } else {
            return new Order($response);
        }
    }

    /**
     * Get orders
     *
     * @return array
     *
     */
    public function getOrders() {
        $response = $this->_curl->get($this->_api_url.'/orders/'.$id);
        if ($this->_curl->error) {
            throw new ProtocolException($response, $this->_curl);
            return false;
        } else {
            $orders = [];
            foreach ($response as $order_data) {
                $orders[] = new Order($order_data);
            }

            return $orders;
        }
    }
}