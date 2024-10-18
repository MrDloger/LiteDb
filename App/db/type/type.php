<?php

namespace App\Db\Type;
use \App\Db\Table;
abstract class Type 
{
	protected bool $notNull = false;
	protected bool $autoIncriment = false;
	protected ?string $default = null;
	protected ?Table $table = null;
	public function __construct(
		protected string $name,
		protected int|float $lenght = 0,
	)
	{

	}
	public function setTable(Table $table):void
	{
		$this->table = $table;
	}
	public function notNull(bool $var = true):static
	{
		$this->notNull = $var;
		return $this;
	}
	public function setLenght(int|float $var):static
	{
		$this->lenght = $var;
		return $this;
	}
	protected function getLenght():string
	{
		return $this->lenght ? "(" . $this->lenght . ")" : "";
	}
	public function autoIncriment($var = true):static
	{
		$this->autoIncriment = $var;
		$this->notNull = true;
		$this->table->deleteAI();
		$this->primoryKey();
		return $this;
	}
	final public function __toString():string
	{
		$colum = "`$this->name` " . static::TYPE . $this->getLenght();
		$colum .= $this->notNull ? " NOT NULL" : " NULL";
		$colum .= $this->default ? " DEFAULT '{$this->default}'" : "";
		$colum .= $this->autoIncriment ? " AUTO_INCREMENT" : "";
		return $colum;
	}
	public function primoryKey():static
	{
		$this->table->setPrimoryKey($this->name);
		return $this;
	}
	public function default(string $var):static
	{
		$this->default = $var;
		return $this;
	}
}