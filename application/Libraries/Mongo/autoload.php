<?php

namespace Mongo;

class Autoload {

	private $_classes;
	private $_loaded;
	private $_instances;

	public function __construct() {
		$this->loaded = array();
		$this->instances = array();
		$this->classes = array(
			'Connection',
			'Query'
		);
	}

	public function init($db) {

		foreach ($this->classes as $class) {
			$file = __DIR__ . DIRECTORY_SEPARATOR . 'Classes' . DIRECTORY_SEPARATOR . $class . '.php';

			if(file_exists($file) && array_key_exists($class, $this->loaded) === false) {

				$this->loaded[$class] = get_class_methods('\\' . $class);

				require_once($file);

				$classname = 'Mongo\\' . $class;

				$this->instances[$class] = new $classname($db);

				$this->loaded[$class] = get_class_methods($this->instances[$class]);
			}
		}

		return $this->instances;
	}

	public function findClass($funcName) {

		foreach($this->loaded as $class => $funcs) {
			
			if(in_array($funcName, $funcs))
				return $class;
		}

		return false;
	}

	public function execute($class, $func, $args) {

		if(!is_array($args))
			$args = array($args);

		return call_user_func_array(array($this->instances[$class], $func), $args);
	}
}