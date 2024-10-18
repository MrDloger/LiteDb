<?php
namespace App\Db;

class Table
{
	private bool $tableCreated = false;
	private ?Db $db;
	private array $columns = [];
	private ?string $primoryKey = null;
	public static function create(string $name, $func):static
	{
		$table = new static($name);
		$func($table);
		if ($table->tableCreated) {
			throw new \Exception("Table '{$table->name}' already exists", 1);
		}
		$query = "CREATE TABLE {$table->name} ({$table->prepareColumns()})";
		$table->db->executeQuery($query);
		$table->tableCreated = true;
		return $table;
	}
	public static function isTable($name):bool
	{
		return (bool) Db::getInstance()->executeQuery("SHOW TABLES FROM `" . Db::DB_NAME . "` like '{$name}';")->fetch();
	}
	public static function drop(string $name):void
	{
		Db::getInstance()->executeQuery("DROP TABLE {$name};");
	}
	public function __construct(protected string $name)
	{
		$this->db = Db::getInstance();
		$this->tableCreated = static::isTable($name);
	}
	private function prepareColumns():string
	{
		$str = implode(', ', $this->columns);
		if ($this->primoryKey) {
			$str .= ", PRIMARY KEY (`{$this->primoryKey}`)";
		}
		return $str;
	}
	public function addColumn(Type\Type $col):Type\Type
	{
		$col->setTable($this);
		$this->columns[] = $col;
		return $col;
	}
	public function setPrimoryKey(string $colName):void
	{
		$this->primoryKey = $colName;
	}
	public function deleteAI():void
	{
		if (count($this->columns) > 0) return;
		foreach ($this->columns as $key => $column) {
			$column->autoIncriment(false);
		}
	}
	public function rename(string $newName):void
	{
		if ($this->tableCreated) {
			$this->db->executeQuery("ALTER TABLE {$this->tableName} RENAME TO {$newName};");
		}
		$this->tableName = $newName;
	}
	public function renameColumn(string $oldName, string $newName):void
	{
		if ($this->tableCreated) {
			$this->db->executeQuery("ALTER TABLE {$this->tableName} RENAME COLUMN {$oldName} TO {$newName};");
		}
		$this->tableName = $newName;
	}
}