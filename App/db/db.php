<?
namespace App\Db;
class Db
{
	const DB_NAME = 'testAmo';
	protected static \PDO $pdo;
	protected \PDOStatement $stmt;
	private static ?Db $instance = null;
	
	private function __construct(protected string $type, protected string $dbName, protected string $host, protected string $user, protected string $pass)
	{
		self::$pdo = new \PDO(
			"{$type}:dbname={$dbName};host={$host}", 
			$user,
			$pass,
			[
				\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    			\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb4'",
    			\PDO::ATTR_EMULATE_PREPARES => false
			]
		);
	}
	private function __clone(){
		return self::$instance; 
	}
	public static function getInstance():static
	{
		if (self::$instance === null){
			$conf = \App\Util\Registry::getInstance()->config?->get('database');
			self::$instance = new Db($conf['type'], $conf['name'], $conf['host'], $conf['user'], $conf['pass']);
		}
		return self::$instance;
	}
	public function executeQuery(string $query, array $values = null):\PDOStatement
	{
		$this->stmt = self::$pdo->prepare($query);
		$this->stmt->execute($values ?? null);
		return $this->stmt;
	}
	public function getDbName():string
	{
		return $this->dbName;
	}
	public function getLastQuery():?string
	{
		return $this->stmt->queryString;
	}
}
