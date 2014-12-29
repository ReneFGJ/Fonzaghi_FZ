<?
ob_start();
$include = '../';
require("../db.php");
require("../db_206_printers.php");
require($include."sisdoc_debug.php");

$dr = 'ed_'.$dd[0].'.php';

if ($dd[0] == 'printers')
	{$dx1 = "pr_codigo";	$dx2 = "pr"; 	$dx3 = "7";}

if ($dd[0] == 'printers_tipo')
	{$dx1 = "pt_codigo";	$dx2 = "pt"; 	$dx3 = "7";}

if ($dd[0] == 'ocorrencias_ti'){
	$dx1 = "ot_codigo";	$dx2 = "ot"; 	$dx3 = "3";
	require("../db_fghi2.php");
}

if ($dd[0] == 'ocorrencias_formulario'){
	$dx1 = "of_codigo";	$dx2 = "of"; 	$dx3 = "7";
	require("../db_fghi2.php");
}

if (strlen($dx1) > 0){
	$sql = "update ".$dd[0]." set ".$dx1."=trim(to_char(id_".$dx2.",'".strzero(0,$dx3)."')) where (length(trim(".$dx1.")) < ".$dx3.") or (".$dx1." isnull);";
	
	$rlt = db_query($sql);
}

echo $sql;	

header("Location: ".$dr);
echo 'Stoped'; exit;
?>
