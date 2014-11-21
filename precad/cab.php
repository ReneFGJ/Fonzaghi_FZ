<?php
$style_add = array('fz_stytecab_top.css', 'fz_style_cad_pre.css', 'fz_style_cpf.css');

$menus = array();
array_push($menus, array('index.php', 'HOME'));
array_push($menus, array('pre_cadastro.php', 'PRÉ-CADASTRO'));
array_push($menus, array('pre_mailing.php', 'MAILING'));
array_push($menus, array('pre_alteracoes.php', 'ALTERAÇÕES'));
array_push($menus, array('pre_acp.php', 'ACP'));
array_push($menus, array('#" onclick="newxy2(\'../mensagens.php\',700,600);', 'MENSAGENS'));
array_push($menus, array('#" onclick="newxy2(\'../agendamento.php\',700,600);', 'AGENDAMENTO'));
require ("../cab.php");
require ($include . 'sisdoc_windows.php');
?>
<h1>Pré-Cadastro</h1>
