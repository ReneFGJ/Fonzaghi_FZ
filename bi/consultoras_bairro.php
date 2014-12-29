<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Melhor Atender'));

$include = '../';
require("../cab_novo.php");

require("../_class/_class_consultora.php");
$con = new consultora;

echo '<h1>Perfil das consultoras por Bairro</h1>';
echo '<div class="no_print">';
echo '<center>';
for ($r=0;$r <= 6;$r++)
	{
		
		echo '<A HREF="consultoras_bairro.php?dd1='.$r.'">';
		echo '<img src="'.$http.'/img/icone_lj_'.$r.'a.png" 
							onmouseover="$(this).attr(\'src\',\''.$http.'img/icone_lj_'.$r.'.png\');" 
							onmouseout="$(this).attr(\'src\',\''.$http.'img/icone_lj_'.$r.'a.png\');"
					width="100" border=0>';
		echo '</A>';
		echo '&nbsp;';
	}
echo '<A HREF="consultoras_bairro.php?dd1=*">';
echo '<img src="'.$http.'/img/icone_lj_Aa.png" 
			onmouseover="$(this).attr(\'src\',\''.$http.'img/icone_lj_A.png\');" 
			onmouseout="$(this).attr(\'src\',\''.$http.'img/icone_lj_Aa.png\');"
		width="100" border=0>';	
		echo '</A>';
echo '</center>';
echo '</div>';
echo '<BR><BR>';

/***
 * Calculo
 */
if (strlen($dd[1]) > 0)
	{
		require("../db_fghi_206_modas.php");
		$cons = $con->consultoras_loja();
		require("../db_fghi_206_cadastro.php");
		
		echo $con->consultora_bairros($cons);
	} 
 
echo '<BR><BR><BR><BR><BR><BR><BR><BR><BR>';
echo $hd->foot();