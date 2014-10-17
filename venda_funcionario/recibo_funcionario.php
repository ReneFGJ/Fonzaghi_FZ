<?
$nocab=1;
require("../cab.php");
require($include.'sisdoc_debug.php');

require('../_class/_class_vendas_funcionario.php');
$vendas = new vendas_funcionario;
$cracha = $dd[1];

echo '<pre>';
echo $vendas->gera_recibo($cracha);
echo '</pre>';
?>