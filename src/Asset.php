<?php

namespace EZLocate;
use \Common\Util;

class Asset {
	public function __construct($data) {
		$this->id = Util::get('id', $data);
		$this->client_ref = Util::get('client_ref', $data);
		$this->name = Util::get('name', $data);
		$this->notes = Util::get('notes', $data);
    }
}