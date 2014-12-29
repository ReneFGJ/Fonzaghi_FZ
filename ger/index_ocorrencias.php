<?
$include = '../';

$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/index_ocorrencias.php','Formulário de ocorrências'));

require($include."cab.php");
require($include."sisdoc_menus.php");

$estilo_admin = 'style="width: 200; height: 30; background-color: #EEE8AA; font: 13 Verdana, Geneva, Arial, Helvetica, sans-serif;"';
$menu = array();
/////////////////////////////////////////////////// MANAGERS
array_push($menu,array('Gestão de ocorrências','Cadastrar nova ocorrência','ocorrencias_formulario.php')); 
array_push($menu,array('Acompanhamento','Listagem de ocorrências','ed_ocorrencias_formulario.php')); 
array_push($menu,array('Equipe de TI','Cadastrar/Alterar membros da TI','ed_ocorrencias_ti.php')); 
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