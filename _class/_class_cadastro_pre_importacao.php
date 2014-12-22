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
	
	function gera_query_insert($obj) {
		global $base_name, $base_server, $base_host, $base_user, $base, $conn, $user;
		$vld = 1;
		$line = $obj->line;
		$prop1 = $obj->propaganda1;
		$prop2 = $obj->propaganda2;
		if (strlen(trim($line['pes_nome'])) == 0) {
			echo '<script>alert("Nome invalido!!")</script>';
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo nome vazio!</a>';
			$vld = 0;
		}
		if (strlen(trim($line['pes_cpf'])) == 0) {
			echo '<script>alert("Cpf invalido!!")</script>';
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo cpf vazio!</a>';
			$vld = 0;
		}
		if (strlen(trim($line['pes_rg'])) == 0) {
			echo '<script>alert("RG invalido!!")</script>';
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo RG vazio!</a>';
			$vld = 0;
		}
		if (strlen(trim($line['pes_nasc'])) == 0) {
			echo '<script>alert("Data de nascimento invalida!!")</script>';
			$this -> error .= '<a>Cliente (' . $line['pes_cliente'] . ') Campo Data de Nascimento vazio!</a>';
			$vld = 0;
		}
		if ($vld == 1) {
			$nasc = $line['pes_nasc'];
			$nascmask = substr($nasc, -2) . '/' . substr($nasc, 4, 2) . '/' . substr($nasc, 2, 2);
			$cpf = substr('000000' . $line['pes_cpf'], -11);
			$cpf = $this -> mask($cpf, '###.###.###-##');
			
			$sqlx = " select * from cadastro where cl_cpf='".$cpf."'";
			$rltx = db_query($sqlx);
			if($linex = db_read($rltx)){
				$this->error = "Já existe este CPF cadastrado!!!";
				return (0);				
			}else{
				//não existe
				$sql .= "
					 insert into cadastro (
						  cl_cliente,cl_cpf,
						  cl_nome,cl_dtcadastro,cl_dtnascimento,
						  cl_nomepai,cl_nomemae,cl_rg,
						  cl_tipo,cl_update,
						  cl_status,cl_nasc,cl_senha,
						  cl_senha_lembrete,cl_senha_status,cl_naturalidade,
						  cl_search,cl_propaganda
					) values ('" . $line['pes_cliente'] . "','" . $cpf . "',
						'" . $line['pes_nome'] . "'," . $line['pes_data'] . "," . $line['pes_nasc'] . ",
						  '" . $line['pes_pai'] . "','" . $line['pes_mae'] . "','" . $line['pes_rg'] . "',
						  'T'," . date('Ymd') . ",
						  'A','" . $nascmask . "','" . substr(sonumero($line['pes_cpf']), 0, 4) . "',
						  'parte do cpf','@','" . $line['pes_naturalidade'] . "',
						  '" . $line['pes_nome'].' ' . $cpf . "','".$prop1.$prop2."'
						  
						  );" . chr(13) . chr(10);
				$rlt = db_query($sql);
				return (1);
			}
		}else{
			return (0);
		}
		
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