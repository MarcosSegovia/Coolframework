<?php

namespace Coolframework\Component\Templating;

use Twig_Environment;

class TwigTemplating implements Templating
{
	private $twig;

	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
	}

	public function render($template_to_render, $array_with_key_value = [])
	{
		return $this->twig->render($template_to_render, $array_with_key_value);
	}
}
