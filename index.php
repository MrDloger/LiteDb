<?php
require_once('App\function.php');
$tableName = 'table_name_2';
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
		// if (App\Db\Table::isTable($tableName)) {
		// 	App\Db\Table::drop($tableName);
		// }
		// $t = App\Db\Table::create($tableName, function(App\Db\Table $table){
		// 	$table->addColumn(new App\Db\Type\IntegerType('id'))->notNull()->autoIncriment()->primoryKey();
		// 	$table->addColumn(new App\Db\Type\Varchar('test', 60))->notNull()->default('testDef');
		// 	$table->addColumn(new App\Db\Type\Varchar('collumn_test', 120));
		// });
		// d(db()->getLastQuery());
		// dv($t);
		$c = App\Util\Config::getInstance();
		?>
	</pre> 
</body>
</html>