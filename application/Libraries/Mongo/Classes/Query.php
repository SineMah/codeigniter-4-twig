<?php

namespace Mongo;

class Query extends \Mongo\Connection {

	public function test($num, $letter) {
		var_dump($num, $letter);
		
		return 'yeah';
	}
}