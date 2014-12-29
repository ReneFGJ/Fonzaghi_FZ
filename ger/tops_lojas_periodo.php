<?
$breadcrumbs = array();
array_push($breadcrumbs, array('index.php', 'Loja'));
array_push($breadcrumbs, array('acertos_periodo.php', 'Acertos'));

$include = '../';
require ("../cab_novo.php");
require ($include . 'sisdoc_data.php');
require ('../_class/sisdoc_lojas.php');
require ($include . '_class_form.php');
$form = new form;
require ("../_class/_class_consignacoes.php");
$cons = new consignacoes;

setlj();

$t1 = 0;
$t2 = 0;
$t3 = 0;
$tela = '';
$cp = array();
if ($perfil -> valid('#MST#DIR#GEG')) {

	$op_mes = '01:JANEIRO&02:FEVEREIRO&03:MARÇO&04:ABRIL&05:MAIO&06:JUNHO&07:JULHO&08:AGOSTO&09:SETEMBRO&10:OUTUBRO&11:NOVEMBRO&12:DEZEMBRO';
	for ($i = 0; $i < 20; $i++) {
		$a = date('Y') - $i;
		$op_ano .= $a . ':' . $a . '&';
	}
	for ($i = 1; $i <= 12; $i++) {
		$op_qtda .= $i . ':' . $i . '&';
	}
	array_push($cp, array('$H8', '', '', False, True, ''));
	array_push($cp, array('$O&' . $op_mes, '', 'Mês a ser comparado', False, True, ''));
	array_push($cp, array('$O&' . $op_ano, '', 'Ano a ser comparado', False, True, ''));
	array_push($cp, array('$O&' . $op_qtda, '', 'Qtda meses anteriores', False, True, ''));
	array_push($cp, array('$S3', '', 'Qtda de consultoras', False, True, ''));
	array_push($cp, array('$B', '', 'Pesquisar', False, True, ''));

	//echo '<img src="img/logo_empresa.png" height="80" alt="" border="0" align="right">';

	$telax = $form -> editar($cp, $tabela);
	$mes = $dd[1];
	$ano = $dd[2];
	$qtda = $dd[3];
	$qtda_cons = $dd[4];

	echo '<h1>Top vendas consultoras por loja. </h1>';
	echo '<h2>Mês comparado - ' . $dd[1] . '/' . $dd[2] . '.</h2>';
	echo '<h2>Média dos ' . $qtda . ' últimos meses</h2>';
	echo $telax;
	if ($form -> saved > 0) {
		/*mes a ser comparado*/
		$dt1x = $ano . $mes . '01';
		$dt2x = $ano . $mes . '31';
		if (strlen(trim($qtda_cons)) == 0) {
			$qtda_cons = 5;
		}
		/*meses anteriores*/
		$dt1 = date('Ymd', mktime(0, 0, 0, ($mes - $qtda), 1, $ano));
		$dt2 = $ano . $mes . '00';
		for ($r = 0; $r < 7; $r++) {
			require ("../" . $setlj[3][$r]);
			$tela = '<center><h1>' . $setlj[1][$r] . '</h1>';
			$tela .= '<table class="tabela00 lt2" width="70%"><tr>
						<th class="tabelaTH" width="10%">Cliente</th>
						<th class="tabelaTH" width="60%">Nome</th>
						<th class="tabelaTH" width="10%">Total meses ant.</th>
						<th class="tabelaTH" width="10%">Média meses ant.</th>
						<th class="tabelaTH" width="10%">Total mês' . $mes . '/' . $ano . '</th>
					</tr>';
			/*calcula meses anteriores*/
			$sql = " select sum(kh_vlr_vend) as soma, kh_cliente, cl_nome  from kits_consignado inner join clientes on kh_cliente=cl_cliente
								where kh_acerto>=" . $dt1 . " and 
									  kh_acerto<" . $dt2 . " and
									  kh_status='B' 
					group by kh_cliente,cl_nome		
					order by soma desc
					limit " . $qtda_cons . "			  
					";
			$rlt = db_query($sql);
			while ($linex = db_read($rlt)) {
				$nome = $linex['cl_nome'];
				$cl = $linex['kh_cliente'];
				$vlr = $linex['soma'];
				/*Calcula mes atual*/
				$sqlx = " select sum(kh_vlr_vend) as soma, kh_cliente,cl_nome from kits_consignado inner join clientes on kh_cliente=cl_cliente
								where kh_acerto>=" . $dt1x . " and 
									  kh_acerto<=" . $dt2x . " and
									  kh_status='B' and
									  kh_cliente ='" . $cl . "'
					group by kh_cliente,cl_nome
					";
				$rltx = db_query($sqlx);
				while ($linex = db_read($rltx)) {
					$vlr_atual = $linex['soma'];
				}
				$link = '<a href="../cons/cons.php?dd0=' . $cl . '">';
				$tela .= '<tr>
							<td class="tabela01" rowspan="1">' . $link . $cl . '</a></td>
							<td class="tabela01" rowspan="1">' . $link . $nome . '</a></td>
							<td class="tabela01" rowspan="1" align="right"> ' . number_format($vlr, 2, ',', '.') . '</td>
							<td class="tabela01" rowspan="1" align="right"> ' . number_format(($vlr / $qtda), 2, ',', '.') . '</td>
							<td class="tabela01" rowspan="1" align="right"> ' . number_format($vlr_atual, 2, ',', '.') . '</td>
							</tr>';

			}
		$tela .= '<table></center>';
		echo $tela;
		}
	}
} else {
	echo '<h1>Usuário sem acesso a esta área!!</h1>';
}
echo $hd -> foot();
?>