<?php

namespace Mongo;

use MongoDB\Driver;
use MongoDB\Driver\BulkWrite;

class Query extends \Mongo\Connection {

	protected $database = false;
	private $params;
	private $queryOptions;

	public function __construct($db) {

		$this->database = $db;

		$this->initParams();

		$this->queryOptions = array('awaitDat', 'batchSize', 'exhaust', 'limit', 'modifiers', 'noCursorTimeout', 'oplogReplay', 'partial', 'projection', 'readConcern', 'skip', 'slaveOk', 'sort', 'tailable');
	}

	public function select($filter=array(), $connection=false) {
		$options = $this->buildOptions($filter);
		$query = $this->buildQuery($filter);

		$query = new \MongoDB\Driver\Query($query, $options);
		
		$result = array();
		$connection = $this->getConn($connection);

		$cursor = $connection->getConnection()->executeQuery($connection->getDB() . '.' . $this->params['collection'], $query);

		$this->initParams();

		return $cursor->toArray();
	}

	private function buildOptions($data) {
		$options = array();

		// sort example
		// 'sort' => array(
        //     'views' => -1,
    	// )

		foreach ($data as $key => $value) {
			
			if(in_array($key, $this->queryOptions))
				$options[$key] = $value;
		}

		return $options;
	}

	private function buildQuery($data) {
		$query = array();

		foreach ($data as $key => $value) {
			
			if(!in_array($key, $this->queryOptions))
				$query[$key] = $value;
		}

		return $query;
	}

	public function insert(array $insert, $connection=false) {
		$bulk = $this->getBulk($insert);
		
		$connection = $this->getConn($connection);

		$result = $this->execute($connection, $bulk);

		$this->initParams();

		return $result;
	}

	public function update(array $where, array $data, $connection=false) {
		$bulk = $this->getBulk($where, 'update', $data);
		
		$connection = $this->getConn($connection);

		$result = $this->execute($connection, $bulk);

		$this->initParams();

		return $result;
	}

	public function delete(array $where, $connection=false) {
		$bulk = $this->getBulk($where, 'delete');
		
		$connection = $this->getConn($connection);

		$result = $this->execute($connection, $bulk);

		$this->initParams();

		return $result;
	}

	public function collection($name, $connection) {

		$this->params['collection'] = $name;
		$this->params['connection'] = $connection;

		return $this;
	}

	private function initParams() {

		$this->params = array(
			'where' => false,
			'collection' => false,
			'connection' => false
		);
	}

	private function getConn($connection) {

		if($connection !== false)
			$this->params['connection'] = $connection;
		
		return $this->params['connection'];
	}

	private function execute($connection, $bulk) {
		$writeConcern = new \MongoDB\Driver\WriteConcern(\MongoDB\Driver\WriteConcern::MAJORITY, 1000);

		try {
			$connection->getConnection()->executeBulkWrite($connection->getDB() . '.' . $this->params['collection'], $bulk, $writeConcern);

		}catch(\MongoDB\Driver\Exception\BulkWriteException $e) {

			return false;
		} catch (\MongoDB\Driver\Exception\Exception $e) {

			return false;
		}

		return true;
	}

	private function isAssoc($array) {
    	return array_keys($array) !== range(0, count($array) - 1);
	}

	private Function getBulk($data, $type='insert', $args=false) {
		$bulk = new \MongoDB\Driver\BulkWrite(['ordered' => true]);

		switch($type) {
			case 'update':
				$options = array(
					'multi' => true,
					'upsert' => false
				);

				if(array_key_exists('upsert', $data)) {

					$options['upsert'] = $data['upsert'];
					unset($data['upsert']);
				}

				// data ... where
				// $args ... data

				$bulk->update(
					$data,
					array('$set' => $args),
					$options
				);

				break;
			
			default:
				$bulk->$type($data);
				break;
		}

		return $bulk;
	}
}