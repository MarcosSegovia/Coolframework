<?php

namespace Coolframework\Component\Request;

class Request
{
	private $server;
	private $session;
	private $cookies;
	private $get;
	private $post;

	public function __construct(
		$a_server_info,
		$a_session_info,
		$some_cookies_info,
		$a_get_info,
		$a_post_info
	)
	{
		$this->server = $a_server_info;
		$this->session = $a_session_info;
		$this->cookies = $some_cookies_info;
		$this->get = $a_get_info;
		$this->post = $a_post_info;
	}

	public static function create()
	{
		session_start();
		return new self($_SERVER, $_SESSION, $_COOKIE, $_GET, $_POST);
	}

	public function urlParams($index_from_array)
	{
		$url_in_array = explode("/", parse_url($this->server['REQUEST_URI'])['path']);
		if (array_key_exists($index_from_array, $url_in_array))
		{
			return $url_in_array[ $index_from_array ];
		}

		return 'index';
	}
}