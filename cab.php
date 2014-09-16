<?php
/**
 * Cabeclaho
 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com:
 * @copyright Copyright (c) 2014
 * @access public
 * @version v.0.14.18
 * @package Layout
 * @subpackage header
 */

$include = '../../';
$include_db = '../../';
require ("db.php");
require ("_class/_class_header_fz.php");
require("_class/_class_user_perfil.php");
require ("_class/_class_user.php");
$perfil = new user_perfil;
$user = new user;
$hd = new header;

$hd->charcod = "ISO-8859-1";
echo $hd -> cab();


$hd -> http = '../';
$user -> security();


$ss = $user;
global $cr;
$cr = chr(13) . chr(10);
?>
