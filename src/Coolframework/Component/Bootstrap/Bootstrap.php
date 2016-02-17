<?php

namespace Coolframework\Component\Bootstrap;

use Coolframework\Component\Request\Request;
use Coolframework\Component\Routing\Route;
use Coolframework\Component\Routing\Routing;

class Bootstrap
{
	/** @var  Routing */
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
		/** @var Route $route */
		$route                     = $this->routing->retrieveRoute($a_request);
		$controller_to_instantiate = $route->associateController();
		$action_to_execute         = $route->associateAction();

		$current_controller = new $controller_to_instantiate();

		return $current_controller->$action_to_execute();
	}
}