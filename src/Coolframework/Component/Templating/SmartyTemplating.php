<?php

namespace Coolframework\Component\Templating;

use Smarty;

class SmartyTemplating implements Templating
{
	private $smarty;

	public function __construct()
	{
		$this->smarty = new Smarty();
		$this->smarty->setTemplateDir( ROOTPATH . '/web/smarty/templates');
		$this->smarty->setCompileDir(ROOTPATH . '/web/smarty/templates_c');
		$this->smarty->setCacheDir(ROOTPATH . '/web/smarty/cache');
	}

	public function render($template_to_render, $array_with_key_value = [])
	{
		foreach($array_with_key_value as $key => $value)
		{
			$this->smarty->assign($key, $value);
		}
		return $this->smarty->display($template_to_render);
	}
}