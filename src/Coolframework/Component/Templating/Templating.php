<?php

namespace Coolframework\Component\Templating;

use Smarty;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Templating
{
	private $template_engine;

	public function __construct($name_of_template_engine)
	{
		if ('smarty' === $name_of_template_engine)
		{
			$this->template_engine = $this->configSmartyTemplateEngine();
		}
		else
		{
			$this->template_engine = $this->configTwigTemplateEngine();
		}
	}

	private function configSmartyTemplateEngine()
	{
		$smarty = new Smarty();

		$smarty->setTemplateDir('/web/www.example.com/smarty/templates');
		$smarty->setCompileDir('/web/www.example.com/smarty/templates_c');
		$smarty->setCacheDir('/web/www.example.com/smarty/cache');

		return $smarty;
	}

	private function configTwigTemplateEngine()
	{
		$loader = new Twig_Loader_Filesystem('/path/to/templates');
		$twig = new Twig_Environment($loader, array(
			'cache' => '/path/to/compilation_cache',
		));

		return $twig;
	}

}
