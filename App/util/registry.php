<?php
namespace App\Util;

class Registry
{
	private static ?Registry $instance = null;
	private array $storage = [];
	private function __construct()
	{

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
	public function set(string $name, string $class):void
	{
		
		if (empty($this->storage[$name])) {
			$rc = new \ReflectionClass($class);
			$method = $rc->getMethod('getInstance');
			if ($method) {
				$this->storage[$name] = $class::getInstance();
			} else {
				$this->storage[$name] = new $class();
			}
		}
	}
	public function get(string $name):mixed
	{
		if (isset($this->storage[$name])) {
			return $this->storage[$name];
		}
		return null;
	}
	public function __get($name):mixed
	{
		return $this->get($name);
	}
}