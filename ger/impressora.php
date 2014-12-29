<?
$include = '../';

$breadcrumbs=array();
array_push($breadcrumbs, array('../index.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));

require($include."cab_novo.php");
require($include."sisdoc_menus.php");

$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$menu = array();
/////////////////////////////////////////////////// MANAGERS
array_push($menu,array('Impressora','Cadastrar/Alterar tipo de impressora','ed_printers_tipo.php')); 
array_push($menu,array('Impressora','Cadastrar/Alterar impressora','ed_printers.php')); 
array_push($menu,array('Impressora','Coletar dados de totas as impressoras','printers_coleta_todas.php')); 

array_push($menu,array('Relatório','Relatório geral: impressoras e páginas impressas','printers_rel.php')); 
array_push($menu,array('Gráfico','Gráfico da impressão mensal','printers_grafico.php')); 
?>

<TABLE width="710" align="center" border="0">
<TR><TD colspan="4">
<FONT class="lt3">
</FONT><FORM method="post" action="index.php">
</TD></TR>
</TABLE>
<TABLE width="710" align="center" border="0">
<TR>
<?
	$tela = menus($menu,"3");
?>
<? require($vinclude."foot.php");	?>