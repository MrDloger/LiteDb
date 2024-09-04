<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>Загрузка файла</title>
</head>
<body>
	<div class="container">
		<form action="" method="POST" enctype="multipart/form-data">
			<input type="file" name="file" accept=".txt">
			<input type="submit">
		</form>
	</div>
	
	<?php
		if (array_key_exists('file', $_FILES)) {
			$fileName = $_SERVER['DOCUMENT_ROOT'] . '/1/files/' . date('Y_m_d_h_i_s') . '.txt';
			$resWrite = file_put_contents($fileName, file_get_contents($_FILES['file']['tmp_name']));
			if ($resWrite > 0) {
				?>
					<div class="container">
						<div class="success circle"></div>
					</div>
				<?php

				$fileData = file_get_contents($fileName);
				if ($fileData) {
					$data = explode(PHP_EOL, $fileData);
					$pattern = '/[^0-9]/';
					?>
						<div class="result">
					<?php
					foreach ($data as $str) {
						$strNumberLen = strlen(preg_replace($pattern, "", $str));
						echo "{$str} = {$strNumberLen}<br>";
					}
					?> 
						</div>
					<?php
				}
			} else {
				?>
					<div class="container">
						<div class="error circle"></div>
					</div>
				<?php
			}
		} 
	?>
</body>
</html>