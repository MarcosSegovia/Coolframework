<?php

namespace Coolframework\Component\Bootstrap;

use Coolframework\Component\Injector\CoolContainer;
use Coolframework\Component\Request\Request;
use Coolframework\Component\Routing\Route;
use Coolframework\Component\Routing\Routing;

class Bootstrap
{
	private $routing;
	private $container;

	public function __construct(Routing $routing)
	{
		$this->routing = $routing;
	}

	public function setContainer(CoolContainer $container)
	{
		$this->container = $container;
	}

	public function configRouting($yml_parser, $routing_to_config_file)
	{
		$this->routing->setRoutingDirectory($yml_parser, $routing_to_config_file);
	}

	public function execute(Request $a_request)
	{
		$route                     = $this->routing->retrieveRoute($a_request);
		$controller_to_instantiate = $route->associateController();
		$action_to_execute         = $route->associateAction();

		$current_controller = new $controller_to_instantiate($this->container);

		return $current_controller->$action_to_execute();
	}
}