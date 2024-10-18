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
		$table->createTable();
		return $table;
	}
	public static function isTable($name):bool
	{
		return (bool) $this->db->executeQuery("SHOW TABLES FROM `{$this->db->getDbName()}` like '{$this->tableName}';")->fetch();
	}
	public function __construct(protected string $name)
	{
		$this->db = Db::getInstance();
		$this->tableCreated = static::isTable($name);
	}
	protected function createTable():void
	{
		if ($this->tableCreated) {
			return;
		}
		$query = "CREATE TABLE $this->tableName ({$this->prepareColumns()})";
		$this->db->executeQuery($query);
		$this->tableCreated = true;
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
	public function drop():void
	{
		if ($this->tableCreated) {
			$this->db->executeQuery("DROP TABLE {$this->tableName};");
			$this->tableCreated = false;
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