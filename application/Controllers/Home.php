<?php 

namespace App\Controllers;

class Home extends \CodeIgniter\Controller
{
	public function index() {
		$data = array(
			'version' => \CodeIgniter\CodeIgniter::CI_VERSION,
		);

		// \Mongo\Client::instance()
		// 	->collection('test')
		// 	->insert(array('birds' => 'are blue'));

		// \Mongo\Client::instance()
		// 	->collection('test')
		// 	->delete(array('birds' => 'are red'));

		// \Mongo\Client::instance()
		// 	->collection('test')
		// 	->update(array('birds' => 'are black', 'upsert' => true), array('birds' => 'are green'));

		// \Mongo\Client::instance()
		// 	->collection('test')
		// 	->update(array('birds' => 'are yellow'), array('birds' => 'are black'));

		// $data = array(
		// 	'birds' => array(
		// 		'color' => 'black',
		// 		'size' => array(0, 1, 2, 2, 4, 5)
		// 	),
		// 	'spiders' => 'are eeeeeeeek'
		// );
		// \Mongo\Client::instance()
		// 	->collection('test')
		// 	->insert($data);

		// \Mongo\Client::instance()
		// 	->collection('test')
		// 	->select(array('birds' => 'are red'));


		// \Mongo\Client::instance()
		// 	->collection('test')
		// 	->select(array('birds.color' => 'black'));

		return \Twig::instance()->display('app.html', $data);
	}
}
