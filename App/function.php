<?php
spl_autoload_register(function ($class_name) {
    include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $class_name . '.php';
});
function d($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
function dv($data){
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
}