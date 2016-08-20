<?php

namespace Mongo;

class Connection {

	protected $db = false;
	protected $database = false;
	protected $collection = false;

	public function __construct($db) {

		$this->database = $db;
	}

	public function setDb($name) {
		
		$this->database = $name;
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