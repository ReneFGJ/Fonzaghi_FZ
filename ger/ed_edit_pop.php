<?
ob_start();
$nocab = True;
require("db.php");
require("letras.css");
require($include.'sisdoc_security.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
$tab_max = '100%';
security();
$cpn = $dd[99];
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require('cp/cp_'.$cpn.'.php');
require($include.'cp2_gravar.php');
$http_edit = 'ed_edit_pop.php?dd99='.$dd[99];
$http_redirect = 'close.php';
$tit = strtolower(troca($dd[99],'_',' '));
$tit = strtoupper(substr($tit,0,1)).substr($tit,1,strlen($tit));

echo '<CENTER><font class=lt5>Cadastro de '.$tit.'</font></CENTER>';
?><TABLE width="<?=$tab_max?>" align="center"><TR><TD><?
editar();
?></TD></TR></TABLE><?	
require("foot.php");		
?>