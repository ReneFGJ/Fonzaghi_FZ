<?php
require("../_class/_class_cadastro_pre.php");

class ajax
	{
		var $tabela = '';
		function __construct()
			{
		//		$cad = new cadastro_pre;
		//		$this->tabela = $cad->tabela_telefone;
			}
		function cp()
			{
				global $dd,$acao;
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$cp = $cad->cp_telefone();
				return($cp);
			}	
		function insere_registro($dd)
			{
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$ddd = $dd[3];
				$telefone = $dd[4];
				$tipo = $dd[5];
				$cad->insere_telefone($ddd,$telefone,$tipo);				
			}
		function refresh()
			{
				global $dd;
				$cp = array();
				array_push($cp,array('$H8','','',False,False));
				array_push($cp,array('$H8','','',False,False));
				array_push($cp,array('$H8','','',False,False));
				array_push($cp,array('$H8','','',False,False));
				array_push($cp,array('$H8','','',False,False));
				array_push($cp,array('$S8','','Cracha',True,True));
				array_push($cp,array('$S20','','Login',True,True));
				array_push($cp,array('$P8','','Senha',True,True));
				array_push($cp,array('$B8','','Login',True,True));
				$form = new form;
				$form->ajax = 1;
				$form->frame = 'funcionario_login_main';
				$tela = $form->editar($cp,'');
				echo $tela;
				return($sx);
			}
	}
?>