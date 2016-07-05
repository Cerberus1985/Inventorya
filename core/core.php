<?php
if (!defined('DS')) {
    include "libs/Smarty.class.php";
}
IF (!defined ('__ADODB5__')){
	include "adodb5/adodb.inc.php";
}
if (!defined('___LIBSDTUP__')){
	include "librerias/dtup.php";
}
if (!defined('___TIMER__')){
	include "librerias/timer.php";
}
if (!defined('___SESSION__')){
include_once("adodb/session/adodb-session2.php");
$driver='mysqli';
$host='localhost';
$user='root';
$pass='12341234';
$BaseDatos='inventorya';
ADOdb_Session::config($driver, $host, $user, $pass, $BaseDatos,$options=false);
session_start();
}
 ?>
