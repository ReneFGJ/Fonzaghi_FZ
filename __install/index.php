<?php
$install = 1;
$include = '../';
echo '1';
require("../db.php");
echo '1';
echo '<h1>Install DataBase</h1>';
require($include.'_class_form.php');
$form = new form;

/* Criar diretorio */
if (!(is_dir('../_db'))) { mkdir('../_db'); }

/* Campos de Entrada */
$cp = array();
array_push($cp,array('$H8','','',False,True));
array_push($cp,array('$S200','$db_title','Databases name',True,True));
array_push($cp,array('$S15','$db_server','Server',True,True));
array_push($cp,array('$S50','$db_base','Database',True,True));
array_push($cp,array('$S50','$db_user','User',True,True));
array_push($cp,array('$S50','$db_pass','Pass',False,True));

/* Se já existe arquivo de configuracao redireciona para pagina inicial */
$filename = "../../_db/db_mysql_".$ip.".php";
if (file_exists($filename)) { redireciona('../index.php'); }


$tela = $form->editar($cp,'PHP:'.$filename);
if ($form->saved > 0)
	{
		$tela = '<font color="green">Salvo com sucesso!</font>';
		redireciona('..fz/index.php');
	} else {
		
	}
?>
<center>
<fieldset style="width: 50%;"><legend>Install</legend>
<?=$tela;?>
	
</fieldset>
</center>