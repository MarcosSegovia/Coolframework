<?php

namespace Coolframework\Component\Templating;

use Twig_Environment;
use Twig_Loader_Filesystem;

class TwigTemplating implements Templating
{
	private $twig;

	public function __construct()
	{
		$loader = new Twig_Loader_Filesystem(ROOTPATH . '/web/twig/templates');
		$this->twig = new Twig_Environment($loader, array(
			'cache' => ROOTPATH . './web/twig/cache',
		));
	}

	public function render($template_to_render, $array_with_key_value = [])
	{
		return $this->twig->render($template_to_render, $array_with_key_value);
	}
}