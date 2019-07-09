<?php

namespace EZLocate;
use \Common\Util;

class Batch {

    public function __construct($data) {
        $this->id = Util::get('id', $data);
        $this->processed = Util::get('processed', $data);
        $this->exceptions = Util::get('exceptions', $data);
        $this->filename = Util::get('filename', $data);
        $this->mapping = Util::get('mapping', $data);
        $this->completed_at = Util::get('completed_at', $data);
        $this->created_at = Util::get('created_at', $data);
    }

    public function isCompleted() {
        return $this->completed_at ? true : false;
    }

    public function getItems($params = [], $page = 1, &$next_page = null) {
        $response = EZLocate::$curl->get(EZLocate::$api_url.'/orders/batches/'.$this->id.'/items?page='.$page, $params);
        if (EZLocate::$curl->error) {
            throw new ProtocolException($response, EZLocate::$curl);
        } else {
            $items = [];
            foreach ($response as $item_data) {
                $items[] = new Order($item_data);
            }

            $next_page = Pagination::nextPage();

            return $items;
        }
    }
}