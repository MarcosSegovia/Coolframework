<?php

namespace Coolframework\Component\Bootstrap;

use Coolframework\Component\Request\Request;
use Coolframework\Component\Routing\Routing;

class Bootstrap
{
	private $routing;

	public function __construct()
	{
	}

	public function configRouting($routing_to_config_file)
	{
		$this->routing = new Routing();
		$this->routing->setRoutingDirectory($routing_to_config_file);
	}

	public function execute(Request $a_request)
	{

		$controller_to_use = $a_request->params(1);
		$action_to_execute = $a_request->params(2);

		$controller_to_instantiate = $this->routing->getController($controller_to_use);
		$current_controller        = new $controller_to_instantiate();
		return $current_controller->$action_to_execute();
	}
}