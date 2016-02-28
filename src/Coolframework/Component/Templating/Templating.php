<?php

namespace Coolframework\Component\Templating;

interface Templating
{
	public function render($template_to_render, $array_with_key_value);
	public function assign($variable_to_assign, $value_to_assign);
}
