<?
$breadcrumbs=array();


$include = '../';
require("../cab_novo.php");
require("../_class/_class_consultora.php");

require("../_class/_class_geocode.php");
$geo = new geocode;

echo '<center>';
echo $geo->gera_google_mapv3(0);

$hd->foot();
?>
