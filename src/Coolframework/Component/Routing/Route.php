<?php

namespace Coolframework\Component\Routing;

class Route
{
	private $name;
	private $associate_controller;
	private $associate_action;

	public function __construct($a_name, $an_associate_controller, $an_associate_action)
	{
		$this->name = $a_name;
		$this->associate_controller = $an_associate_controller;
		$this->associate_action = $an_associate_action;
	}

	public static function simpleRegister($a_name, $an_associate_controller)
	{
		return new self($a_name, $an_associate_controller, 'index');
	}

	public static function register($a_name, $an_associate_controller, $an_associate_action)
	{
		return new self($a_name, $an_associate_controller, $an_associate_action);
	}

	public function associateController()
	{
		return $this->associate_controller;
	}

	public function associateAction()
	{
		return $this->associate_action;
	}

}