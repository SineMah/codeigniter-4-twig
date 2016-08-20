<?php

class Twig {
	protected $templateDir;
	protected $cacheDir;
	private $_twigEnv;
	private static $_instance = false;

	public function __construct($templateDir, $cacheDir, $twigEnv) {

		$this->templateDir = $templateDir;
		$this->cacheDir = $cacheDir;
		$this->_twigEnv = $twigEnv;
	}

	public static function instance() {

		if(self::$_instance !== false)
			return self::$_instance;

		$config = false;
		$file = APPPATH . 'Config' . DIRECTORY_SEPARATOR . 'twig.json';

		try {

			$config = file_get_contents($file);
		}catch(\Exception $e) {

			throw new Exception('No config');
			
		}catch(\Error $e) {

			throw new Exception('No config');
		}

		$config = json_decode($config);

		if(is_null($config))
			throw new Exception('No valid json');


		$templateDir = APPPATH . $config->template_dir;
		$cacheDir = APPPATH . $config->cache_dir;

		require_once APPPATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

		// $loader = new Twig_Loader_Array(array(
		// 	'index' => 'Hello {{ name }}!',
		// ));

		$loader = new Twig_Loader_Filesystem($templateDir, $cacheDir);

		$twigEnv = new Twig_Environment($loader, array(
			'cache' => $cacheDir,
			'auto_reload' => true)
		);

		self::$_instance = new \Twig($templateDir, $cacheDir, $twigEnv);

		return self::$_instance;
	}

	/**
	 * render a twig template file
	 * 
	 * @param string  $template template name
	 * @param array   $data	    contains all varnames
	 * @param boolean $render   render or return raw?
	 *
	 * @return void
	 * 
	 */
	public function render($template, $data = array(), $render = true) {
		$template = $this->_twig_env->loadTemplate($template);

		return ($render) ? $template->render($data) : $template;
	}

	/**
	 * Execute the template and send to CI output
	 * 
	 * @param string $template Name of template
	 * @param array  $data     Parameters for template
	 * 
	 * @return void
	 * 
	 */
	public function display($template, $data = array()) {
		$template = $this->_twigEnv->loadTemplate($template);

		return $template->render($data);
	}
}