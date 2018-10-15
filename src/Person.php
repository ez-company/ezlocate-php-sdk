<?php

namespace EZLocate;
use \Common\Util;

class Person {
	public function __construct($data) {
		$this->id = Util::get('id', $data);
		$this->firstname = Util::get('firstname', $data);
		$this->lastname = Util::get('lastname', $data);
		$this->middlename = Util::get('middlename', $data);
		$this->dob = Util::get('dob', $data);
		$this->ssn = Util::get('ssn', $data);
		$this->phone = Util::get('phone', $data);
		$this->created_at = Util::get('created_at', $data);
    }
}