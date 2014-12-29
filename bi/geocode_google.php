<?
$breadcrumbs=array();

$include = '../';
require("../cab_novo.php");
require("../_class/_class_form.php");
$form = new form;
require("../_class/_class_geocode.php");
$geo = new geocode;
$tabela='';
$cp = array();
array_push($cp,array('$H8','','',False,True,''));
array_push($cp,array('$O 1:1 conexão&5:5 conexões&10:10 conexões&50:50 conexões&100:100 conexões&500:500 conexões','','Conexões',False,True,''));
$menu =  $form->editar($cp, $tabela);
echo '<center>';
if($form->saved>0)
{
	$qtda = $dd[1];
	echo $geo->import_geocodes($qtda);
}else{
	echo $menu;
}

$hd->foot();
?>
