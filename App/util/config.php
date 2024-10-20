<?php
namespace App\Util;

class Config
{
	private static ?Config $instance = null;
	private ?array $config = null;
	private function __construct()
	{
		$file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "conf.json");
		$this->config = json_decode($file, true);
	}
	public static function getInstance():static
	{
		if (static::$instance === null) {
			static::$instance = new static();
		}
		return static::$instance;
	}
	public function __clone()
	{
		return static::getInstance();
	}
	public function get(string $name):mixed
	{
		return $this->config[$name];
	}
	public function set(string $name, mixed $val):void
	{
		$this->config[$name] = $val;
	}
}