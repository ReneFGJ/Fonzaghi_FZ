<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));

$include = '../';
require($include."cab_novo.php");
$perfil->valid('#MST#GER#COJ#COM#COO#COS#GEG#MAR');
require($include.'sisdoc_menus.php');
$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$menu = array();
/////////////////////////////////////////////////// MANAGERS
array_push($menu,array('Relatórios de Faturamento','Faturamento Geral','faturamentos.php?dd3=A')); 

array_push($menu,array('Relatórios de Faturamento','Faturamento por loja','faturamentos.php')); 

array_push($menu,array('Relatórios de Faturamento','Faturamento Jóias','faturamentos.php?dd0=J')); 

array_push($menu,array('Relatórios de Faturamento','Faturamento Modas','faturamentos.php?dd0=M')); 

array_push($menu,array('Relatórios de Faturamento','Faturamento Óculos','faturamentos.php?dd0=O')); 

array_push($menu,array('Relatórios de Faturamento','Faturamento UseBrilhe','faturamentos.php?dd0=U')); 

array_push($menu,array('Relatórios de Faturamento','Faturamento Jurídico','faturamentos.php?dd0=D')); 

array_push($menu,array('Relatórios de Faturamento','Faturamento Sensual','faturamentos.php?dd0=S')); 

///////////////////////////////////////////////////// redirecionamento
if ((isset($dd[1])) and (strlen($dd[1]) > 0))
	{
	$col=0;
	for ($k=0;$k <= count($menu);$k++)
		{
		 if ($dd[1]==CharE($menu[$k][1])) {	header("Location: ".$menu[$k][2]); } 
		}
	}
?><BR>
<CENTER><FONT CLASS="lt5">Faturamento</FONT></CENTER>
<TABLE width="710" align="center" border="0">
<TR><TD colspan="4">
<FONT class="lt3">
</FONT><FORM method="post" action="fat.php">
</TD></TR>
</TABLE>
<TABLE width="<?=$tab_max;?>" align="center" border="0">
<TR valign="top">
</FONT><FORM method="post" action="fat.php">
</TD></TR>
</TABLE>
<TABLE width="<?=$tab_max;?>" align="center" border="0">
<TR valign="top">
<?
echo menus($menu,'3')
?>
</DIV></TD>
</TABLE></FORM>
<? require($vinclude."foot.php");	?>