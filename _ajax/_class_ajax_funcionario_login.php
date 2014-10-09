<?php
require ("../_class/_class_cadastro_pre.php");
require ("../_class/_class_user.php");
require ("../../_db/db_fghi.php");
require ($include.'sisdoc_data.php');

class ajax {
	var $tabela = '';
	function __construct() {
		//		$cad = new cadastro_pre;
		//		$this->tabela = $cad->tabela_telefone;
	}

	function cp() {
		global $dd, $acao;
		$cad = new cadastro_pre;
		$cad -> cliente = $dd[1];
		$cp = $cad -> cp_telefone();
		return ($cp);
	}

	function insere_registro($dd) {
		$cad = new cadastro_pre;
		$cad -> cliente = $dd[1];
		$ddd = $dd[3];
		$telefone = $dd[4];
		$tipo = $dd[5];
		$cad -> insere_telefone($ddd, $telefone, $tipo);
	}

	function login_valida($cracha, $login, $senha) {
		$us = new user;
		$ret = $us -> login_valida_compras($login, $senha, $cracha);
		return ($ret);
	}

	function refresh() {
		global $dd;

		$cracha = strzero($dd[5], 5);
		$login = trim($dd[6]);
		$senha = trim($dd[7]);

		if ((strlen($cracha) > 0) and (strlen($login) > 0) and (strlen($senha) > 0)) {
			if ($this -> login_valida($cracha, $login, $senha) > 0) {
				$_SESSION['user_id'] = $cracha;
				$us = new user;
				$us->le($cracha);
				echo $us->mostra_dados();
				$form = new form;
				echo $form->ajax('produtos_venda',$cracha);
				echo $form->ajax('venda_resumo',$cracha);
				exit ;
			}
			$erro = '<font color="red">Dados Incorretos</font>';
		}

		$cp = array();
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$S8', '', 'Cracha', True, True));
		array_push($cp, array('$S20', '', 'Login', True, True));
		array_push($cp, array('$P8', '', 'Senha', True, True));
		array_push($cp, array('$B8', '', 'Login', False, True));

		$form = new form;
		$form -> ajax = 1;
		$form -> frame = 'funcionario_login';
		$form -> required_message = 0;
		$form -> required_message_post = 0;
		$form -> class_string = 'fz_precad_form_string';
		$form -> class_button_submit = 'fz_precad_form_submit';
		$form -> class_form_standard = 'fz_precad_form';
		$form -> class_textbox = 'fz_precad_form_string';
		$form -> class_memo = 'fz_precad_form';
		$form -> class_select = 'fz_precad_select';

		$tela = $form -> editar($cp, '');
		echo $tela;
		echo $erro;
		return ($sx);
	}

}
?>