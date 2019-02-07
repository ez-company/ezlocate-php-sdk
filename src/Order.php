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
		$this->entities = 0;

		if ($entities = Util::get('entities', $data)) {
			$this->entities = count($entities);
			foreach ($entities as $entity) {
				$this->_entities[] = new OrderEntity($entity);
			}
		}
    }

    public function getEntities() {
    	return $this->_entities;
    }
}