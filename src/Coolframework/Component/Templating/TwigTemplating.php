<?php

namespace Coolframework\Component\Templating;

use Twig_Environment;

class TwigTemplating implements Templating
{
	private $twig;
	private $variables_to_use;

	public function __construct(Twig_Environment $twig)
	{
		$this->twig = $twig;
		$this->variables_to_use = [];
	}

	public function render($template_to_render, $array_with_key_value = [])
	{
		foreach($this->variables_to_use as $a_key => $a_variable)
		{
			$array_with_key_value[$a_key] = $a_variable;
		}

		return $this->twig->render($template_to_render, $array_with_key_value);
	}

	public function assign(
		$variable_to_assign,
		$value_to_assign
	)
	{
		$this->variables_to_use[$variable_to_assign] = $value_to_assign;
	}
}
