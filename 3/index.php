<?php

require_once('function.php');
$db = db();

$today = date('Y-m-d');

$visitsDb = $db->select('visits', '*', 'created > ?', [$today])->fetchAll();
$ids = [];
foreach ($visitsDb as $key => $value) {
	
}
$visits = [];
for ($i=0; $i < 24; $i++) { 
	if ($i < 10) {
		$visits["0{$i}.00"] = 0;
	} else {
		$visits["{$i}.00"] = 0;
	}
}

foreach ($visitsDb as $value) {
	if (!in_array($value['ip'], $ids)) {
		++$visits[date("H.00", strtotime($value['created']))];
		$ids[] = (int) $value['ip'];
	}
		
}
foreach ($visits as $key => $value) {
	$dataChartVisits[] = [$key ,$value];
}

$cityDb = $db->query('SELECT * FROM ips WHERE id IN (' . implode(', ', $ids) . ')')->fetchAll();
$city= [];
foreach ($cityDb as $value) {
	if (in_array($value['city'], $city)) {
		++$city[$value['city']];
	} else {
		$city[$value['city']] = 1;
	}
}
foreach ($city as $key => $value) {
	$dataChartCity[] = ['x' => $key, 'value' => $value];
}

?> 
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/3/ressources/css/style.css">
	<script src="/3/ressources/js/count.js"></script>
	<title>Document</title>
</head>
<body>
	<div class="container">
		<div class="form_auth_block">
	<div class="form_auth_block_content">
		<p class="form_auth_block_head_text">Авторизация</p>
		<form class="form_auth_style" action="#" method="post">
			<label>Введите Ваш имейл</label>
			<input type="email" name="auth_email" placeholder="Введите Ваш имейл" required >
			<label>Введите Ваш пароль</label>
			<input type="password" name="auth_pass" placeholder="Введите пароль" required >
			<button class="form_auth_button" type="submit" name="form_auth_submit">Войти</button>
		</form>
	</div>
	</div>
	</div>
	<div class="container">
		<h3>Количество уникальных пользователей за последний день</h3>
	</div>
	<div id="containerVizits" style="width: 920px; height: 400px; margin: auto;"></div>
	<div class="container">
		<h3>Количество уникальных пользователей за последний день по городам</h3>
	</div>
	<div id="containerCity" style="width: 920px; height: 400px; margin: auto;"></div>	

	<script src="https://cdn.anychart.com/releases/8.12.1/js/anychart-base.min.js" type="text/javascript"></script>
	<script >
		anychart.onDocumentLoad(function () {
		    var chartVisits = anychart.line();
		    var data = <?= json_encode($dataChartVisits); ?>;
		    chartVisits.data(data);
		    chartVisits.container("containerVizits");
		    chartVisits.draw();

		    var data = <?= json_encode($dataChartCity); ?>;
			chartCity = anychart.pie(data);
			chartCity.container("containerCity");
			chartCity.draw();
	  });
	</script>
</body>
</html>