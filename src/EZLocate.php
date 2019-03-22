<?php

namespace EZLocate;

use \Curl\Curl;
use \Common\Util;

class EZLocate {

    public static $curl;
    public static $api_url;

    public function __construct($usernname, $password, $url = 'https://ezlocate.app/api') {
        self::$api_url = $url;

        self::$curl = new Curl();
        self::$curl->setBasicAuthentication($usernname, $password);
        self::$curl->setHeader('Content-Type', 'application/json');
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
        $response = self::$curl->post(self::$api_url.'/orders', $data);
        if (self::$curl->error) {
            throw new ProtocolException($response, self::$curl);
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
        $response = self::$curl->get(self::$api_url.'/orders/'.$id);
        if (self::$curl->error) {
            throw new ProtocolException($response, self::$curl);
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
    public function getOrders($params = [], $page = 1) {
        $response = self::$curl->get(self::$api_url.'/orders?page='.$page, $params);
        if (self::$curl->error) {
            throw new ProtocolException($response, self::$curl);
        } else {
            $orders = [];
            foreach ($response as $order_data) {
                $orders[] = new Order($order_data);
            }

            return $orders;
        }
    }

    public function orders($id) {
        $order = new Order(['id' => $id]);
        return $order;
    }
}