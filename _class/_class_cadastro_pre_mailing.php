<?php
/**
 * Pré-Cadastro Mailing - extend da classe cadastro_pre
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.14.38
 * @package _class
 * @subpackage _class_cadastro_pre_mailing.php
 */
require_once ('_class_cadastro_pre.php');

class cadastro_pre_mailing extends cadastro_pre {
	var $include_class = '../';
	function row_mailing() {
		global $tabela, $http_edit, $http_edit_para, $cdf, $cdm, $masc, $offset, $order;
		$tabela = "cadastro";
		$label = "Consultoras inativas mais de 6 meses";
		$http_edit = 'pre_cad_mailing_ed.php';
		$offset = 20;
		$order = "cl_last";

		$cdf = array('cl_cliente', 'cl_cliente', 'cl_nome', 'cl_dtcadastro', 'cl_last');
		$cdm = array('ID', 'Codigo', 'Nome', 'Cadastro', 'Ultimo movimento');
		$masc = array('', '', '', '', '', '', '');
		return (true);
	}

	function menu_mailing() {
		global $dd;
		$onclickR = '<a class="bt_fz" onclick="mailing(\'' . $dd[0] . '\',\'MAILING_REMOVE\' ); progress(\'mailing_status\');" >';
		$onclickP = '<a class="bt_fz" onclick="mailing(\'' . $dd[0] . '\',\'MAILING_RETORNO\' ); progress(\'mailing_status\');" >';
		$sx = '<table  class="cab_status" width="100%"><tr>
				<td width="50%">
					<div id="mailing_status" width="100%"></div>
				</td>
				<td width="50%">
					' . $onclickR . 'REMOVER</a>
					' . $onclickP . 'RETORNO</a>
				</td>	
				</tr></table>
			';

		return ($sx);
	}

	function mailing_remove($cliente) {
		$sql = "update cadastro set cl_last=20990101 where cl_cliente='" . $cliente . "'";
		$rlt = db_query($sql);
		$sx = '<div class="red_light fnt_black">CONSULTORA REMOVIDA!!!</div>';
		return ($sx);
	}

	function mailing_retorno_busca_cliente($cliente) {
		$sqlx = "update cadastro set cl_last=".date('Ymd')." where cl_cliente='" . $cliente . "'";
		$rltx = db_query($sqlx);
		
		$sql = "select * from cadastro where cl_cliente='$cliente'";
		$rlt = db_query($sql);
		if ($line = db_read($rlt)) {
			$this -> cliente = $line['cl_cliente'];
			if (cpf(sonumero($line['cl_cpf']))) {
				$this -> cpf = sonumero($line['cl_cpf']);
				return (true);
			}else{
				return (false);
			}
			return (true);
		} else {
			return (false);
		}

	}

	
	function mailing_retorno_consulta_acp(){
			$acp = new acp;
			$acp -> consulta($this -> cpf, 0, '');
			$acp -> mostra_consulta($this -> cpf);
			$this -> nome = $acp -> acp_nome;
			$this -> nasc = $acp -> acp_nasc;
			$this -> mae = $acp -> acp_mae;
			$this -> seq = '00';
		return(1);
	}
	

	function mailing_retorno_inserir_cpf() {
		
		$user_log = $_SESSION['nw_user'];
		$date = date('Ymd');
		if (strlen(trim($this -> cpf)) > 0) {
			$set1 .= ', pes_cpf';
			$set2 .= ",'$this->cpf'";
		};
		if (strlen(trim($this -> cliente)) > 0) {
			$set1 .= ', pes_cliente';
			$set2 .= ",'$this->cliente'";
		};
		if (strlen(trim($this -> nome)) > 0) {
			$set1 .= ', pes_nome';
			$set2 .= ",'$this->nome'";
		};
		if (strlen(trim($this -> nasc)) > 0) {
			$set1 .= ', pes_nasc';
			$set2 .= ",'$this->nasc'";
		};
		if (strlen(trim($this -> mae)) > 0) {
			$set1 .= ', pes_mae';
			$set2 .= ",'$this->mae'";
		};

		$sql = "insert into " . $this -> tabela . " 
					(pes_cliente_seq, pes_data, pes_status, 
					 pes_log, pes_lastupdate, pes_lastupdate_log
					  $set1)
					values 
					('00', " . $date . ", '@',
					 '" . $user_log . "', " . $date . ",'" . $user_log . "'
					 " . $set2 . ")";
		$rlt = db_query($sql);
		$sx = '<div class="green_light fnt_black">CONSULTORA RETORNADA!!!</div>';
		return ($sx);

	}

}
?>