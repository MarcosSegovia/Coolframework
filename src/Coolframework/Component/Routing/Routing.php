<?php

namespace Coolframework\Component\Routing;

use Coolframework\Component\Request\Request;
use Coolframework\Component\Routing\Exception\RoutingException;
use Symfony\Component\Yaml\Parser;

class Routing
{
	private $routes;

	public function __construct(Parser $yml_parser, $path_to_config_file)
	{
		$this->routes = [];
		$this->setRoutingDirectory($yml_parser, $path_to_config_file);
	}

	private function setRoutingDirectory(
		Parser $yml_parser,
		$routing_to_config_file
	)
	{
		if (!file_exists($routing_to_config_file))
		{
			throw new RoutingException();
		}
		$routing_file_content = $yml_parser->parse(file_get_contents($routing_to_config_file));

		foreach ($routing_file_content as $key => $url)
		{
			if (array_key_exists(1, $url))
			{
				$this->routes[ $key ] = Route::register($key, $url[0], $url[1]);
			}
			else
			{
				$this->routes[ $key ] = Route::simpleRegister($key, $url[0]);
			}
		}
	}

	public function retrieveRoute(Request $a_request)
	{
		$controller_index_to_use = $a_request->urlParams(1);

		return $this->routes[ $controller_index_to_use ];
	}

}
