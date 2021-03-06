<?php

namespace Coolframework\Component\Injector;

use Coolframework\Component\Injector\Exception\ServiceNotAvailableToPublicAccessException;
use Coolframework\Component\Injector\Exception\ServiceNotFoundException;
use ReflectionClass;
use Symfony\Component\Yaml\Parser;

class CoolContainer
{
	private $container;
	private $service_store;
	private $service_settings;

	public function __construct(
		Parser $yml_parser,
		$path_to_services_config_file,
		$current_environment = 'DEV'
	)
	{
		$this->container     = [];
		$this->service_store = [];
		$this->service_settings = [];

		$production_service_definitions = $yml_parser->parse(file_get_contents($path_to_services_config_file . '/services.yml'));

		foreach ($production_service_definitions as $service => $content)
		{
			if (array_key_exists($service, $this->container))
			{
				continue;
			}

			$this->container[ $service ] = $content;
			$this->service_settings[$service]['public'] = $content['public'];

			if(isset($content['tags']))
			{
				foreach($content['tags'] as $tag)
				{
					$this->service_settings[$service]['tags'][] = $tag;
				}
			}
		}

		if($current_environment === 'DEV')
		{
			$development_service_definitions = $yml_parser->parse(file_get_contents($path_to_services_config_file . '/services_dev.yml'));
			foreach($development_service_definitions as $service => $content)
			{
				if (array_key_exists($service, $this->container))
				{
					continue;
				}
				$this->container[ $service ] = $content;
				$this->service_settings[$service]['public'] = $content['public'];

				if(isset($content['tags']))
				{
					foreach($content['tags'] as $tag)
					{
						$this->service_settings[$service]['tags'][] = $tag;
					}
				}
			}

		}

	}

	public function getService($a_name_of_the_service)
	{
		if (!array_key_exists($a_name_of_the_service, $this->container))
		{
			throw new ServiceNotFoundException('Service not found: ' . $a_name_of_the_service);
		}

		$this->service_store[ $a_name_of_the_service ] = $this->createService($this->container[ $a_name_of_the_service ]
		);

		if(!$this->service_settings[$a_name_of_the_service]['public'])
		{
			throw new ServiceNotAvailableToPublicAccessException('The Service cannot be provided por public access.');
		}
		
		return $this->service_store[ $a_name_of_the_service ];
	}

	private function createService($service_schema)
	{
		if (isset( $service_schema['arguments'] ))
		{
			$services_arguments = [];
			foreach ($service_schema['arguments'] as $argument)
			{
				$first_character = substr($argument, 0, 1);

				if ('@' === $first_character)
				{
					$service_to_ask       = str_replace("@", "", $argument);
					$services_arguments[] = $this->createService($this->container[ $service_to_ask ]);
				}
				else
				{
					$first_character = substr($argument, 0, 1);
					if ('[' === $first_character)
					{
						$multiple_statements = str_replace("[", "", $argument);
						$multiple_statements = str_replace("]", "", $multiple_statements);
						$multiple_statements = str_replace("'", "", $multiple_statements);
						$multiple_statements = str_replace(" ", "", $multiple_statements);
						$multiple_statements = explode(",", $multiple_statements);
						$argument            = [];

						foreach ($multiple_statements as $single_statement)
						{
							$array_with_key_value = explode("=>", $single_statement);

							$argument[ $array_with_key_value[0] ] = $array_with_key_value[1];
						}
					}
					$services_arguments[] = $argument;
				}

			}

			$reflector = new ReflectionClass($service_schema['class']);

			return $reflector->newInstanceArgs($services_arguments);
		}

		return new $service_schema['class']();
	}
}
