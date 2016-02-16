<?php

namespace Coolframework\Component\Routing;

use Symfony\Component\Yaml\Parser;

class Routing
{
	private $routes;

	public function __construct()
	{
		$this->routes = [];
	}

	public function setRoutingDirectory($routing_to_config_file)
	{
		if (!file_exists($routing_to_config_file))
		{
			throw new RoutingException();
		}
		$yaml_parser  = new Parser();
		$routing_file_content = $yaml_parser->parse(file_get_contents($routing_to_config_file));

		foreach ($routing_file_content as $key => $url)
		{
			$this->routes[$key] = Route::register($key, $url[0], $url[1]);
		}
	}

	public function getController($index)
	{
		return $this->routes[$index]->associateController();
	}

	public function getAction($index)
	{
		return $this->routes[$index]->associateAction();
	}
}