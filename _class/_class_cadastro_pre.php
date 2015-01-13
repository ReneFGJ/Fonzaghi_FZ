<?php
/**
 * Pré-Cadastro
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.14.23
 * @package _class
 * @subpackage _class_cadastro_pre.php
 */
if (!(function_exists("cpf"))) {
	function cpf($cpf) {
		$cpf = sonumero($cpf);
		if (strlen($cpf) <> 11) {
			return (false);
		}

		$soma1 = ($cpf[0] * 10) + ($cpf[1] * 9) + ($cpf[2] * 8) + ($cpf[3] * 7) + ($cpf[4] * 6) + ($cpf[5] * 5) + ($cpf[6] * 4) + ($cpf[7] * 3) + ($cpf[8] * 2);
		$resto = $soma1 % 11;
		$digito1 = $resto < 2 ? 0 : 11 - $resto;

		$soma2 = ($cpf[0] * 11) + ($cpf[1] * 10) + ($cpf[2] * 9) + ($cpf[3] * 8) + ($cpf[4] * 7) + ($cpf[5] * 6) + ($cpf[6] * 5) + ($cpf[7] * 4) + ($cpf[8] * 3) + ($cpf[9] * 2);

		$resto = $soma2 % 11;
		$digito2 = $resto < 2 ? 0 : 11 - $resto;
		if (($cpf[9] == $digito1) and ($cpf[10] == $digito2)) {
			return (true);
		} else {
			return (false);
		}
	}

}

class cadastro_pre {

	var $js = '';

	var $tabela = 'cad_pessoa';
	var $tabela_referencia = 'cad_referencia';
	var $tabela_referencia_tipo = 'cad_referencia_tipo';
	var $tabela_endereco = 'cad_endereco';
	var $tabela_complemento = 'cad_complemento';
	var $tabela_telefone = 'cad_telefone';
	var $tabela_contato = 'cad_contato';

	var $id = '';
	var $cpf = '';
	var $cliente = '';
	var $seq = '';
	var $nome = '';
	var $mae = '';
	var $nasc = '';
	var $status = '';
	var $line = '';
	var $latC = 0; 
	var $longC = 0;
	var $rua = '';
	var $cep = '';
	var $cidade = '';
	var $rua_num = '';
	var $bairro = '';
	var $propaganda1 = '';
	var $propaganda2 = '';

	var $referencias = array();

	var $id_cmp = '';
	var $line_cmp = '';

	var $line_contato = '';
	var $image_status;

	var $total_result = 0;

	/**Em processo cadastro(geral BD)*/
	var $tt_geral_Z = 0;
	/**Aprovados(geral BD)*/
	var $tt_geral_A = 0;
	/**Em analise(geral BD)*/
	var $tt_geral_T = 0;
	/**Para correcao(geral BD)*/
	var $tt_geral_C = 0;
	/**Recusados(geral BD)*/
	var $tt_geral_R = 0;
	/**Aprovados que nunca pegaram produtos(geral BD)*/
	var $tt_geral_S = 0;

	/**Em cadastro(mensal BD)*/
	var $tt_mensal_Z = 0;
	/**Aprovados(mensal BD)*/
	var $tt_mensal_A = 0;
	/**Em analise(mensal BD)*/
	var $tt_mensal_T = 0;
	/**Para correção(mensal BD)*/
	var $tt_mensal_C = 0;
	/**Recusados(mensal BD)*/
	var $tt_mensal_R = 0;
	/**Aprovados que nunca pegaram produtos(mensal BD)*/
	var $tt_mensal_S = 0;

	/** array total de status mesnal, semanal e diario
	 *  --posição TT do indice da o total geral dos status--
	 */
	var $statusTT_d = array('@' => 0, 'A' => 0, 'T' => 0, 'R' => 0, 'TT' => 0);
	var $statusTT_w = array('@' => 0, 'A' => 0, 'T' => 0, 'R' => 0, 'TT' => 0);
	var $statusTT_m = array('@' => 0, 'A' => 0, 'T' => 0, 'R' => 0, 'TT' => 0);

	var $class_include = '../../';
	var $class_include_db = '../../_db/';

	
	function mostra_nome($sty = '') {
		$sx .= '<div class="lt3 border1 radius5 pad5 ' . $sty . '">';
		$sx .= '<div class="right">' . $this -> mostra_idade($this -> nasc) . ' anos</div>';
		$sx .= $this -> nome;
		$sx .= '</div>';
		return ($sx);
	}

	function mostra_idade($dds) {
		$n = mktime(0, 0, 0, substr($dds, 4, 2), substr($dds, 6, 2), substr($dds, 0, 4));
		$a = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
		$r = (int)((time() - $n) / 31556926);
		return ($r);
	}

	function mostra_cpf($cpf) {
		$cpf = sonumero($cpf);
		$cpf = strzero($cpf, 11);
		$cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
		return ($cpf);
	}

	function mostra_genero($genero) {
		switch($genero) {
			case 'M' :
				$genero = 'Masculino';
				$genero_img = '';
				break;
			case 'F' :
				$genero = 'Feminino';
				$genero_img = '';
				break;
			default :
				$genero = 'NC';
				$genero_img = '';
				break;
		}
		$this -> genero_img = $genero_img;
		return ($genero);
	}

	function mostra() {
		global $editar;
		$sx = '<div  class="gray border1 pad5">';
		$sx .= '<table width="100%">';
		$sx .= '<tr><td colspan="2" width="50%" valign="top" class="lt3" >'.$this -> line['pes_cliente'].' - ' . trim($this -> nome) . '</td>';
		$sx .= '	<td rowspan="2" width="50%" align="right">Status:'.$this -> mostra_status($this -> line['pes_status']).'<br>
						<img src="' . $this -> image_status . '" height="60"></td>';
		$sx .= '</tr>';
		$sx .= '<tr><td width="33%" class="lt2">Dt. Cadastro: <b>' . stodbr($this -> line['pes_data']) .' ('.$this -> line['pes_log']. ')</b></td>';
		$sx .= '	<td width="33%" class="lt2">Dt. Atualizacao: <b>' . stodbr($this -> line['pes_lastupdate']) .' ('.$this -> line['pes_lastupdate_log']. ')</b></td></tr>';
		$sx .= '<tr><td width="33%" class="lt2">Idade: <b>' . $this -> mostra_idade($this -> nasc) . ' anos</b></td>';
		$sx .= '	<td width="33%" class="lt2">Dt. Nascimento: <b>' . stodbr($this -> nasc) . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Genero: <b>' . $this -> mostra_genero($this -> line['pes_genero']) . '</b></td></tr>';
		$sx .= '<tr><td width="33%" class="lt2">CPF: <b>' . $this -> mostra_cpf($this -> cpf) . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">RG: <b>' . $this -> line['pes_rg'] . '</b></td></tr>';
		$sx .= '<tr><td width="33%" class="lt2">Mae: <b>' . $this -> line['pes_mae'] . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Pai: <b>' . $this -> line['pes_pai'] . '</b></td></tr>';
		$sx .= '<tr><td width="100%" colspan="2" class="lt2">E-mail: <b>' . $this -> line_cmp['cmp_email'] . '</b></td></tr>';
		$sx .= '<tr><td class="lt2" colspan="4">Observações :<br> <b>'. $this->line_cmp['cmp_obs'] . '</b></td></tr>';
		$sx .= '</table>';
		$sx .= '</div>';
		return ($sx);
	}

