<?php

namespace Mongo;

class Connection {

	protected $db = false;
	protected $collection = false;

	public function setDb($name) {
		
		$this->db = $name;
	}

	public function setCollection($name) {
		
		$this->collection = $name;
	}

	public function getDb() {
		
		return $this->db;
	}

	public function getCollection() {
		
		return $this->collection;
	}
}