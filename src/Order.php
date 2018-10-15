<?php

namespace EZLocate;
use \Common\Util;

class Order {
	const ENTITY_TYPE_ADDRESS = 'address';
	const ENTITY_TYPE_PERSON = 'person';
	const ENTITY_TYPE_ASSET = 'asset';

	private $_people = [];
	private $_addresses = [];
	private $_assets = [];

	public function __construct($data) {
		$this->id = Util::get('id', $data);
		$this->notes = Util::get('notes', $data);
		$this->created_at = Util::get('created_at', $data);
		$this->completed_at = Util::get('completed_at', $data);

		if ($entities = Util::get('entities', $data)) {
			foreach ($entities as $entity) {
				switch ($entity->type) {
					case self::ENTITY_TYPE_ADDRESS:
						$this->_addresses[] = new Address($entity);
						break;
					case self::ENTITY_TYPE_PERSON:
						$this->_people[] = new Person($entity);
						break;
					case self::ENTITY_TYPE_ASSET:
						$this->_assets[] = new Asset($entity);
						break;
				}
			}
		}
    }

    public function getPeople() {
    	return $this->_people;
    }

    public function getAddresses() {
    	return $this->_addresses;
    }

    public function getAssets() {
    	return $this->_assets;
    }
}