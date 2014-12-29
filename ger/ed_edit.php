<?
$breadcrumbs=array();

if ($_GET['dd99']=='printers'){
	array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
	array_push($breadcrumbs, array('/fonzaghi/ger/ed_printers.php','Cadastrar/Alterar impressora'));
}
else if ($_GET['dd99']=='printers_tipo'){
	array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
	array_push($breadcrumbs, array('/fonzaghi/ger/ed_printers_tipo.php','Cadastrar/Alterar Tipo de impressora'));
}
else if ($_GET['dd99']=='ocorrencias_ti'){
	array_push($breadcrumbs, array('/fonzaghi/ger/index_ocorrencias.php','Formulário de ocorrências'));
	array_push($breadcrumbs, array('/fonzaghi/ger/ed_ocorrencias_ti.php','Cadastrar/Alterar Menbros da TI'));
}
else if ($_GET['dd99']=='ocorrencias_formulario'){
	array_push($breadcrumbs, array('/fonzaghi/ger/index_ocorrencias.php','Formulário de ocorrências'));
	array_push($breadcrumbs, array('/fonzaghi/ger/ed_ocorrencias_formulario.php','Listagem das ocorrencias'));
}

//array_push($breadcrumbs, array('/fonzaghi/ger/ed_edit.php','[Editar]'));

$include="../";
require($include."cab_novo.php");

$cpn = $dd[99];

require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require('cp/cp_'.$cpn.'.php');

require($include.'cp2_gravar.php');
require($include.'sisdoc_debug.php');
require($include.'biblioteca.php');

$http_edit = 'ed_edit.php?dd99='.$dd[99];
$http_redirect = 'updatex.php?dd0='.$dd[99];

if (strlen($tit) == 0){
	$tit = strtolower(troca($dd[99],'_',' '));
	$tit = strtoupper(substr($tit,0,1)).substr($tit,1,strlen($tit));
}

echo '<h1>Cadastro de '.$tit.'</h1><CENTER>';
?><TABLE width="<?=$tab_max?>" align="center"><TR><TD><?
editar();
?></TD></TR></TABLE><?	

require("../foot.php");		
?>