<?php
   /**
     * Pré-Cadastro
	 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>(Analista-Desenvolvedor)
  	 * @copyright Copyright (c) 2014 - sisDOC.com.br
	 * @access public
     * @version v.0.14.21
	 * @package _class
	 * @subpackage _class_cadastro_pre.php
    */
require_once('../../include/sisdoc_data.php');
require_once('../../include/sisdoc_windows.php');
require_once('../../include/sisdoc_lojas.php');

class cadastro_pre
	{
		
	var $tabela 				= 'cad_pessoa';
	var $tabela_referencia 		= 'cad_referencia';
	var $tabela_referencia_tipo = 'cad_referencia_tipo';
	var $tabela_endereco 		= 'cad_endereco';
	var $tabela_complemento 	= 'cad_complemento';	
	var $tabela_telefone 		= 'cad_telefone';	
	
	var $id='';
	var $cpf='';
	var $cliente='';
	var $nome='';
	var $mae='';
	var $nasc='';
	
	/**Em processo cadastro(geral BD)*/						var $tt_geral_Z = 0;
	/**Aprovados(geral BD)*/								var $tt_geral_A = 0;
	/**Em analise(geral BD)*/								var $tt_geral_T = 0;
	/**Para correcao(geral BD)*/							var $tt_geral_C = 0;
	/**Recusados(geral BD)*/								var $tt_geral_R = 0;
	/**Aprovados que nunca pegaram produtos(geral BD)*/		var $tt_geral_S = 0;
	
	/**Em cadastro(mensal BD)*/								var $tt_mensal_Z = 0;
	/**Aprovados(mensal BD)*/								var $tt_mensal_A = 0;
	/**Em analise(mensal BD)*/								var $tt_mensal_T = 0;
	/**Para correção(mensal BD)*/							var $tt_mensal_C = 0;
	/**Recusados(mensal BD)*/								var $tt_mensal_R = 0;
	/**Aprovados que nunca pegaram produtos(mensal BD)*/	var $tt_mensal_S = 0;
	
	var $class_include = '../../';
	
	function __contruct()
	{
		$_SESSION['ID_PG1']='';
		$_SESSION['ID_PG2']='';
		$_SESSION['ID_PG3']='';
		$_SESSION['ID_PG4']='';
		$_SESSION['ID_PG5']='';
		$this->pesquisa_aprovados_sem_mostruario();
	}
	
	function cadastrar_cpf($cpf='')
		{
			$this->cliente = $this->recupera_codigo_pelo_cpf($cpf); 
			if ($this->cliente == 0)
				{
					$acp = new acp;
					$acp ->consulta($cpf,0,'');
					$acp->mostra_consulta($cpf);
					$this->nome  = $acp->acp_nome;
					$this->nasc = $acp->acp_nasc;
					$this->mae  = $acp->acp_mae;
					$this->inserir_cpf($cpf);
				}
			//$this->setar_session($this->cliente);
			return($this->cliente);				
		}
		 	
	function setar_form_por_session()
	{
		global $dd;
		
			$dd[0] = $_SESSION['CLIENTE'];
			$dd[1] = $_SESSION['NOME'];
			$dd[2] = stodbr($_SESSION['NASCIMENTO']);
			$dd[3] = $_SESSION['NATURALIDADE'];
			$dd[4] = $_SESSION['RG'];
			$dd[5] = $_SESSION['GENERO'];
			$dd[6] = $_SESSION['PAI'];
			$dd[7] = $_SESSION['MAE'];
			$dd[8] = $_SESSION['AVAL_STA'];
			$dd[9] = $_SESSION['AVAL_COD'];
			
		return (1);
	}
	
	function inserir_cpf($cpf='',$seq='00')
		{
			global $base_name,$base_server,$base_host,$base_user,$base,$conn;
			require($this->class_include."_db/db_mysql_10.1.1.220.php");
			$date = date('Ymd');
			if(strlen(trim($this->nome))>0){ $set1 .= ', pes_nome'; $set2 .= ",'$this->nome'";	};
			if(strlen(trim($this->nasc))>0){ $set1 .= ', pes_nasc'; $set2 .= ",'$this->nasc'";	};
			if(strlen(trim($this->mae))>0){ $set1 .= ', pes_mae'; $set2 .= ",'$this->mae'";	};
			echo $sql = "insert into ".$this->tabela." 
					(pes_cliente_seq,pes_cpf,pes_data,
					  pes_lastupdate, pes_status $set1)
					values 
					('".$seq."','$cpf', ".$date.",
					  ".$date.",'@' ".$set2."
					)";
			$rlt = db_query($sql);
			$this->updatex();
			//exit;
			return($this->recupera_codigo_pelo_cpf($cpf));
					
		}
		
	function updatex()
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn;
		require($this->class_include."_db/db_mysql_10.1.1.220.php");
		
		$c = 'pes';
		$c1 = 'id_'.$c;
		$c2 = $c.'_cliente';
		$c3 = 6;
		$sql = "update ".$this->tabela." set $c2 = concat('7', lpad($c1,$c3,0))  where  ($c2='' or $c2 is null )";
		$rlt = db_query($sql);
 		return(0);
	}		
		
	function recupera_codigo_pelo_cpf($cpf='')
		{
			global $base_name,$base_server,$base_host,$base_user,$base,$conn;
			require($this->class_include."_db/db_mysql_10.1.1.220.php");
		
			$sql = "select * from ".$this->tabela." where pes_cpf = '".$cpf."'";
			$rlt = db_query($sql);
			if($line = db_read($rlt))
			{
				$this->id = $line['id_pes'];
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
			array_push($cp,array('$S100','pes_nome','NOME COMPLETO',True,True));
			array_push($cp,array('$D8','pes_nasc','DATA NASCIMENTO',TRUE,True));
			array_push($cp,array('$S30','pes_naturalidade','NATURALIDADE',TRUE,True));
			array_push($cp,array('$S15','pes_rg','RG',TRUE,True));	
			array_push($cp,array('$O : &M:MASCULINO&F:FEMININO','pes_genero','GENERO',TRUE,True));
			array_push($cp,array('$S100','pes_pai','NOME DO PAI',TRUE,True));
			array_push($cp,array('$S100','pes_mae',utf8_encode('NOME DA MÃE'),TRUE,True));
			array_push($cp,array('$O : '.utf8_encode("&S:SIM&N:NÃO"),'pes_avalista','POSSUI AVALISTA?',TRUE,True));
			array_push($cp,array('$S7','pes_avalista_cod',utf8_encode('CÓDIGO AVALISTA'),TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			//array_push($cp,array('$H7','pes_cliente_seq','',True,True));
			//array_push($cp,array('$H1','pes_status','',True,True));
			//array_push($cp,array('$H11','pes_lastupdate','',True,True));
			return($cp);
		
		}
		
	function cp_02()
		{
			$cp = array();
			array_push($cp,array('$H8','id_cmp','',False,True));
			array_push($cp,array('$S8','cmp_salario','SALARIO',TRUE,True));
			array_push($cp,array('$S8','cmp_salario_complementar','SALARIO COMPLEMENTAR',TRUE,True));
			array_push($cp,array('$O : &S:SOLTEIRO&C:CASADO&R:RELACAO ESTAVEL','cmp_estado_civil','ESTADO CIVIL',TRUE,True));
			array_push($cp,array('$S2','cmp_estado_civil_tempo','TEMPO ESTADO CIVIL',TRUE,True));
			array_push($cp,array('$S30','cmp_profissao','PROFISSAO',TRUE,True));
			array_push($cp,array('$S2','cmp_experiencia_vendas','TEMPO EXP. VENDAS',TRUE,True));
			array_push($cp,array('$S8','cmp_valor_aluguel','VALOR ALUGUEL',TRUE,True));
			array_push($cp,array('$S2','cmp_imovel_tempo','TEMPO IMOVEL',TRUE,True));
			array_push($cp,array('$O : &0:RADIO GOSPEL&1:RADIO CAIOBA&2:AMIGOS&3:TV&4:PANFLETOS','cmp_propaganda','PROPAGANDA 1',TRUE,True));
			array_push($cp,array('$O : &0:RADIO GOSPEL&1:RADIO CAIOBA&2:AMIGOS&3:TV&4:PANFLETOS','cmp_propaganda2','PROPAGANDA 2',TRUE,True));
			
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			
			array_push($cp,array('$H8','cmp_cliente','',TRUE,True));
			array_push($cp,array('$H8','cmp_cliente_seq','',TRUE,True));
			array_push($cp,array('$H8','cmp_log','',TRUE,True));
			array_push($cp,array('$H8','cmp_data','',TRUE,True));
			array_push($cp,array('$H8','cmp_lastupdate_log','',TRUE,True));
			array_push($cp,array('$H8','cmp_lastupdate','',TRUE,True));
			array_push($cp,array('$H8','cmp_status','',TRUE,True));
			
			return($cp);
			
		}
		
	function cp_03()
		{
			$cp = array();
			array_push($cp,array('$H8','id_ref','',False,True));
			array_push($cp,array('$S30','ref_nome','NOME',TRUE,True));
			array_push($cp,array('$S15','ref_cep','CEP',TRUE,True));	
			array_push($cp,array('$T50:10','ref_observacao','OBSERVACOES',TRUE,True));
			array_push($cp,array('$S8','ref_grau','GRAU',TRUE,True));
			array_push($cp,array('$S7','ref_status','STATUS',TRUE,True));
			array_push($cp,array('$S7','ref_ativo','ATIVO',TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			
			array_push($cp,array('$H7','ref_cliente','',TRUE,True));
			array_push($cp,array('$H3','ref_cliente_seq','',TRUE,True));
			array_push($cp,array('$H11','ref_data','',TRUE,True));	
			
			return($cp);
		}
		
	function cp_04()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			return($cp);
			
		}
	
	function cp_05()
		{
			$cp = array();
			array_push($cp,array('$H8','','',False,True));
			return($cp);
			
		}
	
	function cp_telefone()
		{
			$cp = array();
			
			array_push($cp,array('$H8','id_tel','',False,True));
			array_push($cp,array('$S3','tel_ddd','DDD',TRUE,True));
			array_push($cp,array('$S9','tel_numero','NUMERO',TRUE,True));	
			array_push($cp,array('$O : &C:CELULAR&R:RESIDENCIAL&E:COMERCIAL','tel_tipo','TIPO',TRUE,True));
			array_push($cp,array('$O : &1:SIM&1:NAO','tel_validado','VALIDADO?',TRUE,True));
			array_push($cp,array('$O : &1:SIM&1:NAO','tel_status','STATUS',TRUE,True));
			array_push($cp,array('$B8','','Salvar >>>',False,True));
			array_push($cp,array('$H7','tel_cliente','',True,True));
			array_push($cp,array('$H3','tel_cliente_seq','',True,True));
			array_push($cp,array('$H11','tel_data','',TRUE,True));
			return($cp);
			
		}			
	
	function cp_endereco()
		{
			$cp = array();
			/*
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
			 * 
			 */
			return($cp);
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
	         
	        for ($t = 9; $t < 11; $t++) 
	        {
	            for ($d = 0, $c = 0; $c < $t; $c++) 
	            {
	                $d += $cpf{$c} * (($t + 1) - $c);
	            }
	            $d = ((10 * $d) % 11) % 10;
	            if ($cpf{$c} != $d) 
	            {
	                return false;
	            }
	        }
	 	$this->cpf = $cpf;
        return true;
    	}
	}

	function listar_contatos ()
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn;
		require($this->class_include."_db/db_mysql_10.1.1.220.php");
		$sql = "select * from cad_contato
				where con_status='@'
				order by con_data,con_lastcall
				";
		$rlt = db_query($sql);
		$sx ='<div width="100%">';
		$sx .= '<table width="95%"><tr>
					<td width="100px" align="center">Data</td>
					<td width="100px" align="center">Ultimo contato</td>
					<td width="100px" align="center">Contato</td>
					</tr>';
		while($line = db_read($rlt))
		{
			$sx .= '<tr class="precad_tr"><td width="100px" align="center">'.stodbr($line['con_data']).'</td>
						<td width="100px" align="center">'.stodbr($line['con_lastcall']).'</td>
						<td width="100px" align="center">'.$line['con_nome'].'</td>
					</tr>';			
		}
		$sx .='</table>';
		$sx .='</div>';

		return($sx);
	}
	
	function calcular_total_status_geral()
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn;
		require($this->class_include."_db/db_mysql_10.1.1.220.php");
		 $sql = 'select pes_status, count(pes_status)  as tt
				from cad_pessoa
				group by pes_status
		';
		$rlt = db_query($sql);
		while($line = db_read($rlt))
		{
			$ttx = $line['tt'];
			switch ($line['pes_status']) 
			{
				case '@':	$this->tt_geral_Z = $ttx;/*em cadastro*/	break;
				case 'A':	$this->tt_geral_A = $ttx;/*aprovados*/  	break;
				case 'T':	$this->tt_geral_T = $ttx;/*em analise*/ 	break;
				case 'C':	$this->tt_geral_C = $ttx;/*para correção*/	break;
				case 'R':	$this->tt_geral_R = $ttx;/*recusados*/		break;	
				default:												break;
			}
		}
		return(1);
	}

	function calcular_total_status_mensal($ano='',$mes='')
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn;
		require($this->class_include."_db/db_mysql_10.1.1.220.php");
		if(strlen(trim($data))==0)
		{
			$ano = date('Y');
			$mes = date('m');
		}
		
		 $sql = 'select pes_status, count(pes_status) as tt
				from cad_pessoa
				where pes_lastupdate>'.$ano.$mes.'00 and
					  pes_lastupdate<'.$ano.$mes.'99
				group by pes_status
		';
		$rlt = db_query($sql);
		$ttx = '';
		while($line = db_read($rlt))
		{
			$ttx = $line['tt'];
			switch ($line['pes_status']) 
			{
				case '@':	$this->tt_mensal_Z = $ttx;/*em cadastro*/	break;
				case 'A':	$this->tt_mensal_A = $ttx;/*aprovados*/  	break;
				case 'T':	$this->tt_mensal_T = $ttx;/*em analise*/ 	break;
				case 'C':	$this->tt_mensal_C = $ttx;/*para correção*/	break;
				case 'R':	$this->tt_mensal_R = $ttx;/*recusados*/		break;	
				default:												break;
			}
		}
		return(1);
	}
	
	function gerar_tabela_tela_inicial()
	{
		$this->pesquisa_aprovados_sem_mostruario();
		$this->calcular_total_status_geral();
		$this->calcular_total_status_mensal();
		$sx = '<table class="cab_banner_table"><tr class="cab_banner_tr_th">
				<th class="cab_banner_th">Em processo de cadastro</td>
				<th class="cab_banner_th">Aprovados sem mostruarios</td>
				<th class="cab_banner_th">Para correcao</td>
				<th class="cab_banner_th">Em analise</td>
				<th class="cab_banner_th">Total de cadastros recusados mensal</td>
				<th class="cab_banner_th">Total de cadastros aprovados mensal</td>
			   </tr><tr class="cab_banner_tr_td">
				<td class="cab_banner_td">'.$this->tt_geral_Z.'</td>
				<td class="cab_banner_td">'.$this->tt_geral_S.'</td>
				<td class="cab_banner_td">'.$this->tt_geral_C.'</td>
				<td class="cab_banner_td">'.$this->tt_geral_T.'</td>
				<td class="cab_banner_td">'.$this->tt_mensal_R.'</td>
				<td class="cab_banner_td">'.$this->tt_mensal_A.'</td>				
				</tr></table>';
		
		
		return($sx);
	}
	/**
	 * Caso tenha mostruario em alguma loja retorna '1' se não retorna '0'
	 */
	function verificar_sem_tem_mostruario($cliente)
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn,$setlj;
		setlj();
		for ($i=0; $i < count($setlj[3]); $i++) 
		{  
			require($this->class_include.'_db/'.$setlj[3][$i]);
			$sql = "select * from kits_consignado
					where 	kh_cliente='".$cliente."' 
			";
			$rlt = db_query($sql);
			if($line = db_read($rlt)){
				 return(1); 
			}
		}
		return(0);
	}	
	
	function pesquisa_aprovados_sem_mostruario()
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn;
		require($this->class_include."_db/db_mysql_10.1.1.220.php");
		$sql = "select * from ".$this->tabela."
				where pes_mostruario = 0 and 
					  pes_status = 'A'
		";
		$rlt = db_query($sql);
		while ($line = db_read($rlt)) 
		{
			$id = $line['id_pes'];
			$cliente = $line['pes_cliente'];
			if($this->verificar_sem_tem_mostruario($cliente))
			{
				$this->atualiza_status_mostruario($id);
			}else{
				++$this->tt_geral_S;
			}
		}
		return(1);
	}
	
	/*Seta com 1 pes_mostruario*/
	function atualiza_status_mostruario($id)
	{
		global $base_name,$base_server,$base_host,$base_user,$base,$conn;
		require($this->class_include."_db/db_mysql_10.1.1.220.php");
		
		$sql = "update ".$this->tabela." 
				set  pes_mostruario=1
				where id_pes=".$id."
		";
		$rlt = db_query($sql);
		db_read($rlt);
		return(1);
	}
	
}
?>
