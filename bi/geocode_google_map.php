<?
$breadcrumbs=array();


$include = '../';
require("../cab_novo.php");
require("../_class/_class_geocode.php");
$geo = new geocode;



echo '<center>';
echo $geo->gera_google_map();

$hd->foot();
?>
