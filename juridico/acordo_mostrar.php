<?php
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require("../cab.php");
REQUIRE($include.'sisdoc_data.php');
REQUIRE($include.'sisdoc_debug.php');

require("../db_fghi_206_cadastro.php");

echo '<BR><BR>';

require("../_class/_class_consultora.php");
$cn = new consultora;
$cliente = $dd[0];

$include_db = '../../_db/';
$cn->include_class = $include_db;

$cn->le($cliente);
$cn->le_completo($cliente);

/* Dados da Consultora */
$sx .= '<center>';
$sx .= '<table border=0 width="100%" cellpadding=0 cellspacing=1>';

$sx .= '<TR valign="top">';
$sx .= '<TD width="300" style="height: 800px;">';
	/* Dados fotos */
	$sx .= '<div id="cons_foto">
				<img src="'.$cn->foto().'" height="200">
			</div>';

	/* Dados pessoais */
	$sx .= '<div id="cons_dados_documentos">' . 
				$cn->mostra_dados_pessoais_novo() . 
			'</div>';
$sx .= '</div>';

$sx .= '<TD style="border-left: solid 1px #000000;">';

$sx .= '<TD>';
/* Nome */
$sx .= '<div id="cons_grupo_2">';
	$sx .= '<div id="cons_nome"><h1>' . $cn->nome . '</h1></div>';
			
	/* Resumos */
	$sx .= '<div id="cons_nome">' . $cn->mostra_acertos() . '</div>';
			
$sx .= '</div>';


echo $sx;

echo $hd->foot();
?>
