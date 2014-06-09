<?php
$include = '../../';
$include_db = '../../';

require("../db.php");

require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

$verb = $dd[1];
$page = $dd[2];

require($include.'_class_form.php');
$form = new form;
$form->form_name = "form_".$page;

echo '<div id="ajax_'.$page.'">';
echo $pre->lista_telefone();

$cp = $pre->cp_fone();
echo $form->editar($cp,'');

echo '</div>';
?>