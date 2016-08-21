<?php

namespace Mongo;

class Connection {

	protected $dbName = false;
	protected $database = false;
	protected $collection = false;

	public function __construct($db) {

		$this->database = $db;
	}

	public function setDb($name) {
		
		$this->dbName = $name;
	}

	public function setCollection($name) {
		
		$this->collection = $name;
	}

	public function getDb() {
		
		return $this->dbName;
	}

	public function getConnection() {
		
		return $this->database;
	}

	public function getCollection() {
		
		return $this->collection;
	}
}