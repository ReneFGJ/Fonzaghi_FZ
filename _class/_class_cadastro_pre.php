<?php
/* PRE Cadastro
 * 
 * 
 * 
 */

class cadastro_pre
	{
		
	var $tabela 				= 'cad_pessoa';
	var $tabela_referencia 		= 'cad_referencia';
	var $tabela_referencia_tipo = 'cad_referencia_tipo';
	var $tabela_endereco 		= 'cad_endereco';
	var $tabela_complemento 	= 'cad_complemento';	
	var $tabela_telefone 		= 'cad_telefone';		
		
	function cp_00()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			array_push($cp,array('$M','','CPF',False,True));
			array_push($cp,array('$S15','','',TRUE,True));
			array_push($cp,array('$B8','','Consultar >>>',False,True));
			return($cp);
		}
		
	function cp_01()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			array_push($cp,array('$S15','','NOME COMPLETO',TRUE,True));
			array_push($cp,array('$D8','','DATA NASCIMENTO',TRUE,True));
			array_push($cp,array('$S20','','NATURALIDADE',TRUE,True));
			array_push($cp,array('$S20','','RG',TRUE,True));	
			array_push($cp,array('$O : &M:MASCULINO&F:FEMININO','','GENERO',TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			return($cp);
		}		
		
	}
?>
