<?php

namespace EZLocate;
use \Common\Util;

class OrderEntity {
	const ENTITY_TYPE_ADDRESS = 'address';
	const ENTITY_TYPE_PERSON = 'person';
	const ENTITY_TYPE_ASSET = 'asset';

	public function __construct($data) {
		$this->id = Util::get('id', $data);
		$this->type = Util::get('type', $data);
		$this->properties = Util::get('properties', $data);
		$this->addons = Util::get('addons', $data);
    }

    public function get_entity() {
    	switch ($this->type) {
			case self::ENTITY_TYPE_ADDRESS:
				return new Address($this);
				break;
			case self::ENTITY_TYPE_PERSON:
				return new Person($this);
				break;
			case self::ENTITY_TYPE_ASSET:
				return new Asset($this);
				break;
		}
    }
}