<?php 

namespace App\Controllers;

class Home extends \CodeIgniter\Controller
{
	public function index() {
		$data = array(
			'version' => \CodeIgniter\CodeIgniter::CI_VERSION,
		);

		\Mongo\Client::instance()->setDb('sine');

		return \Twig::instance()->display('app.html', $data);
	}
}
