<?php
require_once('classes/db.php');

function db(){
	return Db::getInstance();
}