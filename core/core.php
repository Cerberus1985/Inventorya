<?php

if (!defined('DR')) {
    define('DR', DIRECTORY_SEPARATOR, true);
}

if (!defined('__INIDRIVER__')) {
    include 'class'.DR.'class.Inidriver.php';
}

if (!defined('DS')) {
    include 'libs'.DR.'Smarty.class.php';
}
if (!defined('__ADODB5__')) {
    include 'adodb5'.DR.'adodb.inc.php';
}
if (!defined('___LIBSDTUP__')) {
    include 'librerias'.DR.'dtup.php';
}
if (!defined('___TIMER__')) {
    include 'librerias'.DR.'timer.php';
}
if (!defined('___SESSION__')) {
    include_once 'adodb'.DR.'session'.DR.'adodb-session2.php';
    /* se inicializa smarty y la clase que maneja la configuracion*/
$inidriver = new Inidriver();
    $smarty = new Smarty();
    $iniconfig = $inidriver->getIniFile();

    /*FIN DE AREA*/
    /*Area de base de datos*/
$driver = $iniconfig['Base_Datos_Config']['db.driver'];
    $host = $iniconfig['Base_Datos_Config']['db.host'];
    $user = $iniconfig['Base_Datos_Config']['db.user'];
    $pass = $iniconfig['Base_Datos_Config']['db.password'];
    $BaseDatos = $iniconfig['Base_Datos_Config']['db.dbname'];
    /*fin Area de base de datos*/
    /*area smarty config*/
$smarty->template_dir = $iniconfig['smarty_config']['smarty.templates'];
    $smarty->compile_dir = $iniconfig['smarty_config']['smarty.templates_c'];
    /* fin smarty config*/
    /*Inicializo la session */
/*el registro en DB para loggin*/
ADOdb_Session::config($driver, $host, $user, $pass, $BaseDatos, $options = false);
    session_start();
}