	function le($id) {
		$sql = "select * from " . $this -> tabela . " where id_pes = " . round($id) . " or pes_cliente = '" . $id . "' ";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> line = $line;
			$this -> nome = trim($line['pes_nome']);
			$this -> cpf = trim($line['pes_cpf']);
			$this -> cliente = trim($line['pes_cliente']);
			$_SESSION['cad_cliente'] = $this -> cliente;
			$this -> nasc = $line['pes_nasc'];
			$this -> status = $line['pes_status'];
			$this->le_complemento($line['pes_cliente']);
			return (1);
		}else{
			return(0);
		}
	}
	
	function le_complemento($id){
		$sql = "select * from " . $this->tabela_complemento . " 
				where cmp_cliente = '" . $id . "' and 
						cmp_cliente_seq = '00' ";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> line_cmp = $line;
			$this -> propaganda1 = $line['cmp_propaganda'];
			$this -> propaganda2 = $line['cmp_propaganda2'];
			return (1);
		}else{
			return(0);
		}
		
	}
	function busca_nome($nome = '', $cpf = '') {
		$this -> erro = '';
		$ok = 0;
		if (strlen($cpf) > 0) {
			if (cpf($cpf) == 1) {
				$sql = "select * from " . $this -> tabela . " 
										where pes_cpf = '" . sonumero($cpf) . "' ";
				$ok = 1;
			} else {
				$this -> erro .= 'CPF Inválido';
			}
		}
		
		if ((strlen($nome) > 0) and ($ok == 0)) {
			$ok = 1;
			$sql = "select * from " . $this -> tabela . " 
								where pes_nome like '%" . UpperCaseSql($nome) . "%'
								order by pes_nome 
								limit 100
								";
		}
		
		if ($ok == 1) {
			
			$rlt = db_query($sql);
			$id = 0;
			$sx = '<table class="tabela00 lt3" width="98%" align="center">';
			$sx .= '<TR><TH>Nome<TH>CPF<TH>Codigo<TH>Dt. Nascimento<TH>Situação</TR>';
			$tot = 0;
			while ($line = db_read($rlt)) {
				$tot++;
				$sx .= $this -> mostra_cliente_linha($line);
			}
			$sx .= '</table>';
			$this -> total_result = $tot;
			if ($tot == 0) { $sx = '';
			}
		}
		return ($sx);
	}

	function mostra_status($st) {
		global $http;
		switch ($st) {
			case '@' :
				$sx = '<font color="green">em cadastro</font>';
				$img = $http . 'img/icone_precad_cadastro.png';
				break;
			case 'K' :
				$sx = '<font color="green">aguardando documentação</font>';
				$img = $http . 'img/icone_precad_aprovado.png';
				break;				
			case 'A' :
				$sx = '<font color="green">aprovado</font>';
				$img = $http . 'img/icone_precad_aprovado.png';
				break;
			case 'R' :
				$sx = '<font color="red">recusado</font>';
				$img = $http . 'img/icone_precad_recusado.png';
				break;
			case 'E' :
				$sx = '<font color="green">comunicar liberação</font>';
				$img = $http . 'img/icone_precad_comunicar_aprovacao.png';
				break;
			case 'T' :
				$sx = '<font color="blue">em análise</font>';
				$img = $http . 'img/icone_precad_analise.png';
				break;
			case 'F' :
				$sx = '<font color="red">comunicar recusa</font>';
				$img = $http . 'img/icone_precad_comunicar_recusa.png';
				break;	
		}
		$this -> image_status = $img;
		return ($sx);
	}

	function mostra_cliente_linha($line) {
		global $http;
		$link = '<A HREF="pre_cliente_ver.php?dd0=' . $line['pes_cliente'] . '">';
		$sx .= '<TR>';
		$sx .= '<TD>';
		$sx .= $line['pes_nome'];
		$sx .= '<TD align="center">';
		$sx .= $line['pes_cpf'];
		$sx .= '<TD align="center">';
		$sx .= $line['pes_cliente'];
		$sx .= '<TD align="center">';
		$sx .= stodbr($line['pes_nasc']);
		$sx .= '<TD align="center">';
		$sx .= $this -> mostra_status($line['pes_status']);
		$sx .= '<TD align="center">';
		$sx .= $link;
		$sx .= '<img src="' . $http . 'img/icone_view.png" height="18" title="ver dados do cliente" border=0 >';
		$sx .= '</A>';
		$sx .= '</td>';
		return ($sx);
	}

	function formulario_de_busca($width=98) {
		global $dd, $acao;
		$sx .= '<form method="get" action="pre_cadastro.php">
						<div class="pad5 radius10" style="background-color: #F0F0F0; width:'.$width.'%;">
						<table width="100%" border=0 class="tabela00">
							<tr><td rowspan="8"><img src="../img/imgboxcad.png" width="200"></td></tr>
							<TR>
							<TD class="lt1">NOME DE BUSCA
							<tr>
							<TR>
							<td><input type="text" id="dd1" name="dd1" value="' . $dd[1] . '" style="width: 90%;" size="100" class="precad_form_string">
							<TR>
							<TD class="lt1">CPF DE BUSCA
							<TR>
							<td><input type="text" id="dd2" name="dd2" value="' . $dd[2] . '" size="15"  class="precad_form_string">							
							<TR>
							<td>
							<input type="submit" name="acao" value="buscar"  class="precad_form_submit">
						</table>
					</div>
					</form>
					';
		return ($sx);
	}

	function mostra_informacoes_uteis() {
		$this -> obtem_quantidade_por_status_semana();
		$this -> obtem_quantidade_por_status_dia();
		$this -> obtem_quantidade_por_status_mes();

		$onclickTT_d = '<a class="cursor" onclick="lista_status_pre_cad(\'TT\',\'LISTA_D\' );" >';
		$onclickTT_w = '<a class="cursor" onclick="lista_status_pre_cad(\'TT\',\'LISTA_W\' );" >';
		$onclickTT_m = '<a class="cursor" onclick="lista_status_pre_cad(\'TT\',\'LISTA_M\' );" >';

		$onclickR_d = '<a class="cursor" onclick="lista_status_pre_cad(\'R\',\'LISTA_D\' );" >';
		$onclickR_w = '<a class="cursor" onclick="lista_status_pre_cad(\'R\',\'LISTA_W\' );" >';
		$onclickR_m = '<a class="cursor" onclick="lista_status_pre_cad(\'R\',\'LISTA_M\' );" >';

		$onclickT_d = '<a class="cursor" onclick="lista_status_pre_cad(\'T\',\'LISTA_D\' );" >';
		$onclickT_w = '<a class="cursor" onclick="lista_status_pre_cad(\'T\',\'LISTA_W\' );" >';
		$onclickT_m = '<a class="cursor" onclick="lista_status_pre_cad(\'T\',\'LISTA_M\' );" >';

		$onclickA_d = '<a class="cursor" onclick="lista_status_pre_cad(\'A\',\'LISTA_D\' );" >';
		$onclickA_w = '<a class="cursor" onclick="lista_status_pre_cad(\'A\',\'LISTA_W\' );" >';
		$onclickA_m = '<a class="cursor" onclick="lista_status_pre_cad(\'A\',\'LISTA_M\' );" >';

		$onclickY_d = '<a class="cursor" onclick="lista_status_pre_cad(\'@\',\'LISTA_D\' );" >';
		$onclickY_w = '<a class="cursor" onclick="lista_status_pre_cad(\'@\',\'LISTA_W\' );" >';
		$onclickY_m = '<a class="cursor" onclick="lista_status_pre_cad(\'@\',\'LISTA_M\' );" >';
		
		$onclickE_d = '<a class="cursor" onclick="lista_status_pre_cad(\'E\',\'LISTA_D\' );" >';
		$onclickE_w = '<a class="cursor" onclick="lista_status_pre_cad(\'E\',\'LISTA_W\' );" >';
		$onclickE_m = '<a class="cursor" onclick="lista_status_pre_cad(\'E\',\'LISTA_M\' );" >';
		
		$onclickF_d = '<a class="cursor" onclick="lista_status_pre_cad(\'F\',\'LISTA_D\' );" >';
		$onclickF_w = '<a class="cursor" onclick="lista_status_pre_cad(\'F\',\'LISTA_W\' );" >';
		$onclickF_m = '<a class="cursor" onclick="lista_status_pre_cad(\'F\',\'LISTA_M\' );" >';

		$sx .= '
					<div valign="top" >
					<table width="98%"  valign="top"><tr><td width="10%" valign="top">
						<div class="pad1 radius10" style="background-color: #F0F0F0; width:190px;">
							<table width="100%" border=0 class="tabela00">
								<TR>
								<TD class="lt1" colspan=3  align="center"><B>Geral</B></td>
								</TR>
								<TR class="lt1" align="center">
								<TD>no dia
								<TD>na semana
								<TD>no mês
								</TR>
								<TR class="lt3" align="center">
								<TD>' .$onclickTT_d. round($this -> statusTT_d['TT']) . '
								<TD>' .$onclickTT_w. round($this -> statusTT_w['TT']) . '
								<TD>' .$onclickTT_m. round($this -> statusTT_m['TT']) . '
							</table>
						</div>
						<div class="pad1 radius10" style="background-color: #F0F0F0; width:190px;">
							<table width="100%" border=0 class="tabela00">
								<TR>
								<TD class="lt1" colspan=3  align="center"><B>Aprovados</B></td>
								</TR>
								<TR class="lt1" align="center">
								<TD>no dia
								<TD>na semana
								<TD>no mês
								</TR>
								<TR class="lt3" align="center">
								<TD>' .$onclickA_d. round($this -> statusTT_d['A']) . '
								<TD>' .$onclickA_w. round($this -> statusTT_w['A']) . '
								<TD>' .$onclickA_m. round($this -> statusTT_m['A']) . '
							</table>
						</div>
						<div class="pad1 radius10" style="background-color: #F0F0F0; width:190px;">
							<table width="100%" border=0 class="tabela00">
								<TR>
								<TD class="lt1" colspan=3  align="center"><B>Analise</B></td>
								</TR>
								<TR class="lt1" align="center">
								<TD>no dia
								<TD>na semana
								<TD>no mês
								</TR>
								<TR class="lt3" align="center">
								<TD>' .$onclickT_d. round($this -> statusTT_d['T']) . '
								<TD>' .$onclickT_w. round($this -> statusTT_w['T']) . '
								<TD>' .$onclickT_m. round($this -> statusTT_m['T']) . '
							</table>
						</div>
						<div class="pad1 radius10" style="background-color: #F0F0F0; width:190px;">
							<table width="100%" border=0 class="tabela00">
								<TR>
								<TD class="lt1" colspan=3  align="center"><B>Edição</B></td>
								</TR>
								<TR class="lt1" align="center">
								<TD>no dia
								<TD>na semana
								<TD>no mês
								</TR>
								<TR class="lt3" align="center">
								<TD>' .$onclickY_d. round($this -> statusTT_d['@']) . '</a>
								<TD>' .$onclickY_w. round($this -> statusTT_w['@']) . '</a>
								<TD>' .$onclickY_m. round($this -> statusTT_m['@']) . '</a>
							</table>
						</div>
						<div class="pad1 radius10" style="background-color: #F0F0F0; width:190px;">
							<table width="100%" border=0 class="tabela00">
								<TR>
								<TD class="lt1" colspan=3  align="center"><B>Recusados</B></td>
								</TR>
								<TR class="lt1" align="center">
								<TD>no dia
								<TD>na semana
								<TD>no mês
								</TR>
								<TR class="lt3" align="center">
								<TD>' .$onclickR_d. round($this -> statusTT_d['R']) . '
								<TD>' .$onclickR_w. round($this -> statusTT_w['R']) . '
								<TD>' .$onclickR_m. round($this -> statusTT_m['R']) . '
							</table>
						</div>
						<div class="pad1 radius10" style="background-color: #F0F0F0; width:190px;">
							<table width="100%" border=0 class="tabela00">
								<TR>
								<TD class="lt1" colspan=3  align="center"><B>Comunicar Aprovação</B></td>
								</TR>
								<TR class="lt1" align="center">
								<TD>no dia
								<TD>na semana
								<TD>no mês
								</TR>
								<TR class="lt3" align="center">
								<TD>' .$onclickE_d. round($this -> statusTT_d['E']) . '
								<TD>' .$onclickE_w. round($this -> statusTT_w['E']) . '
								<TD>' .$onclickE_m. round($this -> statusTT_m['E']) . '
							</table>
						</div>
						<div class="pad1 radius10" style="background-color: #F0F0F0; width:190px;">
							<table width="100%" border=0 class="tabela00">
								<TR>
								<TD class="lt1" colspan=3  align="center"><B>Comunicar Recusa</B></td>
								</TR>
								<TR class="lt1" align="center">
								<TD>no dia
								<TD>na semana
								<TD>no mês
								</TR>
								<TR class="lt3" align="center">
								<TD>' .$onclickF_d. round($this -> statusTT_d['F']) . '
								<TD>' .$onclickF_w. round($this -> statusTT_w['F']) . '
								<TD>' .$onclickF_m. round($this -> statusTT_m['F']) . '
							</table>
						</div>
					</td>
					<td width="75%" valign="top">
						<center><div id="lista_status_pre_cad"  class="scroll500 radius10"  style="background-color: #F0F0F0;"></div></center>
					</td>
					</table>
					</div>
					<script> 
					$( document ).ready(function() {
						lista_status_pre_cad(\'@\',\'LISTA_M\' );
					});
					</script>
					';
		return ($sx);
	}

	function lista_status_dia($st) {
		$dt = date('Ymd');
		  
		if($st!='TT'){ 
			if (strlen(trim($st))>0) {
					$stx  = " and pes_status = '".$st."'";
			}
		}
		
		
		$sql = " select * 
				from " . $this -> tabela . "
				where 	pes_lastupdate = " . $dt .$stx. " 
		";
		$rlt = db_query($sql);
		$sx = '';
		$sx .= '<table width=100% class="pad5" style="background-color: #F0F0F0;overflow:scroll;">';
		$sx .= "<tr><th align=left><h2>Cadastros do dia - ".$this->status($st)."</h2></th></tr>";
		$sx .= "<tr>";
		$sx .= "<th align=center width=5>Data</th>";
		$sx .= "<th align=center width=5>Codigo</th>";
		$sx .= "<th align=left width=60>Nome</th>";
		$sx .= "<th align=center width=10>CPF</th>";
		$sx .= "<th align=center width=5>Status</th>";
		$sx .= "<th align=center width=5>Log</th>";
		$sx .= "<th align=center width=10>Acao</th>";
		$sx .= "</tr>";
		while ($line = db_read($rlt)) {
			$cl = $line['pes_cliente'];
			$link = '<a title="Resumo" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_view.png"></a>';
			$link1 = '<a title="Pontuacao" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_pontos.png"></a>';
			$sx .= "<tr>";
			$sx .= "<td align=center>" . stodbr($line['pes_data']) . "</td>";
			$sx .= "<td align=center>" . $line['pes_cliente'] . "</td>";
			$sx .= "<td align=left>" . $line['pes_nome'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_cpf'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_status'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_log'] . "</td>";
			$sx .= '<td align=center>'.$link.$link1.'</td>';
			$sx .= "</tr>";
		}
		$sx .= "</table>";
		return($sx);
	}
	
	function lista_status_mes($st) {
		/*mes*/
		$mes = date('Ym');
		$dt1 = $mes . '01';
		$dt2 = $mes . '32';
		
		if($st!='TT'){ 
			if (strlen(trim($st))>0) {
					$stx  = " and pes_status = '".$st."'";
			}
		}
			
		
		$sql = " select * 
				from " . $this -> tabela . "
				where 	pes_lastupdate >= " . $dt1 . " and 
						pes_lastupdate <= " . $dt2 . $stx."
		";
		
		$rlt = db_query($sql);
		$sx = '';
		$sx .= '<table width=100% class="pad5" style="background-color: #F0F0F0;">';
		$sx .= "<tr><th colspan=6 align=left><h2>Cadastros do mes - ".$this->status($st)."</h2></th></tr>";
		$sx .= "<tr>";
		$sx .= "<th align=center width=5>Data</th>";
		$sx .= "<th align=center width=5>Codigo</th>";
		$sx .= "<th align=left width=60>Nome</th>";
		$sx .= "<th align=center width=10>CPF</th>";
		$sx .= "<th align=center width=5>Status</th>";
		$sx .= "<th align=center width=5>Log</th>";
		$sx .= "<th align=center width=10>Acao</th>";
		$sx .= "</tr>";
		while ($line = db_read($rlt)) {
			$cl = $line['pes_cliente'];
			$link = '<a title="Resumo" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_view.png"></a>';
			$link1 = '<a title="Pontuacao" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_pontos.png"></a>';
			$sx .= "<tr>";
			$sx .= "<td align=center>" . stodbr($line['pes_data']) . "</td>";
			$sx .= "<td align=center>" . $line['pes_cliente'] . "</td>";
			$sx .= "<td align=left>" . $line['pes_nome'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_cpf'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_status'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_log'] . "</td>";
			$sx .= '<td align=center>'.$link.$link1.'</td>';
			$sx .= "</tr>";
		}
		$sx .= "</table>";
		return ($sx);
		}

	function lista_status_semana($st) {
		$d = date('d');
		$m = date('m');
		$y = date('Y');

		/*mes*/
		$mes = date('Ym');
		$dt1 = $mes . '01';
		$dt2 = $mes . '32';

		/*semana*/
		$w = date('w');
		/***1º dia da semana*/
		$dt1_w = date('Ymd', mktime(0, 0, 0, $m, $d - $w, $y));
		/***ultimo dia da semana*/
		$dt2_w = date('Ymd', mktime(0, 0, 0, $m , ($d - $w)+6, $y));

		if($st!='TT'){ 
			if (strlen(trim($st))>0) {
					$stx  = " and pes_status = '".$st."'";
			}
		}
		
		$sql = " select * 
				from " . $this -> tabela . "
				where 	(pes_data >= " . $dt1 . " and pes_data <= " . $dt2 . ") and
						(pes_data >= " . $dt1_w . " and pes_data <= " . $dt2_w . ") ".$stx." 
		";
		$rlt = db_query($sql);
		$sx = '';
		$sx .= '<table width=100% class="pad5" style="background-color: #F0F0F0;overflow:scroll;">';
		$sx .= "<tr><th colspan=6 align=left><h2>Cadastros da semana - ".$this->status($st)."</h2></th>";
		$sx .= "<tr>";
		$sx .= "<th align=center width=5>Data</th>";
		$sx .= "<th align=center width=5>Codigo</th>";
		$sx .= "<th align=left width=60>Nome</th>";
		$sx .= "<th align=center width=10>CPF</th>";
		$sx .= "<th align=center width=5>Status</th>";
		$sx .= "<th align=center width=5>Log</th>";
		$sx .= "<th align=center width=10>Acao</th>";
		$sx .= "</tr>";

		while ($line = db_read($rlt)) {
			$cl = $line['pes_cliente'];
			$link = '<a title="Resumo" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_view.png"></a>';
			$link1 = '<a title="Pontuacao" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_pontos.png"></a>';
			$sx .= "<tr>";
			$sx .= "<td align=center>" . $line['pes_data'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_cliente'] . "</td>";
			$sx .= "<td align=left>" . $line['pes_nome'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_cpf'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_status'] . "</td>";
			$sx .= "<td align=center>" . $line['pes_log'] . "</td>";
			$sx .= '<td align=center>'.$link.$link1.'</td>';
			$sx .= "</tr>";
		}
		$sx .= "</table>";
		return ($sx);
	}

	function obtem_quantidade_por_status_semana() {
		$d = date('d');
		$m = date('m');
		$y = date('Y');

		/*mes*/
		$mes = date('Ym');
		$dt1 = $mes . '01';
		$dt2 = $mes . '32';

		/*semana*/
		$w = date('w');
		/***1º dia da semana*/
		$dt1_w = date('Ymd', mktime(0, 0, 0, $m, $d - $w, $y));
		/***ultimo dia da semana*/
		$dt2_w = date('Ymd', mktime(0, 0, 0, $m , ($d - $w)+6, $y));

		$sql = " select pes_status as status, count(pes_status) as total 
				from " . $this -> tabela . "
				where 	(pes_lastupdate >= " . $dt1 . " and pes_lastupdate <= " . $dt2 . ") and
						(pes_lastupdate >= " . $dt1_w . " and pes_lastupdate <= " . $dt2_w . ") 
				group by pes_status		 
		";
		$rlt = db_query($sql);
		$tt = 0;
		while ($line = db_read($rlt)) {
			$this -> statusTT_w[$line['status']] = $line['total'];
			$tt += $line['total'];
		}
		$this -> statusTT_w['TT'] = $tt;
		return (1);
	}

	function obtem_quantidade_por_status_mes() {
		/*mes*/
		$mes = date('Ym');
		$dt1 = $mes . '01';
		$dt2 = $mes . '32';
		$sql = " select pes_status as status, count(pes_status) as total 
				from " . $this -> tabela . "
				where 	pes_lastupdate >= " . $dt1 . " and 
						pes_lastupdate <= " . $dt2 . "
				group by pes_status		 
		";
		$rlt = db_query($sql);
		$tt = 0;
		while ($line = db_read($rlt)) {
			$this -> statusTT_m[$line['status']] = $line['total'];
			$tt += $line['total'];
		}
		$this -> statusTT_m['TT'] = $tt;
		return (1);
	}

	function obtem_quantidade_por_status_dia() {
		$dt = date('Ymd');
		$sql = " select pes_status as status, count(pes_status) as total 
				from " . $this -> tabela . "
				where 	pes_lastupdate = " . $dt . " 
				group by pes_status		 
		";
		$rlt = db_query($sql);
		$tt = 0;
		while ($line = db_read($rlt)) {
			$this -> statusTT_d[$line['status']] = $line['total'];
			$tt += $line['total'];
		}
		$this -> statusTT_d['TT'] = $tt;
		return (1);
	}

	function mostra_tipo_telefone($tp) {
		switch ($tp) {
			case 'C' :
				$tipo = 'Comercial';
				break;
			case 'M' :
				$tipo = 'Celular';
				break;
			case 'E' :
				$tipo = 'Recado';
				break;
			case 'R' :
				$tipo = 'Residencial';
				break;
			default :
				$tipo = 'Não identificado';
				break;
		}
		return ($tipo);
	}

	function valida_cor($tp) {
		switch ($tp) {
			case '1' :
				$bgcolor = 'green_light';
				break;
			case '9' :
				$bgcolor = 'red_light';
				break;
			case '0' :
				$bgcolor = 'orange_light';
				break;
			default :
				$bgcolor = 'grey';
				break;
		}
		return ($bgcolor);
	}

	function formata_telefone($tel, $ddd = '') {
		global $http;
		if (strlen($ddd) > 0) { $ddd = '(' . trim($ddd) . ') ';
		}
		$num = sonumero($tel);
		$pre = (substr($num, 0, 1));
		if (($pre == '9') or ($pre == '8') or ($pre == '7')) { $img = $http . 'img/icone_phone_cell.png';
		} else { $img = $http . 'img/icone_phone_fix.png';
		}
		$img = '<img src="' . $img . '" height="18" border=0>';
		if (strlen($num) == 9) { $num = substr($num, 0, 5) . '-' . substr($num, 5, 4);
		}
		if (strlen($num) == 8) { $num = substr($num, 0, 4) . '-' . substr($num, 4, 4);
		}
		return ($img . $ddd . $num);
	}

	function insere_endereco($rua, $numero, $complemento, $cep, $bairro, $cidade, $estado = 'PR',$long=0, $lat=0) {
		$cliente = $this -> cliente;
		$cep = sonumero($cep);
		$data = date("Ymd");
		$cidade = uppercase($cidade);
		$status = '1';
		$sql = "select * from " . $this -> tabela_endereco . " 
						where end_cliente = '" . $cliente . "'
							and end_rua = '" . $rua . "'
							and end_numero = '" . $numero . "'";
		$rlt = db_query($sql);

		if ($line = db_read($rlt)) {
			
		} else {
			$data = date("Ymd");
			$seq = "00";
			$sql = "insert into " . $this -> tabela_endereco . " 
					(
					end_cliente, end_rua, end_numero, 
					end_complemento, end_bairro, end_cidade,
					end_estado, end_cep, end_latitude, end_longitude,
					end_status, end_data, end_validado
					) values (
					'$cliente','$rua','$numero',
					'$complemento','$bairro','$cidade',
					'$estado','$cep','$lat','$long',
					'$status',$data,0
					)";
			$rrr = db_query($sql);
			$login = $_SESSION['nw_user'];
			$acao_log = "105 - INSERIU NOVO ENDERECO";
			$acao_cod = '105';
			$this->inserir_log($cliente, $login, $acao_log, $acao_cod, $status);
		}
		
	}

	function insere_telefone($ddd, $telefone, $tipo) {
		$cliente = $this -> cliente;
		$telefone = sonumero($telefone);
		$status = 1;
		$sql = "select * from " . $this -> tabela_telefone . " 
						where tel_cliente = '" . $cliente . "'
							and tel_numero = '" . $telefone . "'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {

		} else {
			$data = date("Ymd");
			$seq = "00";
			$sql = "insert into " . $this -> tabela_telefone . " 
					(
					tel_cliente, tel_cliente_seq, tel_ddd,
					tel_numero, tel_tipo, tel_data, 
					tel_validado, tel_status
					) values (
					'$cliente','$seq','$ddd',
					'$telefone','$tipo',$data,
					0,$status
					)";
			$rrr = db_query($sql);
			$login = $_SESSION['nw_user'];
			$acao_log = "115 - INSERIU NOVO TELEFONE";
			$acao_cod= '115';
			$this->inserir_log($cliente, $login, $acao_log, $acao_cod, $status);
		}
	}

	function lista_telefone_adiciona($edit=0) {
		global $http;

		if ($edit == 1) {
			$id = 'pre_telefone';
			$sx .= '<div id="' . $id . '_field" class="left radius5 margin5 pad5 border1 ' . $bgcor . '">';
			$sx .= '<img id="' . $id . '" src="' . $http . 'img/icone_phone_add.png" height="30" title="adicionar novo contato">';
			$sx .= '</div>';

			$form_ajax = new form;
			$sx .= $form_ajax -> active($id, $this -> cliente, 'NEW');
		}
		return ($sx);
	}

	function lista_telefone_mostra($cliente, $edit = 0) {
		$this -> cliente = $cliente;
		$sx .= $this -> lista_telefone_cadastrado();
		
		if ($edit == 1) {
			 $sx .= $this -> lista_telefone_adiciona($edit);
		}
		return ($sx);
	}

	function formata_cep($cep) {
		$cep = sonumero($cep);
		$cep = strzero($cep, 8);
		$cep = substr($cep, 0, 2) . '.' . substr($cep, 2, 3) . '-' . substr($cep, 5, 3);
		return ($cep);
	}

	function lista_endereco_cadastrado() {
		$sql = "select * from " . $this -> tabela_endereco . " 
					where end_cliente = '" . $this -> cliente . "' 
					order by end_data desc ";
		$rlt = db_query($sql);

		while ($line = db_read($rlt)) {
			$val = $line['end_validado'];
			$sta = $line['end_status'];
			$id = $line['id_end'];
			
			$bgcor = $this -> valida_cor($val);

			$sx .= '<div class="left radius5 margin5 pad5 border1 ' . $bgcor . '" style="width: 500px;">';
			$sx .= '<font class="lt0">endereco</font>';
			$sx .= '<span onclick="newwin2(\'pre_enderecos_ed_popup.php?dd0='.$id.'&dd90='.checkpost($id).'\',400,400);">  <img src="../img/icone_editar.gif" width="16px"></span>';
			$sx .= '<BR>';
			$sx .= $line['end_rua'];
			$sx .= ', ' . $line['end_numero'];
			if (strlen(trim($line['end_complemento'])) > 0) {
				$sx .= ' ' . $line['end_complemento'];
			}
			$sx .= '<BR>';
			$sx .= $this -> formata_cep($line['end_cep']);
			$sx .= ' ' . $line['end_bairro'];
			$sx .= '<BR>' . $line['end_cidade'];
			$sx .= '-' . $line['end_estado'];
			$sx .= '<BR>' . $line['end_complemento'];
			$sx .= '</div>';
		}
		return ($sx);
	}
	function ultimo_endereco_cliente(){
		$sql = "select * from " . $this -> tabela_endereco . " 
					where end_cliente = '" . $this -> cliente . "' 
					order by end_data desc 
					limit 1";
		$rlt = db_query($sql);

		while ($line = db_read($rlt)) {
			$this->latC = $line['end_latitude'];
			$this->longC = $line['end_longitude'];
			$this->rua = $line['end_rua'];
			$this->cep = $line['end_cep'];
			$this->cidade = $line['end_cidade'];
			$this->estado = $line['end_estado'];
			$this->rua_num = $line['end_numero'];
			$this->bairro = $line['end_bairro'];
		}
		
		return($line);
	}
	function lista_endereco_adiciona($edit=0) {
		global $http,$edit_end;
		if ($edit == 1) {
			$id = 'pre_endereco';
			$sx .= '<div id="' . $id . '_field" class="left radius5 margin5 pad5 border1 ' . $bgcor . '">';
			$sx .= '<img id="' . $id . '" src="' . $http . 'img/icone_address_add.png" height="40" title="adicionar novo endereco">';
			$sx .= '</div>';

			$form_ajax = new form;
			$sx .= $form_ajax -> active($id, $this -> cliente, 'NEW');
		}
		return ($sx);
	}

	function lista_endereco_mostra($cliente, $edit = 0) {
		$this -> cliente = $cliente;
		$sx .= $this -> lista_endereco_cadastrado();
		if ($edit == 1) { $sx .= $this -> lista_endereco_adiciona($edit);
		}
		return ($sx);
	}

	function lista_endereco($edit = 0) {
		global $editar;
		$editar = $edit;
		$id = 'pre_endereco';
		$sx .= '<div id="' . $id . '_main">';
		$form = new form;
		$sx .= $form -> ajax_refresh($id, $this -> cliente, $editar);
		$sx .= '</div>';
		return ($sx);
	}

	/* REFERENCIA */
	function lista_referencia($edit = 0) {
		global $editar;
		$editar = $edit;
		$id = 'pre_referencia';
		$sx .= '<div id="' . $id . '_main">';
		$form = new form;
		$sx .= $form -> ajax_refresh($id, $this -> cliente, $editar);
		$sx .= '</div>';
		return ($sx);
	}

	function lista_referencia_mostra($cliente, $edit = 0) {
		$this -> cliente = $cliente;
		$sx .= $this -> lista_referencia_cadastrado();
		if ($edit == 1) 
			{
				$sx .= $this -> lista_referencia_adiciona($edit);
			}
		return ($sx);
	}

	function lista_referencia_cadastrado() {
		global $http;
		$sql = "select * from " . $this -> tabela_referencia . "
					left join  " . $this -> tabela_referencia . "_tipo on ret_codigo = ref_grau
					where ref_cliente = '" . $this -> cliente . "' 
					order by ref_data desc ";
		$rlt = db_query($sql);

		while ($line = db_read($rlt)) {
			$val = $line['ref_validado'];
			$sta = $line['ref_status'];
			$id = $line['id_ref'];
			$bgcor = $this -> valida_cor($val);

			$sx .= '<div class="left radius5 margin5 pad5 border1 ' . $bgcor . '" style="width:300px; height: 100px;">';

			/* Observacao */
			$obs = $line['ref_observacao'];
			if (strlen($obs) > 0) {
				$sx .= '<div class="right"><img src="' . $http . 'img/icon_observation.png" height="20" title="' . $obs . '"></div>';
			}

			$sx .= '<font class="lt0">referencia</font>';
			$sx .= '<span onclick="newwin2(\'pre_referencias_ed_popup.php?dd0='.$id.'&dd90='.checkpost($id).'\',400,400);">  <img src="../img/icone_editar.gif" width="16px"></span>';
			$sx .= '<BR>';
			$sx .= $line['ref_nome'];
			$sx .= '<BR>';
			$sx .= '<font class="lt0">' . trim($line['ret_nome']) . '&nbsp;</font>';
			$sx .= '<BR>';
			$sx .= $this -> formata_telefone($line['ref_numero'], $line['ref_ddd']);
			$sx .= '<BR>';
			$sx .= $this -> formata_telefone($line['ref_numero2'], $line['ref_ddd2']);
			$comercial = $line['ret_tipo'];
			if ($comercial == 'C') {
				$sx .= '<BR><font class="lt1 fnt_blue"><B>** COMERCIAL **</B>';
			}
			
			$sx .= '</div>';
		}
		return ($sx);
	}

	function lista_restrições(){
		$acp = new acp;
		$acp = '';
		return($sx);
	}

	function insere_referencia($nome, $ddd, $telefone, $obs, $data, $grau) {
		$cliente = $this -> cliente;
		$data = date("Ymd");
		$status = 1;
		$sql = "select * from " . $this -> tabela_referencia . " 
						where ref_cliente = '" . $cliente . "'
							and ref_ddd = '" . $ddd . "'
							and ref_numero = '" . $telefone . "'";
		$rlt = db_query($sql);

		if ($line = db_read($rlt)) {

		} else {
			$data = date("Ymd");
			$seq = "00";
			$sql = "insert into " . $this -> tabela_referencia . " 
					(
					ref_cliente, ref_nome, ref_cep, 
					ref_observacao, ref_data, ref_grau,
					ref_status, ref_ativo, ref_validado,
					ref_ddd, ref_numero
					) values (
					'$cliente','$nome','',
					'$obs',$data,'$grau',
					'$status','1','0',
					'$ddd','$telefone'
					)";
			$rrr = db_query($sql);
			$login = $_SESSION['nw_user'];
			$acao_log = "110 - INSERIU NOVA REFERENCIA";
			$acao_cod = '110';
			$this->inserir_log($cliente, $login, $acao_log, $acao_cod,$status);
		}
	}

	function lista_referencia_adiciona($edit=0) {
		global $http;
		if ($edit == 1) {
			$id = 'pre_referencia';
			$sx .= '<div id="' . $id . '_field" class="left radius5 margin5 pad5 border1 ' . $bgcor . '">';
			$sx .= '<img id="' . $id . '" src="' . $http . 'img/icone_ref_add.png" height="40" title="adicionar novo endereco">';
			$sx .= '</div>';

			$form_ajax = new form;
			$sx .= $form_ajax -> active($id, $this -> cliente, 'NEW');
		}
		return ($sx);
	}

	function lista_telefone($edit = 0) {
		$id = 'pre_telefone';
		$sx .= '<div id="' . $id . '_main">';
		$form = new form;
		$sx .= $form -> ajax_refresh($id, $this -> cliente, $edit);
		$sx .= '</div>';
		return ($sx);
	}

	function lista_telefone_cadastrado() {
		$sql = "select * from " . $this -> tabela_telefone . " 
					where tel_cliente = '" . $this -> cliente . "' 
					order by tel_data desc ";
		$rlt = db_query($sql);

		while ($line = db_read($rlt)) {
			$val = $line['tel_validado'];
			$sta = $line['tel_status'];
			$bgcor = $this -> valida_cor($val);
			$id = $line['id_tel'];
			$sx .= '<div class="left radius5 margin5 pad5 border1 ' . $bgcor . '">';
			$sx .= '<font class="lt0">telefone</font>';
			$sx .= '<span onclick="newwin2(\'pre_telefones_ed_popup.php?dd0='.$id.'&dd90='.checkpost($id).'\',400,400);">  <img src="../img/icone_editar.gif" width="16px"></span>';
			$sx .= '<BR>';
			$sx .= $this -> formata_telefone($line['tel_numero'], $line['tel_ddd']);
			$sx .= '<BR>';
			$sx .= $this -> mostra_tipo_telefone(trim($line['tel_tipo']));
			//$sx .= $line['tel_validado'];
			//$sx .= $line['tel_status'];
			$sx .= '</div>';
		}
		return ($sx);
	}

	function zerar_sessions_auxiliar() {
		$_SESSION['PG01_DD0'] = '';
		$_SESSION['PG02_DD0'] = '';
		$_SESSION['PG03_DD0'] = '';
	}

	function gerar_js() {
		$sx = '<script>';
		$sx .= $this -> js;
		$sx .= '</script>';

		return ($sx);
	}

	function inserir_cpf($cpf = '', $seq = '00') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $user;
		$date = date('Ymd');
		
		if (strlen(trim($this -> cliente)) > 0) { $set1 .= ', pes_cliente';
			$set2 .= ",'$this->cliente'";
		};
		
		if (strlen(trim($this -> nome)) > 0) { $set1 .= ', pes_nome';
			$set2 .= ",'$this->nome'";
		};
		if (strlen(trim($this -> nasc)) > 0) { $set1 .= ', pes_nasc';
			$set2 .= ",'$this->nasc'";
		};
		if (strlen(trim($this -> mae)) > 0) { $set1 .= ', pes_mae';
			$set2 .= ",'$this->mae'";
		};
		$sql = "insert into " . $this -> tabela . " 
					(pes_cliente_seq,pes_cpf,pes_data,
					  pes_status, pes_log, pes_lastupdate,
					  pes_lastupdate_log ".$set1.")
					values 
					('".$seq."','".$cpf."', ".$date.",
					  '@', '".$user->user_log."', ".$date.",
					  '".$user->user_log."' ".$set2." 
					)";
		$rlt = db_query($sql);
		$this -> updatex();
		$id = $this -> recupera_codigo_pelo_cpf($cpf);
		$cliente = $this->cliente;
		
		/*LOG*/
		$login = $_SESSION['nw_user'];
		$acao_log = "100 - INSERIU NOVA CONSULTORA";
		$acao_cod = '100';
		$status = '@';
		$this->inserir_log($cliente, $login, $acao_log,$acao_cod, $status);
		return ($id);

	}

	function verifica_se_existe_cliente($cpf){
		global $base_name, $base_server, $base_host, $base_user, $base, $conn,$include_db,$ip;
		
		$cpf = sonumero($cpf);
		$cpf = substr('000000' . $cpf, -11);
		$cpf = $this -> mask($cpf, '###.###.###-##');
		
		echo $sql = " select * from cadastro where cl_cpf='".$cpf."'";
		$rlt = db_query($sql);
		if($line = db_read($rlt)){
			$this->cliente = $line['cl_cliente'];
			return($this->cliente);
		}else{
			unset($this->cliente);
			return(0);
		}
		
	}	

	function recupera_codigo_pelo_cpf($cpf = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn,$include_db,$ip;
		
		$sql = "select * from " . $this -> tabela . " where pes_cpf = '" . $cpf . "'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> id = $line['id_pes'];
			$this -> cpf = $line['pes_cpf'];
			$this -> cliente = $line['pes_cliente'];
			$_SESSION['cad_cliente'] = $this -> cliente;
			$this -> nome = $line['pes_nome'];
			$this -> seq = $line['pes_cliente_seq'];
			$this -> line = $line;
			return ($line['pes_cliente']);
		} else {
			return (0);
		}
	}

	function recupera_dados_pelo_codigo($cliente = '', $seq = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;

		if (strlen(trim($cliente)) > 0) { $this -> cliente = $cliente;
		}
		if (strlen(trim($seq)) > 0) { $this -> seq = $seq;
		}
		$sql = "select * from " . $this -> tabela . "  
				where pes_cliente ='" . $this -> cliente . "' and 
					  pes_cliente_seq = '" . $this -> seq . "'
				";

		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> id = $line['id_pes'];
			$this -> cpf = $line['pes_cpf'];
			$this -> cliente = $line['pes_cliente'];
			$_SESSION['cad_cliente'] = $this -> cliente;
			$this -> nome = $line['pes_nome'];
			$this -> seq = $line['pes_cliente_seq'];
			$this -> line = $line;
			return ($line['pes_cliente']);
		} else {
			return (0);
		}
	}

	function recupera_referencia_pelo_codigo($cliente = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;

		if (strlen(trim($cliente)) > 0) {
			$this -> cliente = $cliente;
		}
		$sql = "select * from " . $this -> tabela_referencia . "  
					inner join " . $this -> tabela_referencia_tipo . " 
					on ret_codigo=ref_grau 
				 where ref_cliente ='" . $this -> cliente . "' and
					  ref_validado = 1
				";
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			array_push($this -> referencias, $line);
		}
		return (1);
	}

	function inserir_complemento() {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $user;

		$sql = "select * from " . $this -> tabela_complemento . " where cmp_cliente = '" . $this -> cliente . "' ";
		$rlt = db_query($sql);

		if ($line = db_read($rlt)) {
		} else {
			$sql = "INSERT INTO " . $this -> tabela_complemento . "
		(	
			cmp_cliente, cmp_cliente_seq, cmp_log, 
			cmp_data, cmp_status
		)VALUES(
			'$this->cliente' , '$this->seq', '$user->user_log', 
			" . date('Ymd') . ", 'A'
		)
		";
			$rlt = db_query($sql);
			$cliente = $this->cliente;
			/*LOG*/
			$login = $_SESSION['nw_user'];
			$acao_log = "120 - INSERIU NOVO COMPLEMENTO CONSULTORA";
			$acao_cod = '120';
			$status = '@';
			$this->inserir_log($cliente, $login, $acao_log, $acao_cod, $status);
		}
		return ($this -> recuperar_codigo_complemento());
	}

	function recuperar_codigo_complemento() {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;

		$sql = "select * from $this->tabela_complemento
				where cmp_cliente = '$this->cliente' and cmp_cliente_seq='$this->seq' 
		";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> id_cmp = $line['id_cmp'];
			$this -> line_cmp = $line;
		} else {
			if ((strlen(trim($this -> cliente)) > 0) and (strlen(trim($this -> seq)) > 0)) {
				$this -> inserir_complemento();
			}
		}
		return ($this -> id_cmp);
	}

	function recuperar_nome_da_seq($seq) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;

		$sql = "select * from $this->tabela_referencia_tipo
				where ret_codigo = '$seq' 
		";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$seq_nome = $line['ret_nome'];
		} else {
			$seq_nome = 'Tipo de referencia nao cadastrada, falar com TI';
		}
		return ($seq_nome);
	}
	
	function recupera_propaganda($id){
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;	
		require('../../_db/db_mysql_pre_cad.php');
		
		$sql = "select * from propagandas 
				where prop_codigo='".trim($id)."' 
				";
		$rlt = db_query($sql);
		
		if($line = db_read($rlt)){
			$sx = $line['prop_descricao'];
		}else{
			return('Não localizado');
		}

		return($sx);
	}
	function updatex() {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;
		$c = 'pes';
		$c1 = 'id_' . $c;
		$c2 = $c . '_cliente';
		$c3 = 6;
		$sql = "update " . $this -> tabela . " set $c2 = concat('7', lpad($c1,$c3,0))  where  ($c2='' or $c2 is null )";
		$rlt = db_query($sql);
		
		return (0);
	}

	//function cp_fone() {
		//$cp = array();
		/*0*///array_push($cp, array('$H8', '', '', False, True));
		/*1*///array_push($cp, array('$H8', '', 'cliente', False, True));
		/*2*///array_push($cp, array('$H8', '', 'seq', False, True));
		/*3*///array_push($cp, array('$S3', '', 'DDD', TRUE, True));
		/*4*///array_push($cp, array('$S15', '', 'Numero', False, True));
		/*5*///array_push($cp, array('$O : &C:Celular&F:Fixo', '', 'Tipo', False, True));
		/*6*///array_push($cp, array('$H8', '', 'data', False, True));
		/*7*///array_push($cp, array('$H8', '', 'status', False, True));
		/*8*///array_push($cp, array('$H8', '', 'validado', False, True));

		//return ($cp);
	//}
	
	function cp_telefone() {
		global $dd, $acao;
		$cp = array();
		array_push($cp, array('$H8', 'id_tel', '', False, True));
		array_push($cp, array('$H8', 'tel_cliente', '', True, True));
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$S2', 'tel_ddd', 'DDD', True, True));
		array_push($cp, array('$S9', 'tel_numero', 'Telefone', True, True));
		array_push($cp, array('$O : &M:Celular&R:Residencial&C:Comercial&E:Recado', 'tel_tipo', 'Tipo', True, True));
		return ($cp);
	}

	function cp_endereco() {
		global $dd;
		$cep = sonumero($dd[4]);
		if (strlen($cep) == 8) { $dd[4] = $cep;
			
		} else { $dd[4] == '';
		}
		
		$cp = array();
		/*0*/array_push($cp, array('$H8', 'id_end', '', False, True));
		/*1*/array_push($cp, array('$H8', 'end_cliente', '', False, True));
		/*2*/array_push($cp, array('$H8', '', '', False, True));
		/*3*/array_push($cp, array('$H8', '', '', False, True));
		/*4*/array_push($cp, array('$S10', 'end_cep', 'CEP', TRUE, True));
		/*5*/array_push($cp, array('$S100', 'end_rua', 'Endereco', True, True));
		/*6*/array_push($cp, array('$S10', 'end_numero', 'Numero', True, True));
		/*7*/array_push($cp, array('$S30', 'end_complemento', 'Complemento', False, True));
		/*8*/array_push($cp, array('$S30', 'end_bairro', 'Bairro', True, True));
		/*9*/array_push($cp, array('$S30', 'end_cidade', 'Cidade', True, True));
		/*10*/array_push($cp, array('$S2  ', 'end_estado', 'Estado', True, True));
		/*11*/array_push($cp, array('$O 0:Não validado&0:Validado', 'end_status', 'Validado', True, True));
		/*12*/array_push($cp, array('$O 1:Ativo&0:Inativo', 'end_status', 'Status', True, True));
		/*13*/array_push($cp, array('$H20', 'end_latitude', 'Latitude', False, True));
		/*14*/array_push($cp, array('$H20', 'end_longitude', 'Longitude', False, True));
		
		return ($cp);
	}

	function cp_referencia() {
		$cp = array();
		/*0*/array_push($cp, array('$H8', 'id_ref', '', False, True));
		/*1*/array_push($cp, array('$H8', 'ref_cliente', 'cliente', False, True));
		/*2*/array_push($cp, array('$H8', 'ref_cliente_seq', 'seq', False, True));
		/*3*/array_push($cp, array('$S30', 'ref_nome', 'Nome', true, True));
		/*4*/array_push($cp, array('$Q ret_nome:ret_codigo:select * from cad_referencia_tipo', 'ref_grau', 'Grau', True, True));
		/*5*/array_push($cp, array('$S3', 'ref_ddd', '1.DDD', TRUE, True));
		/*6*/array_push($cp, array('$S15', 'ref_numero', '1.Numero', true, True));
		/*7*/array_push($cp, array('$S3', 'ref_ddd2', '2.DDD', False, True));
		/*8*/array_push($cp, array('$S15', 'ref_numero2', '2.Numero', False, True));
		/*9*/array_push($cp, array('$T 40:5', 'ref_observacao', 'Observacao', False, True));
		/*10*/array_push($cp, array('$O 0:Não validado&0:Validado', 'ref_status', 'Validado', True, True));
		/*11*/array_push($cp, array('$O 1:Ativo&0:Inativo', 'ref_status', 'Status', True, True));
		

		return ($cp);
	}

	
	function cp_00() {
		$cp = array();
		/*0*/array_push($cp, array('$H8', '', '', False, True));
		/*1*/array_push($cp, array('$M', 'pes_cpf', 'CPF', False, True));
		/*2*/array_push($cp, array('$S15', '', '', TRUE, True));
		/*3*/array_push($cp, array('$B8', '', 'Consultar', False, True));
		return ($cp);
	}

	function cp_01() {
		$cp = array();
		$log = $_SESSION['nw_user'];
		/*0*/array_push($cp, array('$H8', 'pes_cliente', 'ID', False, True));
		/*0*/array_push($cp, array('$HV', '', '1', False, False));
		/*1*/array_push($cp, array('$S100', 'pes_nome', 'NOME COMPLETO', True, True));
		/*2*/array_push($cp, array('$D8', 'pes_nasc', 'DATA NASCIMENTO', True, True));
		/*3*/array_push($cp, array('$S30', 'pes_naturalidade', 'NATURALIDADE', True, True));
		/*4*/array_push($cp, array('$S15', 'pes_rg', 'RG', True, True));
		/*5*/array_push($cp, array('$O : &M:MASCULINO&F:FEMININO', 'pes_genero', 'GENERO', True, True));
		/*6*/array_push($cp, array('$S100', 'pes_pai', 'NOME DO PAI', True, True));
		/*7*/array_push($cp, array('$S100', 'pes_mae', 'NOME DA MÃE', True, True));
		///*8*/array_push($cp, array('$O : ' . "&S:SIM&N:NÃO", 'pes_avalista', 'POSSUI AVALISTA?', True, True));
		///*9*/array_push($cp, array('$S7', 'pes_avalista_cod', utf8_encode('Codigo AVALISTA'), True, True));
		/*10*/array_push($cp, array('$B8', '', 'Salvar', False, True));

		/*11*/array_push($cp, array('$HV', 'pes_lastupdate_log', $log, False, True));
		/*12*/array_push($cp, array('$HV', 'pes_lastupdate', date("Ymd"), False, True));
		
		return ($cp);
	}

	function cp_02() {
		$cp = array();
		$log = $_SESSION['nw_user'];
		/*dd0*/array_push($cp, array('$H8', 'cmp_cliente', '', False, False));
		/*dd1*/array_push($cp, array('$HV', '', '2', False, False));
		/*dd2*/array_push($cp, array('$HV', '', '', False, False));
		/*dd3*/array_push($cp, array('$HV', '', '', False, False));
		/*dd4*/array_push($cp, array('$HV', '', '', False, False));
		/*dd5*/array_push($cp, array('$HV', '', '', False, False));
		
		/*dd6*/array_push($cp, array('$S50', 'cmp_email', 'E-MAIL', false, True));
		
		/*dd7*/array_push($cp, array('$S30', 'cmp_profissao', 'PROFISSÃO', TRUE, True));
		/*dd8*/array_push($cp, array('$S30', 'cmp_empresa', 'EMPRESA', false, True));
		/*dd9*/array_push($cp, array('$S8', 'cmp_salario', 'SALÁRIO', TRUE, True));
		/*dd10*/array_push($cp, array('$S8', 'cmp_salario_complementar', 'SALÁRIO COMPLEMENTAR', false, True));
		/*dd11*/array_push($cp, array('$O : &S:SOLTEIRO&C:CASADO&R:RELAÇÃO ESTÁVEL', 'cmp_estado_civil', 'ESTADO CIVIL', TRUE, True));
		/*dd12*/array_push($cp, array('$S2', 'cmp_estado_civil_tempo', 'TEMPO ESTADO CIVIL', TRUE, True));
		
		/*dd13*/array_push($cp, array('$S100', 'cmp_conjuge_nome', 'NOME CONJUGE', false, True));
		/*dd14*/array_push($cp, array('$S30', 'cmp_conjuge_profissao', 'PROFISSÃO CONJUGE', false, True));
		/*dd15*/array_push($cp, array('$S30', 'cmp_conjuge_empresa', 'EMPRESA CONJUGE', false, True));
		/*dd16*/array_push($cp, array('$S8', 'cmp_conjuge_salario', 'SALÁRIO CONJUGE', false, True));
		
		
		/*dd17*/array_push($cp, array('$[0-50]', 'cmp_emprego_tempo', 'TEMPO DE PROFISSÃO (anos)', TRUE, True));
		/*dd18*/array_push($cp, array('$[0-50]', 'cmp_experiencia_vendas', 'EXPERIÊNCIA COM VENDAS (anos)', TRUE, True));
		/*dd19*/array_push($cp, array('$O : &1:NÃO TEM&2:AUTO FIN&3:IMÓVEL FIN + AUTO FIN/QUIT&4:IMÓVEL QUIT + AUTO QUIT', 'cmp_patrimonio', 'PATRIMONIO', TRUE, True));
		/*dd20*/array_push($cp, array('$S8', 'cmp_valor_aluguel', 'VALOR ALUGUEL', TRUE, True));
		/*dd21*/array_push($cp, array('$S2', 'cmp_imovel_tempo', 'TEMPO IMÓVEL', TRUE, True));
		/*dd22*/array_push($cp, array('$Q prop_descricao:prop_codigo:select * from propagandas where prop_ativo = \'S\' order by prop_descricao', 'cmp_propaganda', 'PROPAGANDA 1', TRUE, True));
		/*dd23*/array_push($cp, array('$Q prop_descricao:prop_codigo:select * from propagandas where prop_ativo = \'S\' order by prop_descricao', 'cmp_propaganda2', 'PROPAGANDA 2', TRUE, True));
		/*dd24*/array_push($cp, array('$B8', '', 'Salvar', False, True));

		/*dd25*/array_push($cp, array('$HV', 'cmp_lastupdate_log', $log, False, True));
		/*dd26*/array_push($cp, array('$HV', 'cmp_lastupdate', date("Ymd"), False, True));
		return ($cp);

	}

	function cp_03() {
		$cp = array();
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$HV', '', '3', True, False));
		array_push($cp, array('$B8', '', 'Salvar', False, True));
		return ($cp);
	}

	function cp_04() {
		$cp = array();
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$HV', '', '4', True, True));
		array_push($cp, array('$B8', '', 'Salvar', False, True));
		return ($cp);

	}

	function cp_05() {
		$cp = array();
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$HV', '', '5', True, True));
		array_push($cp, array('$B8', '', 'Salvar', False, True));
		return ($cp);
	}

	function cp_06() {
		$cp = array();
		array_push($cp, array('$H8', 'cmp_cliente', '', False, True));
		array_push($cp, array('$HV', '', '6', True, True));
		array_push($cp, array('$T100:10', 'cmp_obs', 'Observações', False, True));
		array_push($cp, array('$B8', '', 'Salvar>>', False, True));
		return ($cp);
	}

	function cp_07() {
		$cp = array();
		array_push($cp, array('$H8', 'pes_cliente', '', False, True));
		array_push($cp, array('$HV', '', '7', True, True));
		array_push($cp, array('$HV', '', '7', True, True));
		array_push($cp, array('$B8', '', 'Enviar>>', False, True));
		return ($cp);
	}
