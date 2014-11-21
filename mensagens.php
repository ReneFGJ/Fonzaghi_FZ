<?
$nocliente = 1;
$nocab = 1;
require ("cab.php");
//require($include."sisdoc_debug.php");
require ($include . 'sisdoc_data.php');
require ($include . '_class_form.php');
require ("../_db/db_cadastro.php");
$form = new form;

//mensagens
$msg = array();
array_push($msg, "0-Recepção, utilizar para informações direcionadas a recepção");
array_push($msg, "1-Informativa, e removido automaticamente após primeira leitura");
array_push($msg, "2-Informativa, removida somente manualmente");
array_push($msg, "3-Informativa, removida somente pelas coordenadoras ou supervisora");
array_push($msg, "4-Informativa, removida somente pela supervisora");
array_push($msg, "5-Informativa, removida somente pelo jurídico");
array_push($msg, "6-Restritiva, removida pelas coordenadoras");
array_push($msg, "7-Restritiva, removida pela supervisora");
array_push($msg, "8-Restritiva, removida pelo jurídico, com possibilidade de liberar");
array_push($msg, "9-Restritiva, Bloqueio total, removido pelo jurídico");

$op = '';
for ($i = 0; $i <= 9; $i++) {
	$op .= $i . ':' . $msg[$i] . '&';
}

if (strlen(trim($_SESSION['cad_cliente'])) > 0) {
	$dd[1] = $_SESSION['cad_cliente'];

	$dd[5] = date('Ymd');
	$dd[6] = date('H:i');
	$dd[7] = 0;
	$dd[8] = 0;
	$dd[9] = '-';
	$dd[10] = $user -> user_log;

	$cp = array();
	array_push($cp, array('$H8', 'id_msg', '', False, True, ''));
	array_push($cp, array('$S7', 'msg_cliente', 'Cliente', True, True, ''));
	array_push($cp, array('$T65:2', 'msg_text', 'Texto', True, True, ''));
	array_push($cp, array('$O ' . $op, 'msg_nivel', 'Tipo de mensagem', True, True, ''));
	array_push($cp, array('$O 1:Ativo&0:Inativo', 'msg_status', 'Status', True, True, ''));
	array_push($cp, array('$H8', 'msg_data', '', True, True, ''));
	array_push($cp, array('$H5', 'msg_hora', '', True, True, ''));
	array_push($cp, array('$H1', 'msg_lido', '', True, True, ''));
	array_push($cp, array('$H8', 'msg_data_lido', '', True, True, ''));
	array_push($cp, array('$H5', 'msg_hora_lido', '', True, True, ''));
	array_push($cp, array('$H10', 'msg_log', '', True, True, ''));

	$tabela = 'mensagem';
	$tela = '<h1>Cadastro de mensagens</h1>';
	$tela .= $form -> editar($cp, $tabela);

	if ($form -> saved > 0) {
		redirecina('close.php');
	} else {
		echo $tela;
		if (strlen(trim($_SESSION['cad_cliente'])) > 0) {
			$sql = "select * from mensagem 
				where msg_cliente='" . $dd[1] . "'";
			$rlt = db_query($sql);
			$sx = '<table class="tabela00" width="90%"><tr>
					<th class="tabelaTH" width="10%">Data</th>
					<th class="tabelaTH" width="10%">Hora</th>
					<th class="tabelaTH" width="70%">Nivel</th>
					</tr>';
			while ($line = db_read($rlt)) {
				$sx .= '<tr>
						<th class="tabela01">' . stodbr($line['msg_data']) . '</th>
						<th class="tabela01">' . $line['msg_hora'] . '</th>
						<th class="tabela01">' . $msg[$line['msg_nivel']] . '</th>
					<tr>
						<th class="tabela01" colspan="3">' . $line['msg_text'] . '</th>
					</tr>
					</tr><tr><td colspan="3"></td></tr>
					';
			}
			$sx .= '</table>';
			echo $sx;
		}
	}

} else {
	$tela = '<h1>Cadastro de mensagens</h1>';
	$tela .= '<h2>Selecione uma consultora antes de cadastrar mensagem!!</h2>';
	echo $tela;
}
?>
