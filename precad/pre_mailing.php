<?php
require("cab.php");
require('../../_include/sisdoc_tips.php');
require('../../_include/sisdoc_data.php');
require("../_class/_class_cadastro_pre_mailing.php");
$pre = new cadastro_pre_mailing;

require("../../_db/db_cadastro.php");
$tabela = 'cadastro';
$editar = false;
$http_redirect = 'pre_mailing.php';
$http_ver = 'pre_mailing_ver.php';
$y = date('Y');
$m = date('m');
$d = date('d');
$dt_limit = date("Ymd",mktime(0,0,0,$m-6,$d,$y));
$pre_where = ' cl_last >0 and cl_last<'. $dt_limit;
$pre->row_mailing();
$busca = true;
$offset = 20;
$tab_max = "100%";
echo '<div id="content">';
	echo '<TABLE width="98%" align="center"><TR><TD>';
	require('../../_include/sisdoc_colunas.php');
	require('../../_include/sisdoc_row.php');	
	echo '</table>';	
echo '</div>';
?>
