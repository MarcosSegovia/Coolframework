<?php

namespace Coolframework\Component\Templating;

interface Templating
{
	public function render($template_to_render, $array_with_key_value);
}
