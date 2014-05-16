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
	
	var $id;
	var $cpf;
	var $cliente;
	var $nome;
	
	var $class_include = '../../';
	
	function __contruct()
	{
		$_SESSION['CODIGO'];
		$_SESSION['NOME'];
		$_SESSION['CPF'];
		$_SESSION['MAE'];
		$_SESSION['PAI'];
		$_SESSION['NASCIMENTO'];
		$_SESSION['NATURALIDADE'];
		$_SESSION['AVAL_STA'];
		$_SESSION['AVAL_COD'];
		$_SESSION['RG'];
		$_SESSION['CEP'];
		$_SESSION['RUA'];
		$_SESSION['NUMERO'];
		$_SESSION['BAIRRO'];
		$_SESSION['CIDADE'];
		$_SESSION['ESTADO'];
		$_SESSION['COMPLEMENTO'];
		
	}
	
	function cadastrar_cpf($cpf='')
		{
			$this->cliente = $this->recupera_codigo_pelo_cpf($cpf); 
			if ($this->cliente == 0)
				{
					$acp = new acp;
					$acp ->consulta($cpf,0,'');
					$acp->mostra_consulta($cpf);
					//$this->inserir_cpf($cpf);
				}
			$this->setar_session($this->cliente);
			return($this->cliente);				
		}
		
	function setar_session($cliente)
	{
			$_SESSION['CLIENTE'] = $this->line['pes_cliente'];
			$_SESSION['SEQUENCIA'] = $this->line['pes_cliente_seq'];
			$_SESSION['NOME'] = $this->line['pes_nome'];
			$_SESSION['CPF'] = $this->line['pes_cpf'];
			$_SESSION['MAE'] = $this->line['pes_mae'];
			$_SESSION['PAI'] = $this->line['pes_pai'];
			$_SESSION['NASCIMENTO'] = $this->line['pes_nascimento'];
			$_SESSION['NATURALIDADE'] = $this->line['pes_naturalidade'];
			$_SESSION['AVAL_STA'] = $this->line['pes_avalista'];
			$_SESSION['AVAL_COD'] = $this->line['pes_avalista_cod'];
			$_SESSION['RG'] = $this->line['pes_rg'];
			$_SESSION['CEP'] = $this->line['pes_cep'];
			$_SESSION['RUA'] = $this->line1['pes_rua'];
			$_SESSION['NUMERO'] = $this->line1['pes_cliente'];
			$_SESSION['BAIRRO'] = $this->line1['pes_cliente'];
			$_SESSION['CIDADE'] = $this->line1['pes_cliente'];
			$_SESSION['ESTADO'] = $this->line1['pes_cliente'];
			$_SESSION['COMPLEMENTO'] = $this->line['pes_cliente'];
	}	
	
	function setar_session_endereco()
	{
		
	}
	
	function inserir_cpf($cpf='',$seq='00')
		{
			global $base_name,$base_server,$base_host,$base_user,$base,$conn;
			require($this->class_include."_db/db_mysql_10.1.1.220.php");
			/*
			echo '<br>base_name:'.$base_name;
			echo '<br>base_server:'.$base_server;
			echo '<br>base_host:'.$base_host;
			echo '<br>base_user:'.$base_user;
			echo '<br>base:'.$base;
			echo '<br>base_port:'.$base_port;
			echo '<br>conn:'.$conn;
     		*/
			
			$date = date('Ymd');
			$sql = "insert into ".$this->tabela." 
					(pes_cliente_seq,pes_cpf,pes_data,
					  pes_lastupdate, pes_status)
					values 
					('$seq','$cpf', $date,
					  $date,'@'
					)";
			$rlt = db_query($sql);
			$this->updatex();
			
			return($this->recupera_codigo_pelo_cpf($cpf));
					
		}
	function recupera_codigo_pelo_cpf($cpf='')
		{
			global $base_name,$base_server,$base_host,$base_user,$base,$conn;
			require($this->class_include."_db/db_mysql_10.1.1.220.php");
			/*
			echo '<br>base_name:'.$base_name;
			echo '<br>base_server:'.$base_server;
			echo '<br>base_host:'.$base_host;
			echo '<br>base_user:'.$base_user;
			echo '<br>base:'.$base;
			echo '<br>base_port:'.$base_port;
			echo '<br>conn:'.$conn;
     		*/
			
			$sql = "select * from ".$this->tabela." where pes_cpf = '".$cpf."'";
			if($line = db_read($rlt))
			{
				$this->cpf = $line['pes_cpf'];
				$this->cliente = $line['pes_cliente'];
				$this->nome = $line['pes_nome'];
				$this->line = $line;
				return($line['pes_cliente']);
			}else{
				return(0);
			}	
		}
		
	function cp_00()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			array_push($cp,array('$M','pes_cpf','CPF',False,True));
			array_push($cp,array('$S15','','',TRUE,True));
			array_push($cp,array('$B8','','Consultar >>>',False,True));
			return($cp);
		}
		
	function cp_01()
		{
			$cp = array();
			array_push($cp,array('$H8','id_pes','',False,True));
			array_push($cp,array('$S100','pes_nome','NOME COMPLETO',TRUE,True));
			array_push($cp,array('$D8','pes_nasc','DATA NASCIMENTO',TRUE,True));
			array_push($cp,array('$S30','pes_naturalidade','NATURALIDADE',TRUE,True));
			array_push($cp,array('$S15','pes_rg','RG',TRUE,True));	
			array_push($cp,array('$O : &M:MASCULINO&F:FEMININO','pes_genero','GENERO',TRUE,True));
			array_push($cp,array('$S100','pes_pai','NOME DO PAI',TRUE,True));
			array_push($cp,array('$S100','pes_mae',utf8_encode('NOME DA MÃE'),TRUE,True));
			array_push($cp,array('$O : '.utf8_encode("&S:SIM&N:NÃO"),'pes_avalista','POSSUI AVALISTA?',TRUE,True));
			array_push($cp,array('$S7','pes_avalista_cod',utf8_encode('CÓDIGO AVALISTA'),TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			array_push($cp,array('$H7','pes_cliente_seq','',False,True));
			array_push($cp,array('$H1','pes_status','',False,True));
			array_push($cp,array('$H11','pes_lastupdate','',False,True));
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
		
	function updatex()
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn;
		require($this->class_include."_db/db_mysql_10.1.1.220.php");
		/*
		echo '<br>base_name:'.$base_name;
		echo '<br>base_server:'.$base_server;
		echo '<br>base_host:'.$base_host;
		echo '<br>base_user:'.$base_user;
		echo '<br>base:'.$base;
		echo '<br>base_port:'.$base_port;
		echo '<br>conn:'.$conn;
     	*/	
		$c = 'pes';
		$c1 = 'id_'.$c;
		$c2 = $c.'_cliente';
		$c3 = 5;
		$c3 = $c.'_data';
		$sql = "update ".$this->tabela." set $c2 = lpad($c1,$c3,0) where $c2='' ";
		if ($base=='pgsql') { $sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'".strzero(0,$c3)."')), $c4 =".date('Ymd')." where $c2='' "; }
		$sql = "update ".$this->tabela." set $c2 = trim(to_char(id_".$c.",'70".strzero(0,$c3)."')), $c4 =".date('Ymd'); 
		$rlt = db_query($sql);
		return(0);
	}		
			
	function validaCPF($cpf = null) 
	{
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
 		$this->cpf = $cpf;
        return true;
    }
}
		
		
	}
?>
