<?
$nocliente = 1;
$nocab = 1;
require ("cab.php");
//require ($include . "sisdoc_debug.php");
require ($include . 'sisdoc_data.php');
require ($include . '_class_form.php');

$form = new form;
require ("_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

if (strlen(trim($_SESSION['cad_cliente'])) > 0) {
	$dd[1] = $_SESSION['cad_cliente'];
}

if (strlen(trim($dd[1])) > 0) {
	require ("../_db/db_mysql_" . $ip . ".php");
	$pre -> recupera_dados_pelo_codigo($dd[1],'00');
	$dd[2] = $pre -> nome;

	require ("../_db/db_206_telemarket.php");
	
	$cp = array();
	array_push($cp, array('$H8', 'id_l', '', False, True, ''));
	array_push($cp, array('$S7', 'l_cliente', 'Cliente', True, False, ''));
	array_push($cp, array('$S80', 'l_nome', 'Nome', True, False, ''));
	array_push($cp, array('$H8', 'l_data', 'Data', True, True, ''));
	array_push($cp, array('$H5', 'l_hora', 'Hora', True, True, ''));
	array_push($cp, array('$H10', 'l_log', 'Log', True, True, ''));
	array_push($cp, array('$D', 'l_agendar_para', 'Agendar para', True, True, ''));
	array_push($cp, array('$S15', 'l_telefone', 'Telefone', True, True, ''));
	array_push($cp, array('$T100:3', 'l_comente', 'Descrição', True, True, ''));
	array_push($cp, array('$O 0:Nao&1:Sim', 'l_indicado', 'Indicado?', True, True, ''));
	array_push($cp, array('$O 1:Ativo&0:Inativo', 'l_status', 'Status', True, True, ''));
	array_push($cp, array('$H8', 'l_update', '', True, True, ''));
	array_push($cp, array('$H5', 'l_update_hora', '', True, True, ''));
	array_push($cp, array('$H7', 'l_codigo', '', False, False, ''));

	$dd[3] = date('Ymd');
	$dd[4] = date('H:i');
	$dd[5] = $user -> user_log;
	$dd[11] = date('Ymd');
	$dd[12] = date('H:i');

	$tabela = 'listatelefonica';
	$tela = '<h1>Agendamentos</h1>';
	$tela .= $form -> editar($cp, $tabela);

	if ($form -> saved > 0) {
		$pre->updatex_agendamento();
		redirecina('close.php');
	} else {
		echo $tela;
	}

} else {
	$tela = '<h1>Agendamentos</h1>';
	$tela .= '<h2>Selecione uma consultora antes de agendar!!</h2>';
	echo $tela;
}
?>