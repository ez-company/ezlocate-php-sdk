<?php

namespace EZLocate;
use \Common\Util;

class Address {
	public function __construct($data) {
		$this->id = Util::get('id', $data);
		$this->street_1 = Util::get('street_1', $data);
		$this->street_2 = Util::get('street_2', $data);
		$this->city = Util::get('city', $data);
		$this->state = Util::get('state', $data);
		$this->zip = Util::get('zip', $data);
		$this->created_at = Util::get('created_at', $data);
    }
}