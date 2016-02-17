<?php

namespace Coolframework\Component\Request;

class Request
{
	private $full_raw_url;

	public function __construct($a_full_raw_url)
	{
		$this->full_raw_url = $a_full_raw_url;
	}

	public static function create()
	{
		return new self($_SERVER['REQUEST_URI']);
	}

	public function fullRawUrl()
	{
		return $this->full_raw_url;
	}

	public function params($index_from_array)
	{
		$url_in_array = explode("/", parse_url($this->full_raw_url)['path']);
		if (array_key_exists($index_from_array, $url_in_array))
		{
			return $url_in_array[ $index_from_array ];
		}

		return 'index';
	}
}