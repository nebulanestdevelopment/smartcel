<?php
/**
* @author evilnapsis
**/

define("ROOT", dirname(__FILE__));
/*
$debug= false;
if($debug){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
}
*/
$debug=true;
if($debug){
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
error_reporting(E_ALL ^ E_NOTICE);
}else{
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}
include "core/autoload.php";

ob_start();
session_start();
Core::$root="";

// si quieres que se muestre las consultas SQL debes decomentar la siguiente linea
 //Core::$debug_sql = true;

$lb = new Lb();
$lb->start();

?>
