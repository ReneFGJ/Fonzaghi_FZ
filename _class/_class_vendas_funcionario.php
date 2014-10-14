<?php
/**
 * Vendas Funcionário
 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
 * @copyright Copyright (c) 2014 - sisDOC.com.br
 * @access public
 * @version v.0.14.42
 * @package _class
 * @subpackage _vendas_funcionario.php
 */
class vendas_funcionario{
	var $include_db='../../_db/';
	/*limita peças com mais do que 60 dias*/
	var $limite_cadastro;
	var $cracha_funcionario;
	var $atendente;
	var $limite_credito;
	
	
	function valida_loja($ean13){
		global $base_name,$base_host,$base_user;
		$tamanho = strlen(trim($ean13));
		//2 caracteres
		$sigla = substr(trim($ean13),0,2);
		//1 caracter
		$sigla_j = 	substr(trim($ean13),0,1);
		
		if(($sigla=='60')and($tamanho>=12)){//modas
        	require($this->include_db.'db_fghi_206_modas.php');
        	$lj='M';
			$ean = $ean13;
		}elseif(($sigla=='40')and($tamanho>=12)){//modas express
			require($this->include_db.'db_fghi_206_express.php');
			$lj='E';
			$ean = $ean13;
		}elseif(($sigla=='70')and($tamanho>=12)){//oculos
			require($this->include_db.'db_fghi_206_oculos.php');
			$lj='O';
			$ean = $ean13;
		}elseif(($sigla=='81')and($tamanho>=12)){//sensual
			require($this->include_db.'db_fghi_206_sensual.php');
			$lj='S';
			$ean = $ean13;
		}elseif(($sigla=='50')and($tamanho>=12)){//ub
			require($this->include_db.'db_fghi_206_ub.php');
			$lj='U';
			$ean = $ean13;
		}elseif($tamanho<=6){//joias express
			require($this->include_db.'db_fghi_206_express_joias.php');
			$lj='G';
			$ean = '0000000000'.$ean13;
			$ean = '09'.substr($ean,-9); 
			$ean = $this->gera_dv($ean);
		}elseif((strtoupper($sigla_j)=='J')and($tamanho<=6)){//joias
			require($this->include_db.'db_fghi_206_joias.php');
			$lj='J';
			$ean = $ean13;
		}else{
			$lj='teste';	
			$ean = $ean13;
		}
		
		switch ($lj) {
			case 'J':
				/*joias*/
				
				break;
			default:
				/*outras lojas*/
				$sql = "select * from (select * from produto_estoque
						where pe_ean13='$ean') as tb 
						inner join produto on pe_produto=p_codigo
				";
				break;
		}
		
		$rlt = db_query($sql);
		$sx = '';
		if($line = db_read($rlt)){
			$st = $line['pe_status'];
			$dt = $line['pe_data'];
			$vlr_venda = $line['pe_vlr_venda'];
			$comissao = $this->desconto($line['pe_comissao']);
			$vlr_vendido = $vlr_venda*$comissao;
			
			if($this->valida_status($st, $lj) and
				$this->valida_data_cadastro($dt)
			){
				$this->atualiza_registro($ean, $vlr_vendido);
			}			
		}
		return($lj.'-'.$sx.' - '.$sql);
	}
	function atualiza_registro($ean13,$vlr_vendido){
		$sql = " update produto_estoque 
				set pe_status='T',
					pe_cliente='F".$this->cracha_funcionario."',
					pe_vlr_vendido=".$this->vlr_vendido."
				where pe_ean13='".$ean13."'	
		 
		";
		
	}
	
	function desconto($comissao){
		if($comissao==0){
			$comissao = 30;
		}
		$comissao = $comissao+($comissao*0.1);
		$comissao = 1-$comissao;
		return($comissao);
	}
	
	/*gerador de digito verificador*/
	function gera_dv($ean){
		$tt = 0;	
		$tt +=	3*substr($ean, 0,1);
		$tt +=	1*substr($ean, 1,1);
		$tt +=	3*substr($ean, 2,1);
		$tt +=	1*substr($ean, 3,1);
		$tt +=	3*substr($ean, 4,1);
		$tt +=	1*substr($ean, 5,1);
		$tt +=	3*substr($ean, 6,1);
		$tt +=	1*substr($ean, 7,1);
		$tt +=	3*substr($ean, 8,1);
		$tt +=	1*substr($ean, 9,1);
		$tt +=	3*substr($ean, 10,1);
		
		$dv = 10-($tt%10);
		$ean13 = $ean.$dv;
		return($ean13);
	}
	/*somente peças do estoque primario e vitrine podem ser vendidas
	 * com exceçao da joias expres que se encontra no processo novo de logistica*/
	function valida_status($st,$lj){
		if($st=='B' or $st=='A'){
			
			/*regra joias express*/
			if($lj=='G' and $st=='A'){
				return(0);
			}else{
				return(1);				
			}
		}else{
			return(0);
		}
		
	}
	
	/*Somente peças cadastras com mais de 60 dias*/
	function valida_data_cadastro($dt){
		$dias = $dt - date('Ymd');
		if($dias>$this->limite_cadastro){
			return(1);	
		}else{
			return(0);
		}
		
	}
}



    
?>