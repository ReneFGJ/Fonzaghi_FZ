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
array_push($cp,array('$O 1:1 conex�o&5:5 conex�es&10:10 conex�es&50:50 conex�es&100:100 conex�es&500:500 conex�es','','Conex�es',False,True,''));
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
