<?
    /**
     * Promoções
	 * @author Willian Fellipe Laynes <willianlaynes@hotmail.com>
	 * @copyright Copyright (c) 2014 - sisDOC.com.br
	 * @access public
     * @version v.0.14.19
	 * @package promoções
	 * @subpackage classe
    */
    
class promo
{
	 
	var $inicio_promo;
	var $cliente;
	var $oculos_vendidos;
	var $premios_fornecidos;
	var $tela='';
		
    function op_categorias()
    {
        $sql = 'select p_class_1, p_descricao from produto where p_promo=1 group by p_descricao,p_class_1 order by p_class_1';
        $rlt = db_query($sql);
        $op = ' :Selecione a categoria';
        while ($line = db_read($rlt)) {
            $descricao=trim($line['p_descricao']);
            $codigo=trim($line['p_class_1']);
            $op .= '&'.$codigo.':'.$descricao;
        }
        return($op);
    }
	
	function op_premios()
    {
		$sql = 'select p_ean13, p_descricao from produto where p_promo=0 group by p_descricao,p_ean13 order by p_descricao';
        $rlt = db_query($sql);
        $op = ' :Selecione a Prêmio';
        while ($line = db_read($rlt)) {
            $descricao=trim($line['p_descricao']);
            $codigo=$line['p_ean13'];
            $op .= '&'.$codigo.':'.$descricao;
        }
        
        $this->op=$op;
        return($op);
    }
	
	function lista_premios($consultora='',$ean13='', $dt1='', $dt2='',$ordem='')
	{
		if(strlen($consultora)>0){ $tx .= " and pe_cliente = '".$consultora."'";	}
		if(strlen($ean13)>0){ $tx .= " and pe_ean13 = '".$ean13."'";	}
		if(strlen($dt1)>0){	 $tx .= " and pe_data >= ".$dt1;	}
		if(strlen($dt2)>0){	 $tx .= " and pe_data <= ".$dt2;	}
		switch ($ordem) {
			case '0':
				$ordem = 'pe_cliente';
				break;
			case '1':
				$ordem = 'pe_ean13';
				break;
			case '2':
				$ordem = 'pe_data';
				break;
			default:
				$ordem = 'pe_data';
				break;
		}
		$sql = 'select * from produto_estoque 
				where 1=1 '.$tx.' 
				order by '.$ordem;
		$rlt = db_query($sql);
		$sx = '<center><table><tr>
				<th class="tabelaTH" width="20%" align="center">Data</th>
				<th class="tabelaTH" width="20%" align="left">Consultora</th>
				<th class="tabelaTH" width="20%" align="center">Produto</th>
				<th class="tabelaTH" width="20%" align="center">Ean13</th>
				';
		while($line=db_read($rlt))
		{
			$link = '<A HREF="#" onclick="newxy2('.chr(39).'rel_promo_show.php?dd0='.trim($line['pe_cliente']).'&dd1='.trim($line['pe_produto']).'&dd2='.trim($line['pe_ean13']).chr(39).',820,700);">';
			$sx .= '<tr>';
			$sx .= '<td class="tabela00" width="20%" align="center">'.$link.$line['pe_data'].'</a></td>';
			$sx .= '<td class="tabela00" width="20%" align="left">'.$line['pe_cliente'].'</td>';
			$sx .= '<td class="tabela00" width="20%" align="center">'.$line['pe_produto'].'</td>';
			$sx .= '<td class="tabela00" width="20%" align="center">'.$line['pe_ean13'].'</td>';
			$sx .= '</tr>';
			
		}
		$sx .= '</table>'; 
		return($sx);
	}

