<?php
require_once('App\function.php');

$r = db()->executeQuery("SELECT * FROM ips")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lite Db</title>
</head>
<body>
	<pre>
		<?php 


		// $t = new App\Db\Table('testName2');
		// $t->addColumn(new App\Db\Type\IntegerType('id', table: $t))->notNull()->autoIncriment()->primoryKey();
		// $t->addColumn(new App\Db\Type\Varchar('test', 60, table: $t))->notNull()->default('testDef');
		//$t->create();
		// $t->drop();
		$t = App\Db\Table::create('table_name', function(App\Db\Table $table){
			$table->addColumn(new App\Db\Type\IntegerType('id'))->notNull()->autoIncriment()->primoryKey();
			$table->addColumn(new App\Db\Type\Varchar('test', 60))->notNull()->default('testDef');
			$table->addColumn(new App\Db\Type\Varchar('collumn_test', 120));
		});
		dv($t);

		?>
	</pre> 
</body>
</html>