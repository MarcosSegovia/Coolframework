<?php

namespace Coolframework\Component\Bootstrap;

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

	public function execute($actual_url)
	{
		$controller_to_instantiate = $this->routing->getController($actual_url);
		$action_to_execute = $this->routing->getAction($actual_url);
		$current_controller = new $controller_to_instantiate();
		$current_controller->$action_to_execute();
	}
}