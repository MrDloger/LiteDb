<?
namespace App\Db;
class Db
{
	const DB_NAME = 'testAmo';
	protected static \PDO $pdo;
	protected \PDOStatement $stmt;
	private static ?Db $instance = null;
	
	private function __construct()
	{
		self::$pdo = new \PDO(
			"mysql:dbname=" . self::DB_NAME . ";host=MySQL-8.2", 
			'root',
			'',
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
			self::$instance = new Db();
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
		return self::DB_NAME;
	}
	public function getLastQuery()
	{
		return $this->stmt->queryString;
	}
}
