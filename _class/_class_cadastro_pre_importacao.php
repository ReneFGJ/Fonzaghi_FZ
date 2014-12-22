<?php
/**
 * Pré-Cadastro
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.14.48
 * @package _class
 * @subpackage _class_cadastro_pre_importacao.php
 */

class cadastro_pre_importacao {
	var $clientes = array();
	var $include_db = '../../_db/';
	var $error = '';

	function gera_query_insert($line) {
		global $base_name, $base_server, $base_host, $base_user;

		if (strlen(trim($line['pes_nome'])) == 0) {
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo nome vazio!</a>';
			$vld = 0;
		}
		if (strlen(trim($line['pes_cpf'])) == 0) {
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo cpf vazio!</a>';
			$vld = 0;
		}
		if (strlen(trim($line['pes_rg'])) == 0) {
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo RG vazio!</a>';
			$vld = 0;
		}
		if (strlen(trim($line['pes_nasc'])) == 0) {
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo Data de Nascimento vazio!</a>';
			$vld = 0;
		}
		if ($vld == 1) {
			$nasc = $line['pes_nasc'];
			$nascmask = substr($nasc, -2) . '/' . substr($nasc, 4, 2) . '/' . substr($nasc, 2, 2);
			$cpf = substr('000000' . $line['pes_cpf'], -11);
			$cpf = $this -> mask($cpf, '######.###-##');
			$sql .= "
				 insert into cadastro (
					  cl_cliente,cl_cpf,
					  cl_nome,cl_dtcadastro,cl_dtnascimento,
					  cl_nomepai,cl_nomemae,cl_rg,
					  cl_tipo,cl_update,
					  cl_status,cl_nasc,cl_senha,
					  cl_senha_lembrete,cl_senha_status,cl_naturalidade
				) values ('" . $line['pes_cliente'] . "','" . $cpf . "',
					'" . $line['pes_nome'] . "'," . $line['pes_data'] . "," . $line['pes_nasc'] . ",
					  '" . $line['pes_pai'] . "','" . $line['pes_mae'] . "','" . $line['pes_rg'] . "',
					  'T'," . date('Ymd') . ",
					  'A','" . $nascmask . "','" . substr(sonumero($line['pes_cpf']), 0, 4) . "',
					  'parte do cpf','@','" . $line['pes_naturalidade'] . "')," . chr(13) . chr(10);
		}
		return (1);
	}

	/**exemplo
	 *mask($cnpj,'##.###.###/####-##');
	 *mask($cpf,'###.###.###-##');
	 *mask($cep,'#####-###');
	 *mask($data,'##/##/####');
	 */
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