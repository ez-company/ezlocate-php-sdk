<?php

namespace EZLocate;

use \Curl\Curl;
use \Common\Util;

class EZLocate {
    const VERSION = '0.2.4';
    const PRODUCT_ADDRESS_CLEANSING = 'address-cleansing';
    const PRODUCT_PEOPLE_FINDING = 'people-finding';
    const PRODUCT_ASSET_LOCATION = 'asset-location';

    const SERVICE_ADDRESS_VERIFICATION = 1;

    public static $curl;
    public static $api_url;

    public function __construct($usernname, $password, $url = 'https://ezlocate.app/api') {
        self::$api_url = $url;

        self::$curl = new Curl();
        self::$curl->setBasicAuthentication($usernname, $password);
        self::$curl->setHeader('Content-Type', 'application/json');
        self::$curl->setUserAgent('EZLocate-PHP/'.self::VERSION.' (https://github.com/ez-company/ezlocate-php-sdk) PHP/'.PHP_VERSION.' Curl/'.curl_version()['version']);
        self::$curl->setTimeout(300); // 5m
    }

    /**
     * Create a batch
     *
     * @param @file source file
     * @param $mapping field mapping data
     *
     * @return Batch
     *
     */
    public function createBatch($file, $product = self::PRODUCT_ADDRESS_CLEANSING, $service = self::SERVICE_ADDRESS_VERIFICATION, $mapping = null) {
        self::$curl->setHeader('Content-Type', 'multipart/form-data');

        $data = [
            'file' => new \CURLFile($file),
            'mapping' => $mapping,
            'product' => $product
        ];

        switch ($product) {
            case self::PRODUCT_ADDRESS_CLEANSING:
                $data['addons'] = is_array($service) ? $service : [$service];
                break;
            case self::PRODUCT_PEOPLE_FINDING:
                $data['method'] = $service;
                break;
        }

        $response = self::$curl->post(self::$api_url.'/orders/batches', $data);

        if (self::$curl->error) {
            throw new ProtocolException($response, self::$curl);
        } else {
            return new Batch($response);
        }
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
    public function getOrders($params = [], $page = 1, &$next_page = null) {
        $response = self::$curl->get(self::$api_url.'/orders?page='.$page, $params);
        if (self::$curl->error) {
            throw new ProtocolException($response, self::$curl);
        } else {
            $orders = [];
            foreach ($response as $order_data) {
                $orders[] = new Order($order_data);
            }

            $next_page = Pagination::nextPage();

            return $orders;
        }
    }

    public function orders($id) {
        $order = new Order(['id' => $id]);
        return $order;
    }

    /**
     * Get batches
     *
     * @return array
     *
     */
    public function getBatches($params = [], $page = 1, &$next_page = null) {
        $response = self::$curl->get(self::$api_url.'/orders/batches?page='.$page, $params);
        if (self::$curl->error) {
            throw new ProtocolException($response, self::$curl);
        } else {
            $batches = [];
            foreach ($response as $batch_data) {
                $batches[] = new Batch($batch_data);
            }

            $next_page = Pagination::nextPage();

            return $batches;
        }
    }

    /**
     * Get batch information
     *
     * @return Batch
     *
     */
    public function getBatch($id) {
        $response = self::$curl->get(self::$api_url.'/orders/batches/'.$id);
        if (self::$curl->error) {
            throw new ProtocolException($response, self::$curl);
        } else {
            return new Batch($response);
        }
    }
}