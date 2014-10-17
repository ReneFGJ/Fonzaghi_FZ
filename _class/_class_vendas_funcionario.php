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
	var $limite_credito;
	var $erro;
	
	function salva_produto($ean13){
		global $base_name,$base_host,$base_user;
		$tamanho = strlen(trim($ean13));
		//2 caracteres
		$sigla = substr(trim($ean13),0,2);
		//1 caracter
		$sigla_j = 	substr(trim($ean13),0,1);
		
		if(($sigla=='60')and($tamanho>=12)){//modas
        	require($this->include_db.'db_fghi_206_modas.php');
        	$lj='M';
			$this->regras_geral($ean13,$lj);
		}elseif(($sigla=='40')and($tamanho>=12)){//modas express
			require($this->include_db.'db_fghi_206_express.php');
			$lj='E';
			$this->regras_geral($ean13,$lj);
		}elseif(($sigla=='70')and($tamanho>=12)){//oculos
			require($this->include_db.'db_fghi_206_oculos.php');
			$lj='O';
			$this->regras_geral($ean13,$lj);
		}elseif(($sigla=='81')and($tamanho>=12)){//sensual
			require($this->include_db.'db_fghi_206_sensual.php');
			$lj='S';
			$this->regras_geral($ean13,$lj);
		}elseif(($sigla=='50')and($tamanho>=12)){//ub
			require($this->include_db.'db_fghi_206_ub.php');
			$lj='U';
			$this->regras_geral($ean13,$lj);
		}elseif($tamanho==6){//joias express
			require($this->include_db.'db_fghi_206_express_joias.php');
			$lj='G';
			echo '<script>alert("'.$tamanho.'")</script>';
			$ean13 = '0000000000'.$ean13;
			$ean13 = '09'.substr($ean13,-9); 
			$ean13 = $this->gera_dv($ean13);
			$this->regras_geral($ean13,$lj);
		}elseif($this->valida_joias($ean13)){//joias
			require($this->include_db.'db_fghi_206_joias.php');
			$lj='J';
			$this->regras_joias($ean13);
		}else{
			$this->erro .= '<h2>Código informado não se enquadra em nenhuma loja</h2>'; 
			return(0);	
		}
		return(1);
	}

	function valida_joias($ean13){
		/*tamanho*/
		$tam = strlen($ean13);
		
		/*tamanho maior ou igual a 4 digitos para ser valido*/
		if($tam>=4){
			/*tipo da peça*/
			$tipo = substr($ean13,0,1);
			/*pega verificador*/
			$dv = substr(trim($ean13),-1);
			/*pontuação da peça*/
			$pt = substr($ean13,1,($tam-3)).'.'.substr($ean13,($tam-2),1);
			$pt = substr(' '.$pt, -4);
			
			$this->joia_produto = $tipo.$pt;
			$this->joia_ponto = $pt;
			$soma = 0;
			/*Soma digitos sem o DV*/
			for ($i=0; $i < ($tam-1) ; $i++) { 
				$soma += substr($ean13,$i,1);
			}
			/*Verifica se ultimo digito da soma é igual DV*/
			if(substr($soma, -1)==$dv){
				return(1);	
			}else{
				$this->erro .= '<h2>Código não pertence a Loja Joias</h2>';
				return(0);
			}
		}else{
			$this->erro .= '<h2>Código não pertence a Loja Joias - verifique se foi informado o digito verificador</h2>';
		}
	}

	/*Calculo diferenciado para joias por pontuação*/
	function regras_joias($ean){
		/*Não possui condição de status ou data de cadastro como as outras lojas*/
			$ref = $this->recupera_ref();
		
			$comissao = 35;
			$vlr_custo = $this->joia_ponto;
			$vlr_venda= ($vlr_custo*$ref*(0.65));
			$produto = $this->joia_produto;
			$ean13='';//nao possui ean13
			$cracha='';
			
				
			$vlr_vendido = (int)(round($vlr_venda*(1-($comissao/100))*100))/100;
			$vlr_vendido = number_format($vlr_vendido,2);
			
			$lj='J';
			$log = $_SESSION['nw_user'];
			$cracha = $_SESSION['user_id'];
			
			$descricao = substr($produto.'/ '.$line['p_descricao'],0,50);
			
			/*Executa as inserções*/
			$this->insere_produto_estoque_joias($produto,$cracha,$vlr_venda,$vlr_custo,$comissao,$log,$vlr_vendido);
			$this->insere_produto_log($ean13,$cracha,$produto,$log);
			$this->insere_usuario_compras($cracha,$lj,$vlr_vendido,$descricao);
		
		return(1);
	}

	function recupera_ref(){
		$sql = "select * from vref
				where ref_data<=".date('Ymd')."
				order by ref_data
				limit 1	";
		
		$rlt = db_query($sql);
		$sx = '';
		if($line = db_read($rlt)){
			$sx = $line['ref_valor'];
		}
		return($sx);
	}
	
	/**Calculo padrao para outras lojas*/
	function regras_geral($ean13,$lj,$log){
		$sql = "select * from (select * from produto_estoque
						where pe_ean13='$ean13') as tb 
						inner join produto on pe_produto=p_codigo
				";
		$rlt = db_query($sql);
		$sx = '';
		if($line = db_read($rlt)){
			$st = $line['pe_status'];
			$dt = $line['pe_data'];
			
			$log = $_SESSION['nw_user'];
			$produto = $line['pe_produto'];
			$vlr_venda = $line['pe_vlr_venda'];
			
			if($lj=='G'){
				
				$ref = $this->recupera_ref();
		
				$comissao = 35;
				$vlr_custo = $vlr_venda;
				$vlr_venda= ($vlr_custo*$ref*(0.65));
				$vlr_vendido = (int)(round($vlr_venda*(1-($comissao/100))*100))/100;
				$vlr_vendido = number_format($vlr_vendido,2);
				
			}else{
				$desconto = $this->desconto($line['pe_comissao']);
				$vlr_vendido = $vlr_venda*((100-$desconto)/100);
				$vlr_vendido = number_format($vlr_vendido,2);
			}
			
			$cracha = $_SESSION['user_id'];
			$descricao = substr($produto.'/ '.$line['p_descricao'],0,50);
			
			 /**verifica se status é valido para venda
			 *verifica se data do cadastro do produto é maior que 60 dias
			 */
			if(($this->valida_status($st, $lj)) and ($this->valida_data_cadastro($dt))){
				/*Executa as inserções*/
				$this->atualiza_produto_estoque($ean13,$cracha,$vlr_vendido,$log);
				$this->insere_produto_log($ean13,$cracha,$produto,$log);
				$this->insere_usuario_compras($cracha,$lj,$vlr_vendido,$descricao);
				return(1);
			}else{
				return(0);
			}			
		}
				
	}
	
	/**Insere registro na tabela produto_estoque - JOIAS*/
	function insere_produto_estoque_joias($produto,$cracha,$vlr_venda,$vlr_custo,$comissao,$log,$vlr_vendido){
		$sql = "
				INSERT INTO produto_estoque(
		            pe_data, pe_cliente, pe_status, 
		            pe_vlr_venda, pe_vlr_custo,pe_tipo_entrada,
		            pe_comissao, pe_produto, 
		            pe_lastupdate,pe_log,pe_vlr_vendido, 
		            pe_inventario, pe_promo, pe_fornecimento, 
		            v_ref, pe_log_eti, pe_validade)
		    	VALUES ( ".date('Ymd').",'F".$cracha."','T',
		    			".$vlr_venda." , ".$vlr_custo.",'A',
		    			".$comissao.", '".$produto."', 
			            ".date('Ymd').",'".$log."', ".$vlr_vendido.", 
			            1, 0, ".date('Ymd').", 
			            0,'".$log."' , 19000101);
				";
		
		$rlt = db_query($sql);
		return(1);
	}
	
	
	/**Atualiza registro da tabela produto_estoque - LOJA*/
	function atualiza_produto_estoque($ean13,$cracha,$vlr_vendido,$log){
		$sql = " update produto_estoque 
				set	pe_cliente='F".$cracha."', 
					pe_status='T',
					pe_vlr_vendido=".$vlr_vendido.",
					pe_lastupdate=".date('Ymd').",
					pe_fornecimento=".date('Ymd').",
					pe_log='".$log."'
				where pe_ean13='".$ean13."'	
		 
		";
		$rlt = db_query($sql);
		return(1);
	}
	/**Insere registro na tabela produto_log - LOJA*/
	function insere_produto_log($ean13,$cracha,$produto,$log){
		$sql = " insert into produto_log_".date('Ym')." 
					(pl_ean13, pl_data, pl_hora,
					pl_cliente, pl_status,pl_produto, 
					pl_log) 
		  			values
					('".$ean13."',".date('Ymd').",'".date('h:i')."',
					'F".$cracha."','T','".$produto."',
					'".$log."')
				";
		$rlt = db_query($sql);
		return(1);
	}
	
	/**Insere registro na tabela usuario_compras - FGHI*/
	function insere_usuario_compras($cracha,$lj,$vlr,$descricao){
		global $base_name,$base_host,$base_user;
		require($this->include_db.'db_fghi.php');
		$venc = date('Ymd',mktime(0,0,0,date('m')+1,1,date('Y'),0));
		$sql = " insert into usuario_compras
					(uc_cracha,us_data,us_hora,
					 us_loja,us_valor,us_parcela,
					 us_valor_parcela,us_venc,us_doc,
					 us_documento,us_descricao)
				 values
				 	('".$cracha."',".date('Ymd').",'".date('h:i')."',
				 	 '".$lj."',".$vlr.",1,
				 	 ".$vlr.",".$venc.",' 1/ 1',
				 	 '".date('ymdhi')."','".$descricao."')";
		$rlt = db_query($sql);
				 	 
		return(1);
	}
	/**verifica comissão do produto
	 * caso esteja zerado considera como 30%
	 * e acrescenta mais 10% sobre o percentual
	 */
	function desconto($comissao){
		if($comissao==0){
			$comissao = 30;
		}
		$comissao = $comissao+((100-$comissao)*0.1);
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
	/* somente peças do estoque primario e vitrine podem ser vendidas
	 * com exceçao da joias expres que se encontra no processo novo de logistica*/
	function valida_status($st,$lj){
		if($st=='B' or $st=='A'){
			/*regra joias express*/
			if($lj=='G' and $st=='A'){
				$this->erro .= '<h2>Status ('.$st.') invalido para loja Joias Express<h2>';
				return(0);
			}else{
				return(1);				
			}
		}else{
			$this->erro .= '<h2>Status ('.$st.') invalido para essa operação<h2>';
			return(0);
		}
		
	}
	
	/* Somente peças cadastras com mais de 60 dias*/
	function valida_data_cadastro($dt){
		$dias = $dt - date('Ymd');
		if($dias>$this->limite_cadastro){
			return(1);	
		}else{
			$this->erro .= '<h2>Cadastro do produto com menos de 60 dias<h2>';
			return(0);
		}
		
	}
	
	function lista_compras($cracha){
		global $base_name,$base_host,$base_user;
		require($this->include_db.'db_fghi.php');
		$sql = "select * from usuario_compras
				where uc_cracha='".$cracha."' and 
					  us_data=".date('Ymd')."
		";
		$rlt = db_query($sql);
		$sx = '<table width="100%" class="tabela00">
				<tr>
					<th class="tabelaTH">Loja</th>
					<th class="tabelaTH">Valor</th>
					<th class="tabelaTH">Data</th>
				</tr>';
		$tt = 0;
		while($line = db_read($rlt)){
			$tt += $line['us_valor'];
		$sx .= '<tr>
					<td class="tabela01" align="center">'.$line['us_loja'].'</td>
					<td class="tabela01" align="right">R$ '.number_format($line['us_valor'],2,',','.').'</td>
					<td class="tabela01" align="center">'.$line['us_data'].'</td>
				</tr>';
		}
		
		$link = '<a align="center" href="javascript:newxy2(\'recibo_funcionario.php?dd1='.$cracha.'\',640,480);"">';
		$sx .= '<tr>
					<td align="center" class="tabelaTH" colspan="2">Total R$ '.number_format($tt,2,',','.').'</td>
					<td>
						'.$link.'
						<div><img width="32px" src="../img/recibo.png"/></div>
						<div>Gerar recibo</div>
						</a>
					</td>
				</tr>';
		$sx .= '</table>';
		
		return($sx);
	}

	function gera_recibo($cracha){
		global $base_name,$base_host,$base_user;
		require($this->include_db.'db_fghi.php');
		
		$sql = "select * from usuario_compras
				where uc_cracha='".$cracha."' and 
					  us_data=".date('Ymd')."
		";
		$rlt = db_query($sql);
		$tt = 0;
		$col =0;
		$lin = 0;
		$branco = '                                                               ';
		while($line = db_read($rlt)){
			$tt += $line['us_valor'];
			if($col==2){
				$sxx .=	chr(13).chr(13).chr(10);
				$col=0;
				$lin +=2;
			}
			$sxx .= '----|'.$line['us_loja'].' | R$ '.substr($branco.number_format($line['us_valor'],2,',','.'),-6).'|'.substr($line['us_descricao'].$branco,0,25).'|';
			$col++;
			
		}
		
		for ($lin; $lin < 20; $lin++) { 
			$sy .=  chr(13).chr(10); 
		}
		$sxx .=	chr(13).chr(10);
		$sx  = 'RECIBO - VENDA FUNCIONARIO ( VIA - FUNCIONARIO)'.chr(13).chr(10);
		$sx .= 'DATA:'.date('d/m/Y h:i').'                          VALOR:R$'.number_format($tt,2,',','.').chr(13).chr(10);
		$sx .= '---------------------------------------------------------------------------------------------'.chr(13).chr(10);	
		$sx .= $sxx;
		$sx .= '---------------------------------------------------------------------------------------------'.chr(13).chr(13).chr(13).chr(10);
		$sx .= 'Atendente:_________________________			Funcionário:______________________'.chr(13).chr(13).chr(10);
		$sx .= 'Fiscal   :_________________________'.chr(13).chr(13).chr(10);
		$sx .= $sy;
		$sx .= '-  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  -  '.chr(13).chr(13).chr(10);
		$sx .= 'RECIBO - VENDA FUNCIONARIO ( VIA - FONZAGHI)'.chr(13).chr(10);
		$sx .= 'DATA:'.date('d/m/Y h:i').'                          VALOR:R$'.number_format($tt,2,',','.').chr(13).chr(10);
		$sx .= '---------------------------------------------------------------------------------------------'.chr(13).chr(10);	
		$sx .= $sxx;
		$sx .= '---------------------------------------------------------------------------------------------'.chr(13).chr(13).chr(13).chr(10);
		$sx .= 'Atendente:_________________________			Funcionário:______________________'.chr(13).chr(13).chr(10);
		$sx .= 'Fiscal   :_________________________'.chr(13).chr(13).chr(10);
		$sx .= $sy;
		
		
		return($sx);
	}
	
}



    
?>