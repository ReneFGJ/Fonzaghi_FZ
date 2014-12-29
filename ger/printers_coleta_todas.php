<?
$breadcrumbs=array();
array_push($breadcrumbs, array('../index.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
array_push($breadcrumbs, array('/fonzaghi/ger/printers_coleta_todas.php','Coletar dados de totas as impressoras'));

$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_menus.php");
require_once($include."sisdoc_email.php");
require($include."sisdoc_windows.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."cp2_gravar.php");
require('../_class/_class_printers.php');
$print = new printers;

$tab_max = '95%';
echo $print->email_printers();

$print->atualiza_printers();
echo $print->visualizar_tabela();

echo $hd->foot();	
?>