	function lista_premios2($dt1='', $dt2='',$ordem='')
	{
		if(strlen($dt1)>0)
		{
			$tx .= ' and pe_data>='.$dt1.' ';
		}
		if(strlen($dt2)>0)
		{
			$tx .= ' and pe_data<='.$dt2.' ';
		}
		switch ($ordem) {
			case '0':
				$ordemx = 'pe_produto';
				$th = '<tr><th class="tabelaTH" align="left">Produto</th><th class="tabelaTH" align="left">Grupo</th><th class="tabelaTH" align="center">Quantidade</th></tr>';
				break;
			case '1':
				$ordemx = 'p_class_1';
				$th = '<tr><th class="tabelaTH" align="left">Grupo</th><th class="tabelaTH" align="center">Quantidade</th></tr>';
				break;
			default:
				$ordemx = 'p_class_1';
				break;
		}
		$sql = "select * from (
		
							  select * from produto_estoque 
							  inner join produto 
							  on pe_produto=p_codigo
							  ) as tabela 
			  inner join produto_grupos 
			  on p_class_1 = pg_codigo
				where 1=1 ".$tx." and p_promo=0 and pe_status='T'
				order by ".$ordemx;
				
		$rlt = db_query($sql);
		$sx = '<table>'.$th;
		while($line=db_read($rlt))
		{
			$produto = $line['pe_produto'];
			$grupo = $line['p_class_1'];
			
			switch ($ordem) {
			case '0':
			if(($produto<>$produtox) and (strlen(trim($produtox))>0))
			{
				$sx .= '<tr><td class="tabela00" align="left">'.$prod_descricao.'</td>
							<td class="tabela00" align="left">'.$grupo_descricao.'</td>
							<td class="tabela00" align="center">'.$tt.'</td></tr>';	
				$tt=0;	
			}

			$prod_descricao=$line['p_descricao'];
			$grupo_descricao=$line['pg_descricao'];
			$tt++;		
			$ttt++;	
			$produtox=$produto;
				
			break;
			case '1':
			if($grupo<>$grupox )
			{
				$sx .= '<tr><td class="tabela00" align="left">'.$prod_descricao.'</td><td class="tabela00" align="center">'.$tt.'</td></tr>';	
				$tt=0;	
			}
			$prod_descricao=$line['pg_descricao'];
			$tt++;	
			$ttt++;		
			$grupox=$grupo;
				
				break;
			
		}
			$grupo = $line['p_class_1'];
				
			
			
		}
		if($ordem==1)
			{
				$sx .= '<tr><td class="tabela00" align="left">'.$prod_descricao.'</td><td class="tabela00" align="center">'.$tt.'</td></tr>';	
				$sx .= '<tr><td class="tabelaTH" align="left">Total</td><td class="tabelaTH" align="center">'.$ttt.'</td></tr>';
			}
		if($ordem==0)
			{
				$sx .= '<tr><td class="tabela00" align="left">'.$prod_descricao.'</td>
							<td class="tabela00" align="left">'.$grupo_descricao.'</td>
							<td class="tabela00" align="center">'.$tt.'</td></tr>';	
				$sx .= '<tr><td class="tabelaTH" align="left" colspan="2">Total</td>
							<td class="tabelaTH" align="center">'.$ttt.'</td></tr>';
			}
		$sx .= '</table>'; 
		return($sx);
	}
	/*Promoção 3 óculos 1 cobertor*/
	function verificar_quantidade_oculos_vendidos()
	{
		global $base_name,$base_server,$base_host,$base_user,$user;
        require("../db_fghi_210_oculos.php");   
		
		$sql = "select count(*) from produto_estoque
				where 	pe_vlr_venda > 15 and
						pe_fornecimento>=".$this->inicio_promo." and
						pe_cliente = '".$this->cliente."' and
						pe_status = 'T'
				";
		$rlt = db_query($sql);
		if($line = db_read($rlt))
		{
			$this->oculos_vendidos = $line['count'];
			return($this->oculos_vendidos);
		}else{
			return(0);
		}		
	}
	
	function verificar_quantidade_premios_fornecidos()
	{
		global $base_name,$base_server,$base_host,$base_user,$user;
        require("../db_fghi_206_PROMO.php");
		$sql = "select count(*) from produto_estoque
				where 	pe_fornecimento>=".$this->inicio_promo." and
						pe_cliente = '".$this->cliente."' and
						pe_status = 'T'
				";
		$rlt = db_query($sql);
		if($line = db_read($rlt))
		{
			$this->premios_fornecidos = $line['count'];
			return($this->premios_fornecidos);
		}else{
			return(0);
		}		
	}
	function mostrar_premios_pendentes()
	{
		$tt_oc = $this->verificar_quantidade_oculos_vendidos();
		$tt_pr = $this->verificar_quantidade_premios_fornecidos();
		$tt_di = intval((($tt_oc-($tt_pr*3)))/3);
		$sty1 = 'style="box-sizing: border-box;
					  opacity: 1;
					  width: 50px;
  					  height: 50px;
					  border: 5px solid #E01F06;
					  border-radius: 25px;
					  -webkit-border-radius: 25px;
					  -moz-border-radius: 25px;
					  -ms-border-radius: 25px;
					  -o-border-radius: 25px;
		
		"';
		$sty2 = 'style="box-sizing: border-box;
					  opacity: 1;
					  background-color: #FFF500;
					  width: 50px;
  					  height: 50px;
					  border: 5px solid #2F8F00;
					  border-radius: 25px;
					  -webkit-border-radius: 25px;
					  -moz-border-radius: 25px;
					  -ms-border-radius: 25px;
					  -o-border-radius: 25px;
		
		"';
		if($tt_di>0)
		{
			$sty = $sty2;
			$link = '<a href="javascript:newxy2(\'promo_baixa.php?dd50='.$this->cliente.'\',640,480);">';	
		}else{
			$sty = $sty1;
		}
		
		$this->tela = $link.'<table align="center" '.$sty.'>
						<tr><td align="center">'.$tt_di.'</td></tr>
						</table></a>';
		return(1);
	}

	function cp_promo()
	{
		$cp=array();
		//array_push($cp,array('$S10','','Usuário',True,True,''));
		//array_push($cp,array('$P10','','Senha',True,True,''));
		array_push($cp,array('$T30:15','','Código EAN13 das peças',True,True,''));
		
		return($cp);	
	}
	
	function update($peca)
	{
		global $base_name,$base_server,$base_host,$base_user,$user;
        require("../db_fghi_206_PROMO.php");	
		
		if(strlen(trim($peca))>0){
			$sql = "UPDATE produto_estoque
					SET pe_status='T',
						pe_cliente='".$this->cliente."', 
						pe_lastupdate=".date('Ymd').", 
						pe_log='".$user->user_log."' 
					WHERE pe_ean13 = '".$peca."'";
			db_query($sql);
			
			$sx = 1;
		}else{
			$sx =0;	
		}	
		return($sx);		
	}
	function update_estoque($pecas)
	{
		global $base_name,$base_server,$base_host,$base_user,$user;
        require("../db_fghi_206_PROMO.php");
		$pecas = troca($pecas,chr(13),';');
		$pec = splitx(';',$pecas);
		for ($r=0;$r < count($pec);$r++)
		{
			$peca = $pec[$r];
			if(strlen(trim($wh))>0)
			{
				$wh .= " or pe_ean13 = '".$peca."'";
			}else{
				$wh .= " pe_ean13 = '".$peca."'";
			}	
				
		}
		
		$sql="select * from produto_estoque
			  where $wh "; 
		$rlt=db_query($sql);	
		while ($line=db_read($rlt))
		{
			$pc = trim($line['pe_ean13']);
    		$stax = trim($line['pe_status']);
			$produtox = $line['pe_produto'];
			$clientex = $line['pe_cliente'];
			if($stax<>'T')
			{
				if($this->update($pc)==1){
					$this->tela .= '<h2>'.$pc.' - Salvo consultora ('.$this->cliente.')</h2>';
				}else{
					$this->tela .= '<h2>Não Salvo verificar com TI</h2>';	
				}	
				
			}else{
				$this->tela .= '<h2>Produto já baixado para a consultora '.$clientex.'</h2>';
			}
		}
		
		return(1);
	}
	
	
}
?>