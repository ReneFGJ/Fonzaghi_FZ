<?
$include = '../';
require($include."cab.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require($include."sisdoc_form2.php");
require($include."cp2_gravar.php");

require("../_classes/_class_loja.php");
$lj = new loja;

$cp = $lj->solicita_periodo_de_ate_lojas();

echo '<table width="704">';
editar();
echo '</table>';
	
if ($saved > 0)
	{
		$dd1= brtos($dd[2]);
		$dd2= brtos($dd[3]);
		
		$lojas = $lj->bases_lojas();
		
		for ($r=0;$r < count($lojas);$r++)
		{
		$db = '../'.trim($lojas[$r]);
		require($db);
		if ($lj->valida_entrada_datas($dd1,$dd2))
			{
				echo $lj->altera_acerto_coletivo($dd1,$dd2).' '.$db;
			}
		}
	}		

require($vinclude."foot.php");	?>