/*
	function cp_telefone_admin() {
		$cp = array();

		array_push($cp, array('$H8', 'id_tel', '', False, True));
		array_push($cp, array('$S3', 'tel_ddd', 'DDD', TRUE, True));
		array_push($cp, array('$S9', 'tel_numero', 'NUMERO', TRUE, True));
		array_push($cp, array('$O : &C:CELULAR&R:RESIDENCIAL&E:COMERCIAL', 'tel_tipo', 'TIPO', TRUE, True));
		array_push($cp, array('$O : &1:SIM&1:NAO', 'tel_validado', 'VALIDADO?', TRUE, True));
		array_push($cp, array('$O : &1:SIM&1:NAO', 'tel_status', 'STATUS', TRUE, True));
		array_push($cp, array('$B8', '', 'Salvar', False, True));
		array_push($cp, array('$H7', 'tel_cliente', '', True, True));
		array_push($cp, array('$H3', 'tel_cliente_seq', '', True, True));
		array_push($cp, array('$H11', 'tel_data', '', TRUE, True));
		return ($cp);
	}
*/
 
	function validaCPF($cpf = null) {
		// Verifica se um número foi informado
		if (empty($cpf)) {
			return false;
		}

		// Elimina possivel mascara
		$cpf = ereg_replace('[^0-9]', '', $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

		// Verifica se o numero de digitos informados é igual a 11
		if (strlen($cpf) != 11) {
			return false;
		}
		// Verifica se nenhuma das sequências invalidas abaixo
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
			return false;
			// Calcula os digitos verificadores para verificar se o
			// CPF é válido
		} else {
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
			$this -> cpf = $cpf;
			return true;
		}
	}

	function listar_contatos() {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;
		$sql = "select * from cad_contato
				where con_status='@'
				order by con_data,con_lastcall
				";
		$rlt = db_query($sql);
		$sx = '<div width="100%">';
		$sx .= '<table width="95%"><tr>
					<td width="100px" align="center">Data</td>
					<td width="100px" align="center">Ultimo contato</td>
					<td width="100px" align="center">Contato</td>
					</tr>';
		while ($line = db_read($rlt)) {
			global $http;
			$link = '<a href="' . $http . 'pre_cadastro/pre_cadA.php?dd70=' . $line['id_con'] . '">';
			$sx .= '<tr class="precad_tr">
						<td width="100px" align="center">' . $link . stodbr($line['con_data']) . '</a></td>
						<td width="100px" align="center"">' . $link . stodbr($line['con_lastcall']) . '</a></td>
						<td width="100px" align="center">' . $link . $line['con_nome'] . '</a></td>
					</tr>';
		}
		$sx .= '</table>';
		$sx .= '</div>';

		return ($sx);
	}

	function calcular_total_status_geral() {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;
		$sql = 'select pes_status, count(pes_status)  as tt
				from cad_pessoa
				group by pes_status
		';
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			$ttx = $line['tt'];
			switch ($line['pes_status']) {
				case '@' :
					$this -> tt_geral_Z = $ttx;
					/*em cadastro*/
					break;
				case 'A' :
					$this -> tt_geral_A = $ttx;
					/*aprovados*/
					break;
				case 'T' :
					$this -> tt_geral_T = $ttx;
					/*em analise*/
					break;
				case 'R' :
					$this -> tt_geral_R = $ttx;
					/*comunicado recusados*/
					break;
				case 'F' :
					$this -> tt_geral_F = $ttx;
					/*em analise*/
					break;
				case 'E' :
					$this -> tt_geral_E = $ttx;
					/*comunicado liberao*/
					break;
				default :
			}
		}
		return (1);
	}

	function calcular_total_status_mensal($ano = '', $mes = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;
		if (strlen(trim($data)) == 0) {
			$ano = date('Y');
			$mes = date('m');
		}

		$sql = 'select pes_status, count(pes_status) as tt
				from cad_pessoa
				where pes_lastupdate>' . $ano . $mes . '00 and
					  pes_lastupdate<' . $ano . $mes . '99
				group by pes_status
		';
		$rlt = db_query($sql);
		$ttx = '';
		while ($line = db_read($rlt)) {
			$ttx = $line['tt'];
			switch ($line['pes_status']) {
				case '@' :
					$this -> tt_mensal_Z = $ttx;
					/*em cadastro*/
					break;
				case 'A' :
					$this -> tt_mensal_A = $ttx;
					/*aprovados*/
					break;
				case 'T' :
					$this -> tt_mensal_T = $ttx;
					/*em analise*/
					break;
				case 'R' :
					$this -> tt_mensal_R = $ttx;
					/*recusados*/
					break;
				case 'F' :
					$this -> tt_mensal_F = $ttx;
					/*comunicado recusa*/
					break;
				case 'E' :
					$this -> tt_mensal_E = $ttx;
					/*comunicado liberao*/
					break;	
				default :
					break;
			}
		}
		return (1);
	}

	function gerar_tabela_tela_inicial() {

		$this -> calcular_total_status_geral();
		$this -> calcular_total_status_mensal();
		$this -> pesquisa_aprovados_sem_mostruario();

		$sx = '<table class="cab_banner_table"><tr class="cab_banner_tr_th">
				<th class="cab_banner_th">Em processo de cadastro</td>
				<th class="cab_banner_th">Aprovados sem mostruarios</td>
				<th class="cab_banner_th">Em analise</td>
				<th class="cab_banner_th">Total de cadastros recusados mensal</td>
				<th class="cab_banner_th">Total de cadastros aprovados mensal</td>
			   </tr><tr class="cab_banner_tr_td">
				<td class="cab_banner_td">' . $this -> tt_geral_Z . '</td>
				<td class="cab_banner_td">' . $this -> tt_geral_S . '</td>
				<td class="cab_banner_td">' . $this -> tt_geral_T . '</td>
				<td class="cab_banner_td">' . $this -> tt_mensal_R . '</td>
				<td class="cab_banner_td">' . $this -> tt_mensal_A . '</td>				
				</tr></table>';

		return ($sx);
	}

	/**
	 * Caso tenha mostruario em alguma loja retorna '1' se não retorna '0'
	 */
	function verificar_sem_tem_mostruario($cliente) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $setlj;
		return (0);
		setlj();
		for ($i = 0; $i < count($setlj[3]); $i++) {
			require ($this -> class_include . '_db/' . $setlj[3][$i]);
			$sql = "select * from kits_consignado
					where 	kh_cliente='" . $cliente . "' 
			";
			$qrlt = db_query($sql);
			if ($line = db_read($qrlt)) {
				return (1);
			}
		}
		return (0);
	}

	function pesquisa_aprovados_sem_mostruario() {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;
		/* Busca DB */

		$sql = "select * from " . $this -> tabela . "
				where pes_mostruario = 0 and 
					  pes_status = 'A'
		";

		$arlt = db_query($sql);

		$ln = array();
		while ($line = db_read($arlt)) {
			array_push($ln, $line);
		}

		/* ROLL */
		for ($r = 0; $r < count($ln); $r++) {
			$line = $ln[$r];
			$id = $line['id_pes'];
			$cliente = $line['pes_cliente'];
			if ($this -> verificar_sem_tem_mostruario($cliente)) {
				$this -> atualiza_status_mostruario($id);
			} else {
				++$this -> tt_geral_S;
			}
		}
		return (1);
	}

	/*Seta com 1 pes_mostruario*/
	function atualiza_status_mostruario($id) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;

		$sql = "update " . $this -> tabela . " 
				set  pes_mostruario=1
				where id_pes=" . $id . "
		";
		$rlt = db_query($sql);
		db_read($rlt);
		return (1);
	}

	function carregar_tags_nome_autocomplete() {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $cr;

		$sql = "select * from " . $this -> tabela;
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) {
			if (strlen(trim($sx)) > 0) {
				$sx .= ",";
			}
			$sx .= '"' . $line['pes_nome'] . '"';
		}
		return ($sx);

	}

	function bloquear_campos($id, $vlr) {

		if (strlen(trim($vlr)) > 0) {
			echo "<script>$('#" . $id . "').attr('disabled', true);</script>";
		}
		return (1);
	}
	/**
	 * Codigos já utilizados (adici9one códigos utilizados aqui)
	 * "100 - INSERIU NOVA CONSULTORA"; 
	 * "105 - INSERIU NOVO ENDERECO";
	 * "110 - INSERIU NOVA REFERENCIA";
	 * "115 - INSERIU NOVO TELEFONE";
	 * "120 - INSERIU NOVO COMPLEMENTO CONSULTORA";
	 * "205 - ATUALIZOU ENDERECO ID ".$id;
	 * "210 - ATUALIZOU REFERENCIA ID ".$id;
	 * "215 - ATUALIZOU TELEFONE ID ".$id;
	 * "225 - REMOVEU MAILING";
	 * "330 - NOVA CONSULTA ACP CPF $cpf";
	 * "900 - ATUALIZOU CADASTRO POSTGRES";
	 * "905 - INSERIU CADASTRO POSTGRES";
	 * "999 - ATUALIZOU STATUS P/ ".$this->status($status);
	 */
	function inserir_log($cliente, $login, $acao_log, $acao_cod, $status_registro) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $cr,$ip;
		$data = date('Ymd');
		$hora = date('H:s');
		$sql = "INSERT INTO cad_pessoa_log
					(log_cliente, log_data,log_hora, log_login, log_acao,log_acao_cod, log_status_registro) 
				VALUES 
					('$cliente',$data,'$hora','$login','$acao_log','$acao_cod','$status_registro')
			";
		$rlt = db_query($sql);
		return (1);
	}

	function le_contato($id) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $cr;
		$sql = "select * from " . $this -> tabela_contato . " where id_con=$id";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> line_contato = $line;
			return (1);
		} else {
			return (0);
		}
	}

	function mostrar_contato() {
		$sql = "select * from " . $this -> tabela_contato . " where con_cliente='" . $this -> cliente . "'";
		$rlt = db_query($sql);

		$sx .= '<div class="left border1 pad5 margin5" style="width: 100%;">';
		$sx .= '<table class="lt0" width="100%">';
		$sx .= '<TR>';
		$sx .= '<TH>Nome';
		$sx .= '<TH>Telefone';
		$sx .= '<TH>Telefone (Comercial)';
		$sx .= '<TH>e-email';
		$sx .= '<TH>e-email (alternativo)';

		while ($line = db_read($rlt)) {
			$sx .= '<tr  class="lt1">';
			$sx .= '	<td>(' . $line['con_ddd'] . ')' . $line['con_numero'] . '</td>';
			$sx .= '	<td><A HREF="#" title="' . $line['con_observacao'] . '">##</A></td>';
			$sx .= '</tr>';
		}
		$sx .= '</table>';
		$sx .= '</div>';
		return ($sx);
	}

	function gerar_painel_de_acoes($id, $log) {
		$ac = array();
		array_push($ac, array('@', 'Nao atende'));
		array_push($ac, array('R', 'Recusado'));
		array_push($ac, array('B', 'Ja Cadastrado'));
		array_push($ac, array('X', 'Cancelar'));
		$sx .= '<div class="bt_acoes_box">';
		$l = 0;
		$sx = '<table>';
		for ($i = 0; $i < count($ac); $i++) {
			if ($l == 0) {
				$js = ' onclick="atualiza_acoes(' . $id . ',\'' . $ac[$i][0] . '\',\'' . $log . '\')" ';
				$sx .= '<tr><td class="bt_acoes" href="#" ' . $js . '>' . $ac[$i][1] . '</td>';
				$l++;
			} else {
				$js = ' onclick="atualiza_acoes(' . $id . ',\'' . $ac[$i][0] . '\',\'' . $log . '\')" ';
				$sx .= '<td class="bt_acoes" href="#" ' . $js . '>' . $ac[$i][1] . '</td></tr>';
				$l = 0;
			}
		}
		$sx .= '</table>';
		$this -> js .= '
		function atualiza_acoes(id,acao,log)
						{
							$.ajax({
								type: "POST",
								url: "pre_cad_ajax.php",
								data: { dd0:id, dd1: acao, dd2:log }
								}).done(function( data ) {$("#pre_acao").html( data ); });
						}
		';
		return ($sx);
	}

	function atualiza_status_contatos($id, $st, $log) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $cr, $user;
		$sql = "update " . $this -> tabela_contato . " 
				set con_status='$st', 
					con_lastupdate_log='$log',
					con_lastupdate=" . date('Ymd') . "
				where id_con=$id					
				";
		$rlt = db_query($sql);

		return (1);
	}

	function status($st) {
		switch ($st) {
			case '@' :
				$sx = 'EM CADASTRO';
				/*em cadastro*/
				break;
			case 'A' :
				$sx = 'APROVADO';
				/*aprovados*/
				break;
			case 'T' :
				$sx = 'EM ANALISE';
				/*em analise*/
				break;
			case 'R' :
				$sx = 'RECUSADO';
				/*recusados*/
				break;
			case 'F' :
				$sx = 'COMUNICAR RECUSA';
				/*recusados*/
				break;
			case 'E' :
				$sx = 'COMUNICAR APROVAÇÃO';
				/*recusados*/
				break;		
			case 'TT' :
				$sx = 'GERAL';
				/*recusados*/
				break;	
			default :
		}
		return ($sx);
	}

	function salvar_status($cliente, $status) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $cr, $user;
		$sql = " update " . $this -> tabela;
		$sql .= " set pes_status='$status'";
		$sql .= " where pes_cliente='$cliente' and 
					   pes_cliente_seq='00'";
		$rlt = db_query($sql);
		
		/*LOG*/
		$login = $_SESSION['nw_user'];
		$acao_log = "999 - ATUALIZOU STATUS P/ ".$this->status($status);
		$acao_cod = '999';
		$this->inserir_log($cliente, $login, $acao_log,$acao_cod, $status);
		return (1);
	}
	
	function mostra_resumo(){
		$sx .= '<div>';
		$sx .= '<h3>Dados Pessoais</h3>';
		$sx .= $this->mostra();
		$sx .= '<h3>Complemento</h3>';
		$sx .= $this->mostra_complemento();
		$sx .= '<h3>Contatos Pessoal</h3>';
		$sx .= $this->lista_telefone(0);
		$sx .= '<h3>Endereço</h3>';
		$sx .= $this->lista_endereco(0);
		$sx .= '<h3>Referências</h3>';
		$sx .= $this->lista_referencia(0);
		
		/*quebra de pagina*/
		$sx .= '<div class="break"></div>';
		$sx .= '<h3>Restrições</h3>';
		$sx .= $this->lista_restrições();
		
		return($sx);
	}
	
	function mostra_complemento(){
		$sx = '<div class="gray border1 pad5">';
		$sx .= '<table width="100%">';
		$sx .= '<tr><td width="33%" class="lt2">Profissão : <b>' . $this -> line_cmp['cmp_profissao'] . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Tempo de profissão :<b> ' . $this -> line_cmp['cmp_emprego_tempo'] . ' ano(s)</b>';
		$sx .= '	<td width="33%" class="lt2">Experiência com vendas :<b> ' . $this -> line_cmp['cmp_experiencia_vendas'] . ' ano(s)</b></td>';
		$sx .= '<tr><td width="33%" class="lt2">Salário :<b> R$ ' . number_format($this -> line_cmp['cmp_salario'],2,',','.') . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Salário complementar :<b> R$ ' . number_format($this -> line_cmp['cmp_salario_complementar'],2,',','.') . '</b></td></tr>';
		$sx .= '<tr><td width="33%" class="lt2">Estado civil :<b> ' .$this->estado_civil($this -> line_cmp['cmp_estado_civil']) . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Tempo estado civil :<b> ' . $this -> line_cmp['cmp_estado_civil_tempo'] . ' ano(s)</b></td></tr>';
		$sx .= '<tr><td width="33%" class="lt2">Nome conjuge :<b> ' . $this -> line_cmp['cmp_conjuge_nome'] . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Profissão conjuge : <b>' . $this -> line_cmp['cmp_conjuge_profissao'] . '</b></td></tr>';
		$sx .= '	<td width="33%" class="lt2">Salário conjuge :<b> R$ ' . number_format($this -> line_cmp['cmp_conjuge_salario'],2,',','.') . '</b></td>';
		$sx .= '<tr><td width="33%" class="lt2">Patrimônio : <b>' . $this->sigla_patrimonio($this -> line_cmp['cmp_patrimonio']) . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Valor do aluguel :<b> R$ ' . number_format($this -> line_cmp['cmp_valor_aluguel'],2,',','.') . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Tempo do imóvel :<b> ' . $this -> line_cmp['cmp_imovel_tempo'] . ' ano(s)</b></td></tr>';
		$sx .= '<tr><td width="33%" class="lt2">Propaganda 1 :<b> ' . $this->recupera_propaganda($this -> line_cmp['cmp_propaganda']) . '</b></td>';
		$sx .= '	<td width="33%" class="lt2">Propaganda 2 :<b> ' . $this->recupera_propaganda($this -> line_cmp['cmp_propaganda2']) . '</b></td></tr>';
		$sx .= '</table>'; 
		$sx .= '</div>
		';
		
		return($sx);
	}

	function sigla_patrimonio($sigla) {
		switch ($sigla) {
			case '1' :
				$sig_nome = 'Nao tem';
				break;
			case '2' :
				$sig_nome = 'Auto F';
				break;
			case '3' :
				$sig_nome = 'Imovel F + Auto F/Q';
				break;
			case '4' :
				$sig_nome = 'Imovel Q + Auto Q';
				break;
			default :
				$sig_nome = 'Verificar com TI, novo patrimonio adicionado';
				break;
		}
		return ($sig_nome);
	}
	
	function estado_civil($st){
		switch ($st) {
			case 'C':
				$sx = 'CASADO';
				break;
			case 'S':
				$sx = 'SOLTEIRO';
				break;
			case 'R':
				$sx = 'RELAÇÃO ESTÁVEL';
				break;	
			default:
				$sx = 'NÃO INFORMADO';
				break;
		}
		return($sx);
	}
	function buscar_por_cep($cep=''){
		global $dd;
		if(strlen(trim($cep))>0){
			/*busca latitude e longitude*/
			$geo = new geocode;
			$geo -> consulta_api_sem_update($cep,$_SESSION['cad_cliente']);
			$sql = 'select * from (select * from logradouros 
					where no_logradouro_cep='.$cep.') as tb 
					inner join bairros on bairros.cd_bairro=tb.cd_bairro
					inner join cidades on cidades.cd_cidade=bairros.cd_cidade 
					inner join uf on uf.cd_uf=cidades.cd_uf
			';
			$rlt = db_query($sql);
			$js = '<script>
					$(document).ready(function(){
				';
			while($line = db_read($rlt)){
				$js .= '$("#dd5").val("'.$line['ds_logradouro_nome'].'");'.chr(13).chr(10);
				$js .= '$("#dd8").val("'.$line['ds_bairro_nome'].'");'.chr(13).chr(10);
				$js .= '$("#dd9").val("'.$line['ds_cidade_nome'].'");'.chr(13).chr(10);
				$js .= '$("#dd10").val("'.$line['ds_uf_sigla'].'");'.chr(13).chr(10);
				$js .= '$("#dd13").val("'.$geo->lat.'");'.chr(13).chr(10);
				$js .= '$("#dd14").val("'.$geo->lng.'");'.chr(13).chr(10);
			}
			$js .= '});
					</script>';
					
			return($js);
		}else{
			
			return(0);	
		}
	}
	
	function regras_de_acesso($cliente,$st){
		global $perfil;
		/**
		 * CA1 - Supervisão
		 * CA2 - Analista
		 * CA3 - Operador
		 */
		if ($perfil->valid('#CCE'))
		{
			echo '<script>alert("perfil")</script>';
		}
		$edicao = '<span class="cursor bt_botao bt_yellow" onclick="window.location = \'pre_cad_selection.php?dd0='.$cliente.'\';">EDITAR</span>';
		$analise = '<span class="cursor bt_botao bt_green" onclick="altera_status(\''.$cliente.'\',\'T\' );  progress(\'progress_bar\');" >ENVIO ANALISE</span>';
		$aprovar = '<span class="cursor bt_botao bt_green" onclick="altera_status(\''.$cliente.'\',\'E\' );  progress(\'progress_bar\');" >APROVAR</span>';
		$aprovar_cadastrar = '<span class="cursor bt_botao bt_green" onclick="altera_status(\''.$cliente.'\',\'A\' );  progress(\'progress_bar\');" >APROVAR PARA LOJA</span>';
		$comunica_aprovacao = '<span class="cursor bt_botao bt_green" onclick="altera_status(\''.$cliente.'\',\'K\' );  progress(\'progress_bar\');" >COMUNICAR APROVACAO</span>';
		$comunica_recusa = '<span class="cursor bt_botao bt_green" onclick="altera_status(\''.$cliente.'\',\'R\' );  progress(\'progress_bar\');" >COMUNICAR RECUSA</span>';
		$recusar = '<span class="cursor bt_botao bt_red" onclick="altera_status(\''.$cliente.'\',\'F\' );  progress(\'progress_bar\');" >RECUSAR</span>';
		$retorna_edicao = '<span class="cursor bt_botao bt_yellow" onclick="altera_status(\''.$cliente.'\',\'@\' );  progress(\'progress_bar\');" >RETORNAR P/ EDICAO</span>';
		
		switch ($st) {
			case '@':
				$sx  = '<nav>';
				if ($perfil->valid('#CA1#CA2#CA3'))
				{
					$sx .= $analise;
					$sx .= $edicao;
				}	
				$sx .= '</nav>';
				break;
			case 'K':
				$sx  = '<nav>';
				if ($perfil->valid('#CA1#CA2'))
				{
					$sx .= $aprovar_cadastrar;
					$sx .= $retorna_edicao;
				}else{
					$sx .= $retorna_edicao;
				}	
				$sx .= '</nav>';
				break;				
			case 'T':
				$sx  = '<nav>';
				if ($perfil->valid('#CA1#CA2'))
				{
					$sx .= $aprovar;
					$sx .= $recusar;
					$sx .= $retorna_edicao;
				}else{
					$sx .= $retorna_edicao;
				}	
				$sx .= '</nav>';
				break;
			case 'E':
				$sx  = '<nav>';
				if ($perfil->valid('#CA1#CA2#CA3'))
				{
					$sx .= $comunica_aprovacao;
				}	
				$sx .= '</nav>';
				break;
			case 'A':
				$sx  = '<nav>';
				if ($perfil->valid('#CA1#CA2#CA3'))
				{
					$sx .= '<a>Aprovado finalizado</a>';
				}	
				$sx .= '</nav>';
				break;
			case 'F':
				$sx  = '<nav>';
				if ($perfil->valid('#CA1#CA2#CA3'))
				{
					$sx .= $comunica_recusa;
				}	
				$sx .= '</nav>';
				break;
			case 'R':
				$sx  = '<nav>';
				if ($perfil->valid('#CA1#CA2#CA3'))
				{
					$sx .= $retorna_edicao;
				}	
				$sx .= '</nav>';
				break;
		}
		return($sx);
	}
	
	function row_telefones(){
		global $tabela, $http_edit, $http_edit_para, $cdf, $cdm, $masc, $offset, $order;
		$tabela = "cad_telefone";
		$label = "";
		$http_edit = 'pre_telefones_ed.php';
		$offset = 20;
		$order = "tel_cliente";

		$cdf = array('id_tel', 'tel_cliente', 'tel_ddd', 'tel_numero', 'tel_tipo','tel_data');
		$cdm = array('ID', 'Cliente', 'DDD', 'Telefone', 'Tipo','data');
		$masc = array('', '#', '#', '#', '#', 'D', '#');
		return (true);
	}		
	
	function row_enderecos(){
		global $tabela, $http_edit, $http_edit_para, $cdf, $cdm, $masc, $offset, $order;
		$tabela = "cad_endereco";
		$label = "";
		$http_edit = 'pre_endereco_ed.php';
		$offset = 20;
		$order = "end_cliente";

		$cdf = array('id_end', 'end_cliente', 'end_rua', 'end_numero', 'end_cep');
		$cdm = array('ID', 'Codigo', 'Rua', 'Número', 'CEP');
		$masc = array('', '#', '', '#', '#', '#', '#');
		return (true);
	}
	
	function row_referencias(){
		global $tabela, $http_edit, $http_edit_para, $cdf, $cdm, $masc, $offset, $order;
		$tabela = " cad_referencia ";
		$label = "";
		$http_edit = 'pre_referencias_ed.php';
		$offset = 20;
		$order = "ref_cliente";
		$edit = true;

		$cdf = array('id_ref', 'ref_cliente', 'ref_nome','ref_ddd','ref_numero','ref_ddd2','ref_numero2', 'ref_observacao','ref_data');
		$cdm = array('ID', 'Codigo', 'Nome', 'DDD 1', 'Telefone 1', 'DDD 2', 'Telefone 2','Observações','Cadastro');
		$masc = array('', '#', '', '#', '#', '#', '#','','D','','','');
		return (true);
	}
	
	function agendados($width=100){
		$sxx = $this->total_agendado();
		$sx = '
		<div class="pad5 radius10" style="background-color: #F0F0F0; width:'.$width.'%;">
			<table width="100%" border=0 class="tabela00">
				<tr><td rowspan="8"><img src="../img/imgboxagendados.png" width="200"></td>
				<tr><td>'.$sxx.'</td></tr>
			</table>
		</div>
		';
		return($sx);
	}
	
	function total_agendado(){
		$data = date('Ymd');	
			
		$d = date('d');
		$m = date('m');
		$y = date('Y');

		/*mes*/
		$mes = date('Ym');
		$dt1 = $mes . '01';
		$dt2 = $mes . '32';

		/*semana*/
		$w = date('w');
		/***1º dia da semana*/
		$dt1_w = date('Ymd', mktime(0, 0, 0, $m, $d - $w, $y));
		/***ultimo dia da semana*/
		$dt2_w = date('Ymd', mktime(0, 0, 0, $m , ($d - $w)+6, $y));
		
		$sql = ' select 
						(select count(*) as mes from listatelefonica 
							where l_agendar_para>='.$dt1.' and l_agendar_para<='.$dt2.') as mes,
						(select count(*) as semana from listatelefonica 
							where l_agendar_para>='.$dt1_w.' and l_agendar_para<='.$dt2_w.') as semana,
						(select count(*) as dia from listatelefonica 
							where l_agendar_para>='.$data.' and l_agendar_para<='.$data.') as dia
		';
		$rlt = db_query($sql);
		
		$onclick_d = '<a class="cursor" onclick="lista_status_pre_cad(\'D\',\'LISTA_AGENDA\' );" >';
		$onclick_w = '<a class="cursor" onclick="lista_status_pre_cad(\'W\',\'LISTA_AGENDA\' );" >';
		$onclick_m = '<a class="cursor" onclick="lista_status_pre_cad(\'M\',\'LISTA_AGENDA\' );" >';
		
		
		$sx = '<table><tr><th width="33%" align="center">HOJE</th>
							<th width="33%" align="center">SEMANA</th>
							<th width="33%" align="center">MÊS</th></tr>';
		while($line = db_read($rlt)){
			$sx .= '<tr>
						<td align="center" class="lt5">'.$onclick_d.$line['dia'].'</a></td>
						<td align="center" class="lt5">'.$onclick_w.$line['semana'].'</a></td>
						<td align="center" class="lt5">'.$onclick_m.$line['mes'].'</a></td>
					</tr>';
		}
		$sx .= '</table>';
		return($sx);
	}
	
	function updatex_agendamento() {
		 global $base_name,$base_server,$base_host,$base_user,$user;
        	$dx1 = 'l_codigo';
			$dx2 = 'l';
			$dx3 = 7;
			echo $sql = "update listatelefonica set ".$dx1."=trim(to_char(id_".$dx2.",'".strzero(0,$dx3)."')) where (length(trim(".$dx1.")) < ".$dx3.") or (".$dx1." isnull);";
			$rlt = db_query($sql);
			return(1);
	}
	
	function lista_agenda_dia($aux){
		$data = date('Ymd');	
			
		$sql = ' select * from listatelefonica 
				 where l_agendar_para='.$data.'
				 order by l_agendar_para		
		';
		$rlt = db_query($sql);
		
		$sx .= '<table width=100% class="pad5" style="background-color: #F0F0F0;overflow:scroll;">';
		$sx .= "<tr><th colspan=6 align=left><h2>Agendamentos da dia.</h2></th>";
		$sx .= '<tr><th width="5%" align="center">Agendado</th>
					<th width="5%" align="center">Cliente</th>
					<th width="25%" align="left">Nome</th>
					<th width="10%" align="center">Telefone</th>
					<th width="25%" align="left">Comentário</th>
					<th width="5%" align="center">Status</th>
					<th width="5%" align="center">Log</th>
					<th width="20%" align="center">Cadastro</th>
					<th width="20%" align="center">Ação</th></tr>';
		while($line = db_read($rlt)){
			$cl = $line['l_cliente'];
			$link = '<a title="Resumo" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_view.png"></a>';
			$link1 = '<a title="Pontuacao" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_pontos.png"></a>';
			
			$sx .= '<tr>';
			$sx .= '<td align="center">'.stodbr($line['l_agendar_para']).'</td>';
			$sx .= '<td align="center">'.$cl.'</td>';
			$sx .= '<td align="left">'.$line['l_nome'].'</td>';
			$sx .= '<td align="center">'.$line['l_telefone'].'</td>';
			$sx .= '<td align="left">'.$line['l_comente'].'</td>';
			$sx .= '<td align="center">'.$line['l_status'].'</td>';
			$sx .= '<td align="center">'.$line['l_log'].'</td>';
			$sx .= '<td align="center">'.stodbr($line['l_data']).' - '.$line['l_hora'].'</td>';
			$sx .= '<td align=center>'.$link.$link1.'</td>';
			$sx .= '</tr>';
		}
		$sx .= '</table>';
		return($sx);
	}		
	
	function lista_agenda_semana($aux){
		$data = date('Ymd');	
			
		$d = date('d');
		$m = date('m');
		$y = date('Y');

		/*semana*/
		$w = date('w');
		/***1º dia da semana*/
		$dt1_w = date('Ymd', mktime(0, 0, 0, $m, $d - $w, $y));
		/***ultimo dia da semana*/
		$dt2_w = date('Ymd', mktime(0, 0, 0, $m , ($d - $w)+6, $y));
	
		$sql = 'select * from listatelefonica 
				where l_agendar_para>='.$dt1_w.' and 
						l_agendar_para<='.$dt2_w.' 
				order by l_agendar_para
		';
		
		$rlt = db_query($sql);
		
		$sx .= '<table width=100% class="pad5" style="background-color: #F0F0F0;overflow:scroll;">';
		$sx .= "<tr><th colspan=6 align=left><h2>Agendamentos da semana.</h2></th>";
		$sx .= '<tr><th width="5%" align="center">Agendado</th>
					<th width="5%" align="center">Cliente</th>
					<th width="25%" align="left">Nome</th>
					<th width="10%" align="center">Telefone</th>
					<th width="25%" align="left">Comentário</th>
					<th width="5%" align="center">Status</th>
					<th width="5%" align="center">Log</th>
					<th width="20%" align="center">Cadastro</th>
					<th width="20%" align="center">Ação</th></tr>';
		while($line = db_read($rlt)){
			$cl = $line['l_cliente'];
			$link = '<a title="Resumo" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_view.png"></a>';
			$link1 = '<a title="Pontuacao" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_pontos.png"></a>';
			
			$sx .= '<tr>';
			$sx .= '<td align="center">'.stodbr($line['l_agendar_para']).'</td>';
			$sx .= '<td align="center">'.$cl.'</td>';
			$sx .= '<td align="left">'.$line['l_nome'].'</td>';
			$sx .= '<td align="center">'.$line['l_telefone'].'</td>';
			$sx .= '<td align="left">'.$line['l_comente'].'</td>';
			$sx .= '<td align="center">'.$line['l_status'].'</td>';
			$sx .= '<td align="center">'.$line['l_log'].'</td>';
			$sx .= '<td align="center">'.stodbr($line['l_data']).' - '.$line['l_hora'].'</td>';
			$sx .= '<td align=center>'.$link.$link1.'</td>';
			$sx .= '</tr>';
		}
		$sx .= '</table>';
		return($sx);
	}
	
	function lista_agenda_mes($aux){
		
		$data = date('Ymd');	
			
		$d = date('d');
		$m = date('m');
		$y = date('Y');

		/*mes*/
		$mes = date('Ym');
		$dt1 = $mes . '01';
		$dt2 = $mes . '32';

		/*semana*/
		$w = date('w');
		/***1º dia da semana*/
		$dt1_w = date('Ymd', mktime(0, 0, 0, $m, $d - $w, $y));
		/***ultimo dia da semana*/
		$dt2_w = date('Ymd', mktime(0, 0, 0, $m , ($d - $w)+6, $y));
		
		$sql = ' select * from listatelefonica 
				where 	l_agendar_para>='.$dt1.' and 
						l_agendar_para<='.$dt2.'
				 order by l_agendar_para		
		';
		$rlt = db_query($sql);
		
		$sx .= '<table width=100% class="pad5" style="background-color: #F0F0F0;overflow:scroll;">';
		$sx .= "<tr><th colspan=6 align=left><h2>Agendamentos do mês.</h2></th>";
		$sx .= '<tr><th width="5%" align="center">Agendado</th>
					<th width="5%" align="center">Cliente</th>
					<th width="25%" align="left">Nome</th>
					<th width="10%" align="center">Telefone</th>
					<th width="25%" align="left">Comentário</th>
					<th width="5%" align="center">Status</th>
					<th width="5%" align="center">Log</th>
					<th width="20%" align="center">Cadastro</th>
					<th width="20%" align="center">Ação</th></tr>';
		while($line = db_read($rlt)){
			$cl = $line['l_cliente'];
			$link = '<a title="Resumo" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_view.png"></a>';
			$link1 = '<a title="Pontuacao" href="pre_cliente_ver.php?dd0='.$cl.'">
					<img  width="16px" src="../img/icone_pontos.png"></a>';
			
			$sx .= '<tr>';
			$sx .= '<td align="center">'.stodbr($line['l_agendar_para']).'</td>';
			$sx .= '<td align="center">'.$cl.'</td>';
			$sx .= '<td align="left">'.$line['l_nome'].'</td>';
			$sx .= '<td align="center">'.$line['l_telefone'].'</td>';
			$sx .= '<td align="left">'.$line['l_comente'].'</td>';
			$sx .= '<td align="center">'.$line['l_status'].'</td>';
			$sx .= '<td align="center">'.$line['l_log'].'</td>';
			$sx .= '<td align="center">'.stodbr($line['l_data']).' - '.$line['l_hora'].'</td>';
			$sx .= '<td align=center>'.$link.$link1.'</td>';
			$sx .= '</tr>';
		}
		$sx .= '</table>';
		return($sx);
	}
	
	function mask($val, $mask) {
		$maskared = '';
		$k = 0;
		for ($i = 0; $i <= strlen($mask) - 1; $i++) {
			if ($mask[$i] == '#') {
				if (isset($val[$k]))
					$maskared .= $val[$k++];
			} else {
				if (isset($mask[$i]))
					$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}
	
}
?>
