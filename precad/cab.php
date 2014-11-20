<?php
$style_add = array('fz_stytecab_top.css', 'fz_style_cad_pre.css', 'fz_style_cpf.css');
$menus = array();
array_push($menus, array('index.php', 'HOME'));
array_push($menus, array('pre_cadastro.php', 'PRÉ-CADASTRO'));
array_push($menus, array('pre_mailing.php', 'MAILING'));
array_push($menus, array('pre_alteracoes.php', 'ALTERAÇÕES'));
array_push($menus, array('pre_acp.php', 'ACP'));
require ("../cab.php");
?>
<h1>Pré-Cadastro</h1>
<div id="msg_main" class="cad_msg"></div>
<style>
	.cad_msg {
		z-index: 1000;
		position: absolute;
		float: right;
		width: 50px;
		height: 50px;
		bottom: 0px;
		right: 0px;
		background-image: url('../img/cad_msg.png');
		background-repeat: no-repeat;
		background-size: contain;
	}
	.cad_msg_box {
		z-index: 1000;
		position: absolute;
		float: right;
		background: #C0C0C0;
		width: 400px;
		height: 500px;
		bottom: 0px;
		right: 0px;
	}
</style>

