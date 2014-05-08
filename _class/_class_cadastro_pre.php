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
			array_push($cp,array('$S100','','NOME COMPLETO',TRUE,True));
			array_push($cp,array('$D8','','DATA NASCIMENTO',TRUE,True));
			array_push($cp,array('$S30','','NATURALIDADE',TRUE,True));
			array_push($cp,array('$S15','','RG',TRUE,True));	
			array_push($cp,array('$O : &M:MASCULINO&F:FEMININO','','GENERO',TRUE,True));
			array_push($cp,array('$S100','','NOME DO PAI',TRUE,True));
			array_push($cp,array('$S100','',utf8_encode('NOME DA MÃE'),TRUE,True));
			array_push($cp,array('$O : '.utf8_encode("&P:PRIMÁRIO&S:SECUNDÁRIO"),'','AVALISTA',TRUE,True));
			array_push($cp,array('$S7','',utf8_encode('CÓDIGO AVALISTA'),TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			return($cp);
			
		}
		
	function cp_02()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			array_push($cp,array('$S11','','CEP',TRUE,True));
			array_push($cp,array('$S100','','RUA',TRUE,True));
			array_push($cp,array('$S10','',utf8_encode('NÚMERO'),TRUE,True));
			array_push($cp,array('$S30','','BAIRRO',TRUE,True));
			array_push($cp,array('$S30','','CIDADE',TRUE,True));
			array_push($cp,array('$UF','','ESTADO',TRUE,True));
			array_push($cp,array('$S30','','COMPLEMENTO',TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			return($cp);
			
		}
		
	function cp_03()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			array_push($cp,array('$S100','','NOME COMPLETO',TRUE,True));
			array_push($cp,array('$D8','','DATA NASCIMENTO',TRUE,True));
			array_push($cp,array('$S30','','NATURALIDADE',TRUE,True));
			array_push($cp,array('$S15','','RG',TRUE,True));	
			array_push($cp,array('$O : &M:MASCULINO&F:FEMININO','','GENERO',TRUE,True));
			array_push($cp,array('$S100','','NOME DO PAI',TRUE,True));
			array_push($cp,array('$S100','',utf8_encode('NOME DA MÃE'),TRUE,True));
			array_push($cp,array('$O : '.utf8_encode("&P:PRIMÁRIO&S:SECUNDÁRIO"),'','AVALISTA',TRUE,True));
			array_push($cp,array('$S7','',utf8_encode('CÓDIGO AVALISTA'),TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			return($cp);
			
		}
	
	function cp_04()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			array_push($cp,array('$S100','','NOME COMPLETO',TRUE,True));
			array_push($cp,array('$D8','','DATA NASCIMENTO',TRUE,True));
			array_push($cp,array('$S30','','NATURALIDADE',TRUE,True));
			array_push($cp,array('$S15','','RG',TRUE,True));	
			array_push($cp,array('$O : &M:MASCULINO&F:FEMININO','','GENERO',TRUE,True));
			array_push($cp,array('$S100','','NOME DO PAI',TRUE,True));
			array_push($cp,array('$S100','',utf8_encode('NOME DA MÃE'),TRUE,True));
			array_push($cp,array('$O : '.utf8_encode("&P:PRIMÁRIO&S:SECUNDÁRIO"),'','AVALISTA',TRUE,True));
			array_push($cp,array('$S7','',utf8_encode('CÓDIGO AVALISTA'),TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			return($cp);
			
		}			
	
	function cp_05()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			array_push($cp,array('$S100','','NOME COMPLETO',TRUE,True));
			array_push($cp,array('$D8','','DATA NASCIMENTO',TRUE,True));
			array_push($cp,array('$S30','','NATURALIDADE',TRUE,True));
			array_push($cp,array('$S15','','RG',TRUE,True));	
			array_push($cp,array('$O : &M:MASCULINO&F:FEMININO','','GENERO',TRUE,True));
			array_push($cp,array('$S100','','NOME DO PAI',TRUE,True));
			array_push($cp,array('$S100','',utf8_encode('NOME DA MÃE'),TRUE,True));
			array_push($cp,array('$O : '.utf8_encode("&P:PRIMÁRIO&S:SECUNDÁRIO"),'','AVALISTA',TRUE,True));
			array_push($cp,array('$S7','',utf8_encode('CÓDIGO AVALISTA'),TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			return($cp);
			
		}
			
	function validaCPF($cpf = null) {
 
    // Verifica se um número foi informado
    if(empty($cpf)) {
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
    else if ($cpf == '00000000000' || 
        $cpf == '11111111111' || 
        $cpf == '22222222222' || 
        $cpf == '33333333333' || 
        $cpf == '44444444444' || 
        $cpf == '55555555555' || 
        $cpf == '66666666666' || 
        $cpf == '77777777777' || 
        $cpf == '88888888888' || 
        $cpf == '99999999999') {
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
 
        return true;
    }
}
		
		
	}
?>
