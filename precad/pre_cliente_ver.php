<?php
require("cab.php");

require($include.'sisdoc_data.php');
require($include.'_class_form.php');

require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

$pre->le($dd[0]);
$editar = 0;
echo $pre->mostra();
echo '<h3>Contatos Pessoal</h3>';
echo $pre->lista_telefone(0);

echo '<h3>Endereço</h3>';
echo $pre->lista_endereco(0);

echo '<h3>Referências</h3>';
echo $pre->lista_referencia(0);
//echo $pre->editar_contatos();

?>
