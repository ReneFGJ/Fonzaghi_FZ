<?php
/**
 * Cadastro_pre_consultora
 * @author Rene Faustino Gabriel Junior  (Analista-Desenvolvedor)
 * @copyright Copyright (c) 2011 - sisDOC.com.br
 * @access public
 * @version v0.13.45
 * @package Classe
 * @subpackage UC0028 - Classe de Interoperabilidade de dados
 */
require_once ('_class_cadastro_pre.php');

class cadastro_pre_consultora extends cadastro_pre {

	function update($cliente = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $user;
		require ($this -> class_include . "_db/db_mysql_10.1.1.220.php");
		
		if (strlen($cliente) > 0) {
			$sql = "update " . $this -> tabela . " set cl_lastupdate = '" . date("Ymd") . "'
					where 	pes_cliente = '" . $cliente . "' and 
							pes_cliente_seq='00'
					";
			$rlt = db_query($sql);
		}
		return (1);
	}

	function form_busca() {
		global $dd;
		$bt1 = 'localizar >>';
		$msg = 'Informe parte do nome da consultura ou seu código';
		$sx .= '
			<table align="center"><TR><TD>
			<form method="get" action="' . page() . '">
 			<div id="search">
				' . $msg . '
				<input type="text" name="dd1" id="form_search" value="' . $dd[1] . '">
				<BR>
				<input type="submit" name="dd50" id="form_button" value="' . $bt1 . '">
			</div>
			</form>
			</td></tr></table>
			';
		return ($sx);
	}

	function resultado_mostra($page = '') {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $user, $dd;
		require ($this -> class_include . "_db/db_mysql_10.1.1.220.php");
		$codigo = trim(sonumero($dd[1]));

		/* busca pelo codigo */
		if (strlen($codigo) == 7) {
			$sql  = " select * from " . $this -> tabela; 
			$sql .= " where pes_cliente = '" . $codigo . "' and pes_cliente_seq = '00' ";
			$sql .= " order by pes_cliente limit 3000 ";
			$rlt = db_query($sql);
			$sx .= $this -> mostra_consultoras($rlt, $page);
		} else {
			$st = UpperCaseSql($dd[1]) . ' ';
			$st = troca($st, ' ', ';');
			$st = splitx(';', $st);
			$sh = '';
			for ($r = 0; $r < count($st); $r++) {
				if (strlen($wh) > 0) { $wh .= ' and ';
				}
				$wh .= " (pes_nome like '%" . $st[$r] . "%' ) ";
			}
			$sql  = " select * from " . $this -> tabela; 
			$sql .= " where " . $wh . " ";
			$sql .= " order by pes_nome ";
			$sql .= " limit 3000";
			$rlt = db_query($sql);

			$sx .= $this -> mostra_consultoras($rlt, $page);
		}
		return ($sx);
	}

	function mostra_consultoras($rlt, $page = '') {
		if (strlen($page) == 0) { $page = 'cx_consultora.php';
		}
		$sx = '<table width="100%" cellpadding=2 cellspacing=4>';
		$sx .= '<TR>
				<TH class="pre_tabelaTH_A" align="left">Nome da Consultora
				<TH class="pre_tabelaTH_A" align="center">Código
				<TH class="pre_tabelaTH_A" align="center">Nascimento.
				<TH class="pre_tabelaTH_A" align="center">Tipo';
		while ($line = db_read($rlt)) {
			
			$link = '<A HREF="' . $page . '?dd0=' . $line['pes_cliente'] . '&ddx=' . date("YmdHis") . '">';
			$sx .= '<TR>';
			$sx .= '<TD class="pre_tabela01_A" align="left">';
			$sx .= $link;
			$sx .= trim($line['pes_nome']);
			$sx .= '</A>';

			$sx .= '<TD class="pre_tabela01_A" align="center">';
			$sx .= $link;
			$sx .= trim($line['pes_cliente']);
			$sx .= '</A>';

			$sx .= '<TD class="pre_tabela01_A" align="center">';
			$sx .= $link;
			$sx .= stodbr($line['pes_nasc']);
			$sx .= '</A>';

			$sx .= '<TD class="pre_tabela01_A" align="center">';
			$sx .= $link;
			$sx .= $this->recuperar_nome_da_seq($line['pes_cliente_seq']);
			$sx .= '</A>';
		}
		$sx .= '</table>';
		return ($sx);
	}

	function exists_cliente($id) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $user;
		require ($this -> class_include . "_db/db_mysql_10.1.1.220.php");
		if (strlen($id) > 0) {$this -> codigo = $id;
		}
		$sql  = " select * from " . $this -> tabela;
		$sql .= " where cl_cliente = '" . $id . "' and pes_cliente_seq='00'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			return (1);
		} else {
			return (0);
		}
	}

	function busca_consultora() {
		global $base_host, $base_port, $base_name, $base_user, $base_pass, $base, $conn, $dd, $acao;

		$form = new form;

		$cp = array();
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$S7', '', 'Código consultora', True, False));

		$tela = $form -> editar($cp, '');
		if ($form -> saved > 0) {
			require ($this -> class_include . "_db/db_mysql_10.1.1.220.php");
			$this -> le($dd[1]);
			$this -> tela = $this -> mostra_dados_pessoais();
			return (1);
		} else {
			$this -> tela = $tela;
			return (0);
		}
		return (0);
	}

	function busca_cliente_sql($nome) {
		$nome = trim(UpperCaseSql($nome)) . ' ';
		$ca = array();
		while (strpos($nome, ' ') > 0) {
			$pos = strpos($nome, ' ');
			$nn = substr($nome, 0, $pos);
			$nome = trim(substr($nome, $pos, strlen($nome))) . ' ';
			if (strlen($nn) > 0) { array_push($ca, $nn);
			}
		}
		$fld = array('pes_cliente', 'pes_nome', 'pes_cpf');
		for ($ra = 0; $ra < count($fld); $ra++) {
			if (strlen($sqlw) > 0) { $sqlw .= ' or ';
			}
			$sqlw .= '(';
			for ($rb = 0; $rb < count($ca); $rb++) {
				if ($rb > 0) { $sqlw .= ' and ';
				}
				$sqlw .= $fld[$ra] . " like '%" . $ca[$rb] . "%' ";
			}
			$sqlw .= ')';
		}
		return ($sqlw);
	}

}
?>