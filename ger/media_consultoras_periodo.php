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
	for ($i=0; $i < 20; $i++) {
		$a = date('Y')-$i; 
		$op_ano .= $a.':'.$a.'&';
	}		 
	for ($i=1; $i <= 12; $i++) {
		$op_qtda .= $i.':'.$i.'&';
	}
	array_push($cp, array('$H8', '', '', False, True, ''));
	array_push($cp, array('$O&'.$op_mes, '', 'Mês a ser comparado', False, True, ''));
	array_push($cp, array('$O&'.$op_ano, '', 'Ano a ser comparado', False, True, ''));
	array_push($cp, array('$O&'.$op_qtda, '', 'Qtda meses anteriores', False, True, ''));
	array_push($cp, array('$B', '', 'Pesquisar', False, True, ''));

	//echo '<img src="img/logo_empresa.png" height="80" alt="" border="0" align="right">';
	

	$tela = $form -> editar($cp, $tabela);
	$mes = $dd[1];
	$ano = $dd[2];
	$qtda = $dd[3];
	
	
	
	echo '<h1>Média das vendas por consultora e período. </h1>';
	echo '<h2>Mês comparado - '.$dd[1].'/'.$dd[2].'.</h2>';
	echo '<h2>Média dos '.$qtda.' últimos meses</h2>';
	
	if ($form -> saved > 0) {
		/*mes a ser comparado*/
		$dt1x = $ano.$mes.'01';
		$dt2x = $ano.$mes.'31';
		
		/*meses anteriores*/
		$dt1 = date('Ymd',mktime(0,0,0,($mes-$qtda),1,$ano));
		$dt2 = $ano.$mes.'00';
		
		for ($r = 0; $r < 7; $r++) {
			
			require ("../" . $setlj[3][$r]);
			/*Calcula mes atual*/			
			$sqlx = " select sum(kh_vlr_vend) as soma, kh_cliente,cl_nome from kits_consignado inner join clientes on kh_cliente=cl_cliente
								where kh_acerto>=".$dt1x." and 
									  kh_acerto<=".$dt2x." and
									  kh_status='B'
					group by kh_cliente,cl_nome				  
					";

			$rlt = db_query($sqlx);
			while ($line = db_read($rlt)) {
				$nome =  $line['cl_nome'];
				$cl = $line['kh_cliente'];
				$vlr = $line['soma'];
				$nomes[$cl] = $nome;
				$atual_valor[$cl] += $vlr;
				$atual_lj[$cl][$setlj[0][$r]] += $vlr;
			}
			/*calcula meses anteriores*/
			$sql = " select sum(kh_vlr_vend) as soma, kh_cliente, cl_nome  from kits_consignado inner join clientes on kh_cliente=cl_cliente
								where kh_acerto>=".$dt1." and 
									  kh_acerto<".$dt2." and
									  kh_status='B'
					group by kh_cliente,cl_nome				  
					";

			$rlt = db_query($sql);

			while ($line = db_read($rlt)) {
				$nome =  $line['cl_nome'];
				$cl = $line['kh_cliente'];
				$vlr = $line['soma'];
				$nomes[$cl] = $nome;
				$total_valor[$cl] += $vlr;
				$total_lj[$cl][$setlj[0][$r]] += $vlr;
			}

		}
		
		$tela .= '<center><table class="tabela00 lt2" width="100%"><tr>
						<th class="tabelaTH">Cliente</th>
						<th class="tabelaTH">Nome</th>
						<th class="tabelaTH">Total</th>
						<th class="tabelaTH">Média</th>
						<th class="tabelaTH">'.$mes.'/'.$ano.'</th>
						<th class="tabelaTH"></th>
						<th class="tabelaTH">J</th>
						<th class="tabelaTH">M</th>
						<th class="tabelaTH">O</th>
						<th class="tabelaTH">UB</th>
						<th class="tabelaTH">S</th>
						<th class="tabelaTH">EXM</th>
						<th class="tabelaTH">EXJ</th>
					</tr>';
		arsort($total_valor);			
		foreach ($total_valor as $key => $value) {
			$vlr_atual = $atual_valor[$key];
			$atual_lj[$cl][$setlj[0][$r]] += $vlr;
			//$sty = 'style="background:#"';
			$sty1 = 'style="background:#F7F1CB"';
			$sty2 = 'style="background:#E2FFF7"';
			$link = '<a href="../cons/cons.php?dd0='.$key.'">';
			$tela .= '<tr>
						<td '.$sty.' class="tabela01" rowspan="1">'.$link.$key.'</a></td>
						<td '.$sty.' class="tabela01" rowspan="1">'.$link.$nomes[$key].'</a></td>
						<td '.$sty.' class="tabela01" rowspan="1" align="right"> '.number_format($value,2,',','.').'</td>
						<td '.$sty.' class="tabela01" rowspan="1" align="right"> '.number_format(($value/$qtda),2,',','.').'</td>
						<td '.$sty.' class="tabela01" rowspan="1" align="right"> '.number_format($vlr_atual,2,',','.').'</td>
						<td '.$sty1.' class="tabela01" align="right">média</td>
						<td '.$sty1.' class="tabela01" align="right"> '.number_format($total_lj[$key]['J']/$qtda,2,',','.').'</td>
						<td '.$sty1.' class="tabela01" align="right"> '.number_format($total_lj[$key]['M']/$qtda,2,',','.').'</td>
						<td '.$sty1.' class="tabela01" align="right"> '.number_format($total_lj[$key]['O']/$qtda,2,',','.').'</td>
						<td '.$sty1.' class="tabela01" align="right"> '.number_format($total_lj[$key]['UB']/$qtda,2,',','.').'</td>
						<td '.$sty1.' class="tabela01" align="right"> '.number_format($total_lj[$key]['S']/$qtda,2,',','.').'</td>
						<td '.$sty1.' class="tabela01" align="right"> '.number_format($total_lj[$key]['EXM']/$qtda,2,',','.').'</td>
						<td '.$sty1.' class="tabela01" align="right"> '.number_format($total_lj[$key]['EXJ']/$qtda,2,',','.').'</td>
						</tr>';
			$tela .= '<tr>
						<td '.$sty.' class="tabela02"></td>
						<td '.$sty.' class="tabela02"></td>
						<td '.$sty.' class="tabela02"></td>
						<td '.$sty.' class="tabela02"></td>
						<td '.$sty.' class="tabela02"></td>
						<td '.$sty2.' class="tabela01" align="right">'.$mes.'/'.$ano.'</td>
						<td '.$sty2.' class="tabela01" align="right"> '.number_format($atual_lj[$key]['J'],2,',','.').'</td>
						<td '.$sty2.' class="tabela01" align="right"> '.number_format($atual_lj[$key]['M'],2,',','.').'</td>
						<td '.$sty2.' class="tabela01" align="right"> '.number_format($atual_lj[$key]['O'],2,',','.').'</td>
						<td '.$sty2.' class="tabela01" align="right"> '.number_format($atual_lj[$key]['UB'],2,',','.').'</td>
						<td '.$sty2.' class="tabela01" align="right"> '.number_format($atual_lj[$key]['S'],2,',','.').'</td>
						<td '.$sty2.' class="tabela01" align="right"> '.number_format($atual_lj[$key]['EXM'],2,',','.').'</td>
						<td '.$sty2.' class="tabela01" align="right"> '.number_format($atual_lj[$key]['EXJ'],2,',','.').'</td>
					</tr>';			
}
		$tela .= '<table></center>';

	}
	echo $tela;
} else {
	echo '<h1>Usuário sem acesso a esta área!!</h1>';
}
echo $hd -> foot();
?>