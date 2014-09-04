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
	var $line = '';

	var $id_cmp = '';
	var $line_cmp = '';

	var $id_ref = '';
	var $line_ref = '';

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

	var $class_include = '../../';

	function cp_telefone() {
		global $dd, $acao;
		$cp = array();
		array_push($cp, array('$H8', 'id_tel', '', False, True));
		array_push($cp, array('$H8', 'tel_cliente', '', True, True));
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$S2', 'tel_ddd', 'DDD', True, True));
		array_push($cp, array('$S9', 'tel_numero', 'Telefone', True, True));
		array_push($cp, array('$O : &R:Residencial&C:Comercial&E:Recado', 'tel_tipo', 'Tipo', True, True));
		return ($cp);
	}

	function mostra_nome($sty='') {
		$sx .= '<div class="lt3 border1 radius5 pad5 '.$sty.'">';
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
				$genero = 'Masculino';
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
		$sx .= '<div class="gray border1 pad5">';
		$sx .= '<div >';

		/* Mostra status */
		$sx .= '<div class="right text-center">Status: ';
		$sx .= $this -> mostra_status($this -> line['pes_status']);
		$sx .= '<BR><img src="' . $this -> image_status . '" height="60">';
		$sx .= '</div>';

		$sx .= '<font class="lt0">nome completo</font><BR>';
		$sx .= '<font class="lt3"><B>' . $this -> nome . '</B></FONT>';
		$sx .= '</div>';

		$sx .= '<div>Idade: ' . $this -> mostra_idade($this -> nasc) . ' anos</div>';
		$sx .= '<div>Dt. Nascimento: ' . stodbr($this -> nasc) . '</div>';
		$sx .= '<div>Genero: ' . $this -> mostra_genero($this -> line['pes_genero']) . '</div>';

		/* Documentos */
		$sx .= '<div>CPF: ' . $this -> mostra_cpf($this -> cpf) . '</div>';
		$sx .= '<div>RG: ' . $this -> line['pes_rg'] . '</div>';

		$sx .= '<div>Código: ' . $this -> line['pes_cliente'] . '</div>';

		if ($this -> line['pes_status'] == '@') {
			$onclick = ' onclick="window.location = \'pre_cad_selection.php?dd0=' . $this -> line['pes_cliente'] . '\';" ';
			if ($editar == 0)
				{
					$sx .= '<div class="right">';
					$sx .= '<input type="button" ' . $onclick . ' name="cad" id="cadastro" value="editar cadastro" class="botao_editar">';
					$sx .= '</div>';
				}
		}

		$sx .= '<div>Mãe: ' . $this -> line['pes_mae'] . '</div>';
		$sx .= '<div>Pai: ' . $this -> line['pes_pai'] . '</div>';

		$sx .= '<div>Dt. Cadastro: ' . stodbr($this -> line['pes_data']) . '</div>';
		$sx .= '<div>Dt. Atualiação: ' . stodbr($this -> line['pes_lastupdate']) . '</div>';

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
			$this -> nasc = $line['pes_nasc'];
			return (1);
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
			$sx .= '<TR><TH>Nome<TH>CPF<TH>Código<TH>Dt. Nascimento<TH>Situação</TR>';
			$tot = 0;
			while ($line = db_read($rlt)) {
				$tot++;
				$sx .= $this -> mostra_cliente_linha($line);
			}
			$sx .= '</table>';
			$this->total_result = $tot;
			if ($tot == 0) { $sx = ''; }
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
			case 'A' :
				$sx = '<font color="green">aprovado</font>';
				$img = $http . 'img/icone_precad_aprovado.png';
				break;
			case 'C' :
				$sx = '<font color="red">recusado</font>';
				$img = $http . 'img/icone_precad_recusado.png';
				break;
			case 'E' :
				$sx = '<font color="green">comunicad liberação</font>';
				$img = $http . 'img/icone_precad_comunicar.png';
				break;
			default :
				$sx = '<font color="blue">em análise</font>';
				$img = $http . 'img/icone_precad_analise.png';
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

	function formulario_de_busca() {
		global $dd, $acao;
		$sx .= '<form method="get" action="' . page() . '">
					<div>
					<img src="../img/imgboxcad.png" width="200">
					<div class="pad5 radius10" style="background-color: #F0F0F0; width:80%;">
						<table width="100%" border=0 class="tabela00">
							<TR>
							<TD class="lt1">NOME DE BUSCA
							<tr>
							<TR>
							<td><input type="text" id="dd1" name="dd1" value="' . $dd[1] . '" style="width: 90%;" size="100" class="precad_form_string">
							<TR>
							<TD class="lt1">CPF DE BUSCA
							<TR>
							<td><input type="text" id="dd2" name="dd2" value="' . $dd[2] . '" size="15"  class="precad_form_string">							
							<input type="submit" name="acao" value="buscar"  class="precad_form_submit">
						</table>
					</div>
					</div>
					</form>
					';
		return ($sx);
	}

	function mostra_informacoes_uteis() {
		$sx .= '
					<div>
					<img src="../img/imgboxinfo.png" width="200">
					<div class="pad5 radius10" style="background-color: #F0F0F0; width:190px;">
						<table width="100%" border=0 class="tabela00">
							<TR>
							<TD class="lt1" colspan=3  align="center"><B>Número de Cadastros</B></td>
							</TR>
							<TR class="lt1" align="center">
							<TD>no dia
							<TD>na semana
							<TD>no mês
							</TR>
							<TR class="lt5" align="center">
							<TD>0
							<TD>0
							<TD>0
						</table>
					</div>
					</div>
					';
		return ($sx);
	}

	function mostra_tipo_telefone($tp) {
		switch ($tp) {
			case 'C' :
				$tipo = 'Comercial';
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

	function insere_endereco($rua, $numero, $complemento, $cep, $bairro, $cidade, $estado = 'PR') {
		$cliente = $this -> cliente;
		$cep = sonumero($cep);
		$data = date("Ymd");
		$lat = 0;
		$log = 0;
		$cidade = uppercase($cidade);
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
					'$estado','$cep','$lat','$log',
					1,$data,0
					)";
			$rrr = db_query($sql);

		}
	}

	function insere_telefone($ddd, $telefone, $tipo) {
		$cliente = $this -> cliente;
		$telefone = sonumero($telefone);
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
					0,1
					)";
			$rrr = db_query($sql);
		}
	}

	function lista_telefone_adiciona() {
		global $http, $editar;
		
		if ($editar == 1)
			{
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
		if ($edit == 1) { $sx .= $this -> lista_telefone_adiciona();
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
			$bgcor = $this -> valida_cor($val);

			$sx .= '<div class="left radius5 margin5 pad5 border1 ' . $bgcor . '" style="width: 500px;">';
			$sx .= '<font class="lt0">endereco</font><BR>';
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
			//$sx .= $line['tel_validado'];
			//$sx .= $line['tel_status'];
			$sx .= '</div>';
		}
		return ($sx);
	}

	function lista_endereco_adiciona() {
		global $http,$editar;
		if ($editar==1)
			{
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
		if ($edit == 1) { $sx .= $this -> lista_endereco_adiciona();
		}
		return ($sx);
	}

	function lista_endereco($edit = 0) {
		global $editar;
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
		if ($edit == 1) { $sx .= $this -> lista_referencia_adiciona();
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
			$bgcor = $this -> valida_cor($val);

			$sx .= '<div class="left radius5 margin5 pad5 border1 ' . $bgcor . '" style="width:200px; height: 90px;">';

			/* Observacao */
			$obs = $line['ref_observacao'];
			if (strlen($obs) > 0) {
				$sx .= '<div class="right"><img src="' . $http . 'img/icon_observation.png" height="20" title="' . $obs . '"></div>';
			}

			$sx .= '<font class="lt0">referencia</font><BR>';
			$sx .= $line['ref_nome'];
			$sx .= '<BR>';
			$sx .= '<font class="lt0">' . trim($line['ret_nome']) . '&nbsp;</font>';
			$sx .= '<BR>';
			$sx .= $this -> formata_telefone($line['ref_numero'], $line['ref_ddd']);
			$comercial = $line['ret_tipo'];
			if ($comercial == 'C') {
				$sx .= '<BR><font class="lt1 fnt_blue"><B>** COMERCIAL **</B>';
			}
			$sx .= '</div>';
		}
		return ($sx);
	}

	function insere_referencia($nome, $ddd, $telefone, $obs, $data, $grau) {
		$cliente = $this -> cliente;
		$data = date("Ymd");
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
					'1','1','0',
					'$ddd','$telefone'
					)";
			$rrr = db_query($sql);
		}
	}

	function lista_referencia_adiciona() {
		global $http,$editar;
		
		if ($editar == 1)
			{
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
		global $editar;
		$id = 'pre_telefone';
		$sx .= '<div id="' . $id . '_main">';
		$form = new form;
		$sx .= $form -> ajax_refresh($id, $this -> cliente, $editar);
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

			$sx .= '<div class="left radius5 margin5 pad5 border1 ' . $bgcor . '">';
			$sx .= '<font class="lt0">telefone</font><BR>';
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
					  pes_status, pes_log $set1)
					values 
					('$seq','$cpf', $date,
					  '@', '$user->user_log' $set2 
					)";
		$rlt = db_query($sql);
		$this -> updatex();
		return ($this -> recupera_codigo_pelo_cpf($cpf));

	}

	function recupera_codigo_pelo_cpf($cpf = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;

		$sql = "select * from " . $this -> tabela . " where pes_cpf = '" . $cpf . "'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> id = $line['id_pes'];
			$this -> cpf = $line['pes_cpf'];
			$this -> cliente = $line['pes_cliente'];
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
			$this -> nome = $line['pes_nome'];
			$this -> seq = $line['pes_cliente_seq'];
			$this -> line = $line;
			return ($line['pes_cliente']);
		} else {
			return (0);
		}
	}

	function recupera_referencia_pelo_codigo($cliente = '', $seq = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn;

		if (strlen(trim($cliente)) > 0) { $this -> cliente = $cliente;
		}
		if (strlen(trim($seq)) > 0) { $this -> seq = $seq;
		}
		$sql = "select * from " . $this -> tabela_referencia . "  
				where ref_cliente ='" . $this -> cliente . "' and 
					  ref_cliente_seq = '" . $this -> seq . "'
				";

		$rlt = db_query($sql);
		if ($line_ref = db_read($rlt)) {
			$this -> id_ref = $line['id_ref'];
			$this -> line_ref = $line_ref;
			return ($line_ref['id_ref']);
		} else {
			return (0);
		}
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

	function cp_fone() {
		$cp = array();
		/*0*/array_push($cp, array('$H8', '', '', False, True));
		/*1*/array_push($cp, array('$H8', '', 'cliente', False, True));
		/*2*/array_push($cp, array('$H8', '', 'seq', False, True));
		/*3*/array_push($cp, array('$S3', '', 'DDD', TRUE, True));
		/*4*/array_push($cp, array('$S15', '', 'Numero', False, True));
		/*5*/array_push($cp, array('$O : &C:Celular&F:Fixo', '', 'Tipo', False, True));
		/*6*/array_push($cp, array('$H8', '', 'data', False, True));
		/*7*/array_push($cp, array('$H8', '', 'status', False, True));
		/*8*/array_push($cp, array('$H8', '', 'validado', False, True));

		return ($cp);
	}

	function cp_referencia() {
		$cp = array();
		/*0*/array_push($cp, array('$H8', '', '', False, True));
		/*1*/array_push($cp, array('$H8', '', 'cliente', False, True));
		/*2*/array_push($cp, array('$H8', '', 'seq', False, True));
		/*3*/array_push($cp, array('$S30', '', 'Nome', true, True));
		/*4*/array_push($cp, array('$Q ret_nome:ret_codigo:select * from cad_referencia_tipo', '', 'Grau', True, True));
		/*5*/array_push($cp, array('$S3', '', 'DDD', TRUE, True));
		/*6*/array_push($cp, array('$S15', '', 'Numero', true, True));
		/*7*/array_push($cp, array('$T 40:5', '', 'Observacao', False, True));

		return ($cp);
	}

	function cp_endereco() {
		global $dd;
		$cep = sonumero($dd[4]);
		if (strlen($cep) == 8) { $dd[4] = $cep;
		} else { $dd[4] == '';
		}
		$cp = array();
		/*0*/array_push($cp, array('$H8', '', '', False, True));
		/*1*/array_push($cp, array('$H8', '', '', False, True));
		/*2*/array_push($cp, array('$H8', '', '', False, True));
		/*3*/array_push($cp, array('$H8', '', '', False, True));
		/*4*/array_push($cp, array('$S10', '', 'CEP', TRUE, True));
		/*5*/array_push($cp, array('$S100', '', 'Endereço', True, True));
		/*5*/array_push($cp, array('$S10', '', 'Numero', True, True));
		/*5*/array_push($cp, array('$S30', '', 'Complemento', True, True));
		/*5*/array_push($cp, array('$S30', '', 'Bairro', True, True));
		/*5*/array_push($cp, array('$Q cidade_nome:cidade_nome:select * from ajax_cidade where cidade_ativo=1 order by cidade_nome', '', 'Cidade', True, True));

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
		///*9*/array_push($cp, array('$S7', 'pes_avalista_cod', utf8_encode('CÓDIGO AVALISTA'), True, True));
		/*10*/array_push($cp, array('$B8', '', 'Salvar', False, True));

		/*11*/array_push($cp, array('$HV', 'pes_lastupdate_log', $log, False, True));
		/*12*/array_push($cp, array('$HV', 'pes_lastupdate', date("Ymd"), False, True));
		return ($cp);
	}

	function cp_02() {
		$cp = array();
		$teste = 'teste';
		$log = $_SESSION['nw_user'];
		/*dd0*/array_push($cp, array('$H8', 'cmp_cliente', '', False, False));
		/*dd1*/array_push($cp, array('$HV', '', '2', False, False));
		/*dd2*/array_push($cp, array('$HV', '', '', False, False));
		/*dd3*/array_push($cp, array('$HV', '', '', False, False));
		/*dd4*/array_push($cp, array('$HV', '', '', False, False));
		/*dd5*/array_push($cp, array('$HV', '', '', False, False));
		
		/*dd6*/array_push($cp, array('$S8', 'cmp_salario', 'SALARIO', TRUE, True));
		/*dd7*/array_push($cp, array('$S8', 'cmp_salario_complementar', 'SALARIO COMPLEMENTAR', TRUE, True));
		/*dd8*/array_push($cp, array('$O : &S:SOLTEIRO&C:CASADO&R:RELACAO ESTAVEL', 'cmp_estado_civil', 'ESTADO CIVIL', TRUE, True));
		/*dd9*/array_push($cp, array('$S2', 'cmp_estado_civil_tempo', 'TEMPO ESTADO CIVIL', TRUE, True));
		/*dd10*/array_push($cp, array('$S30', 'cmp_profissao', 'PROFISSAO', TRUE, True));
		/*dd11*/array_push($cp, array('$[0-50]', 'cmp_emprego_tempo', 'Tempo de profissão (anos)', TRUE, True));
		/*dd12*/array_push($cp, array('$[0-50]', 'cmp_experiencia_vendas', 'Experiencia com vendas (anos)', TRUE, True));
		/*dd13*/array_push($cp, array('$O : &1:NAO TEM&2:AUTO FIN&3:IMOVEL FIN + AUTO FIN/QUIT&4:IMOVEL QUIT + AUTO QUIT', 'cmp_patrimonio', 'PATRIMONIO', TRUE, True));
		/*dd14*/array_push($cp, array('$S8', 'cmp_valor_aluguel', 'VALOR ALUGUEL', TRUE, True));
		/*dd15*/array_push($cp, array('$S2', 'cmp_imovel_tempo', 'TEMPO IMOVEL', TRUE, True));
		/*dd16*/array_push($cp, array('$Q prop_descricao:prop_codigo:select * from propagandas where prop_ativo = \'S\'', 'cmp_propaganda', 'PROPAGANDA 1', TRUE, True));
		/*dd17*/array_push($cp, array('$Q prop_descricao:prop_codigo:select * from propagandas where prop_ativo = \'S\'', 'cmp_propaganda2', 'PROPAGANDA 2', TRUE, True));
		/*dd18*/array_push($cp, array('$B8', '', 'Salvar', False, True));

		/*dd19*/array_push($cp, array('$HV', 'cmp_lastupdate_log', $log, False, True));
		/*dd20*/array_push($cp, array('$HV', 'cmp_lastupdate', date("Ymd"), False, True));
		return ($cp);

	}

	function cp_03() {
		$cp = array();
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$HV', '', '3', True, False));
		return ($cp);
	}

	function cp_04() {
		$cp = array();
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$HV', '', '4', True, True));
		return ($cp);

	}

	function cp_05() {
		$cp = array();
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$HV', '', '5', True, True));
		return ($cp);
	}
	
	function cp_06() {
		$cp = array();
		array_push($cp, array('$H8', '', '', False, True));
		array_push($cp, array('$HV', '', '5', True, True));
		return ($cp);
	}
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
				case 'C' :
					$this -> tt_geral_C = $ttx;
					/*para correção*/
					break;
				case 'R' :
					$this -> tt_geral_R = $ttx;
					/*recusados*/
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
				case 'C' :
					$this -> tt_mensal_C = $ttx;
					/*para correção*/
					break;
				case 'R' :
					$this -> tt_mensal_R = $ttx;
					/*recusados*/
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
				<th class="cab_banner_th">Para correcao</td>
				<th class="cab_banner_th">Em analise</td>
				<th class="cab_banner_th">Total de cadastros recusados mensal</td>
				<th class="cab_banner_th">Total de cadastros aprovados mensal</td>
			   </tr><tr class="cab_banner_tr_td">
				<td class="cab_banner_td">' . $this -> tt_geral_Z . '</td>
				<td class="cab_banner_td">' . $this -> tt_geral_S . '</td>
				<td class="cab_banner_td">' . $this -> tt_geral_C . '</td>
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

	function inserir_log($cliente, $data, $login, $acao, $status_registro) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $cr;
		$sql = "INSERT INTO cad_pessoa_log
					(log_cliente, log_data, log_login, log_acao, log_status_registro) 
				VALUES 
					('$cliente',$data,'$login','$acao','$status_registro')
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
		$sx .= '<TH>e-emal';
		$sx .= '<TH>e-emal (alternativo)';

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

}
?>
