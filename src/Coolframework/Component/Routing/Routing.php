<?php

namespace Coolframework\Component\Routing;

use Symfony\Component\Yaml\Parser;

class Routing
{
	public function __construct()
	{
	}

	public function setRoutingDirectory($routing_to_config_file)
	{
		if (!file_exists($routing_to_config_file))
		{
			throw new RoutingException();
		}
		$yaml = new Parser();
		$value = $yaml->parse( file_get_contents( $routing_to_config_file ));
	}
}