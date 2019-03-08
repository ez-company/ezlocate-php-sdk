<?php

namespace EZLocate;
use \Common\Util;

class Order {

    private $_entities = [];

    public function __construct($data) {
        $this->id = Util::get('id', $data);
        $this->ref = Util::get('ref', $data);
        $this->ref_2 = Util::get('ref_2', $data);
        $this->notes = Util::get('notes', $data);
        $this->created_at = Util::get('created_at', $data);
        $this->completed_at = Util::get('completed_at', $data);

        if ($entities = Util::get('entities', $data)) {
            foreach ($entities as $entity) {
                $this->_entities[] = new OrderEntity($entity);
            }
        }
    }

    public function getEntities() {
        return $this->_entities;
    }

    /**
     * Get address order entity
     *
     * @param $id
     * @return object
     *
     */
    public function getAddressEntity($id) {
        $response = EZLocate::$curl->get(EZLocate::$api_url.'/orders/'.$this->id.'/entities/address/'.$id);
        if (EZLocate::$curl->error) {
            throw new ProtocolException($response, EZLocate::$curl);
        } else {
            return new OrderEntity($response);
        }
    }

    /**
     * Get person order entity
     *
     * @param $id
     * @return object
     *
     */
    public function getPersonEntity($id) {
        $response = EZLocate::$curl->get(EZLocate::$api_url.'/orders/'.$this->id.'/entities/person/'.$id);
        if (EZLocate::$curl->error) {
            throw new ProtocolException($response, EZLocate::$curl);
        } else {
            return new OrderEntity($response);
        }
    }
}