<?php

namespace Mongo;

use MongoDB\Driver;

class Query extends \Mongo\Connection {

	protected $database = false;
	private $params;

	public function __construct($db) {

		$this->database = $db;

		$this->initParams();
	}

	public function where() {

		return $this;
	}

	public function select() {
		$this->initParams();
	}

	public function insert() {
		$this->initParams();
	}

	public function update() {
		$this->initParams();
	}

	public function delete() {
		$this->initParams();
	}

	private function initParams() {

		$this->params = array(
			'where' => false
		);
	}
}