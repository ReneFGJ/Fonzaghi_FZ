<?php
$include = '../';
require ('cab.php');
$id = trim($dd[0]);
$verb = trim($dd[1]);
$log = trim($dd[2]);

require ("../_class/_class_cadastro_pre.php");
$prex = new cadastro_pre;
switch ($verb) {
	case '@' :
		$prex -> atualiza_status_contatos($id, '@', $log);
		$hd->retornar_para_pagina_principal();		
		break;
	case 'R' :
		$prex -> atualiza_status_contatos($id, 'R', $log);
		$hd->retornar_para_pagina_principal();
		break;
	case 'B' :
		$prex -> atualiza_status_contatos($id, 'B', $log);
		$hd->retornar_para_pagina_principal();
		break;
	case 'X' :
		$prex -> atualiza_status_contatos($id, 'X', $log);
		$hd->retornar_para_pagina_principal();
		break;
}
?>
