<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
array_push($breadcrumbs, array('/fonzaghi/ger/printers_coleta_todas.php','Coletar dados de totas as impressoras'));

$include = '../';
require($include."cab.php");
require($include."sisdoc_menus.php");

//require("../db.php");
//require($include."letras.css");
require($include."sisdoc_windows.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."cp2_gravar.php");
require($include."biblioteca.php");
require($include."letras.css");
require("../db_206_printers.php");

$sql = '';

$sql = "SELECT id_pr, pr_nome, pr_fila, pr_ip, pr_install, pr_obs, pr_ativa,  ";
$sql .= " pr_counter, pr_codigo, pr_ultimacoleta, pr_tipo ";
$sql .= " FROM printers order by pr_counter";

$rlt = db_query($sql);
//echo $sql;

$pagina='';
$msg_erro=0;
$Handle=0;

while ($line=db_read($rlt)){
	$pagina=pagina_nome($line['pr_counter']);
	
	echo '<br><TT>'.$line['pr_nome'];
	echo $line['pr_codigo'];
	echo $line['pr_ip'];
	echo $line['pr_counter'];
	
	if ($pagina == 'billing_counters.htm'){
		$Handle=fopen(trim($line['pr_counter']),"R");
		if ($Handle){
			$output='';
			while(!feof($Handle)){
				$output.= fgets($Handle,4096);
			}
			fclose($Handle);
			
			$output=strip_tags($output);
			//echo '<br>'.$output;
		
			$pos=strrpos($output,"Total");
			//echo '<br> $pos : '.$pos;
			//echo '<br> output[$pos]: '.$output[$pos];
		
			$entrou=0;$parametro=1;
			$pages=0;$toner=0;
		
			for ($i=$pos; $i<strlen($output); $i++){
				//echo '<br>Caracter: '.$output[$i];
				//echo '<br>ascii: '.ord($output[$i]);
		
				if (ord($output[$i]) >= 48 && ord($output[$i]) <= 57){
					$entrou=1;
				
					if ($parametro == 1){
						$pages.=$output[$i];
					}else{
						$toner.=$output[$i];
					}
				}
				else{
					if ($entrou == 1){
						$parametro=2;
					}
				}
			}
			$pages=$pages*1;
			$toner=$toner*1;
	
			$sql2 = "SELECT id_pc, pc_data, pc_text, pc_pages, pc_tonner, pc_codigo, pc_erro ";
			$sql2 .= " FROM printers_count ";
			$sql2 .= " where pc_data=".date('Ymd')." and pc_codigo='".$line['pr_codigo']."'";
		
			$rlt2 = db_query($sql2);
		
			//echo '<br> registro = '.pg_num_rows($rlt2);
			
			if (pg_num_rows($rlt2)==0){
				$sql3 = "INSERT INTO printers_count(pc_data,  ";
				$sql3 .= " pc_pages, pc_tonner, pc_codigo, pc_erro) ";
				$sql3 .= " VALUES (".date('Ymd').", ".$pages.", ".$toner.", '".$line['pr_codigo']."', 0);";
		
			}
			else{
				$sql3 = " UPDATE printers_count ";
				$sql3 .= " SET pc_pages=".$pages.", pc_tonner=".$toner." ";
				$sql3 .= " where pc_data=".date('Ymd')." and pc_codigo='".$line['pr_codigo']."'";
			}
		
			$rlt3 = db_query($sql3);	
		
			$sql3='';
		
			$pages=0;
			$toner=0;
		}			
		else{
			if ($msg_erro == 0){
				echo '<br><font color="#ff0000"><b>Página(s) não encontrada(s):</b></font>';
				$msg_erro=1;
			}
			echo '<br><font color="#ff0000"><b>'.$line['pr_counter'].'</b></font>';
		}
	}
	else if ($pagina == 'system.cgi'){
		$Handle=fopen(trim($line['pr_counter']),"R");

		if ($Handle){
			$output='';
			while(!feof($Handle)){
				$output.= fgets($Handle,4096);
			}
			fclose($Handle);
			
			$output=strip_tags($output);
			//echo '<br>'.$output;
		
			$pos=strrpos($output,"impressas");
			//echo '<br> $pos : '.$pos;
			//echo '<br> output[$pos]: '.$output[$pos];
			
			$entrou=0;$parametro=1;
			$pages=0;
		
			for ($i=$pos; $i<strlen($output); $i++){
				//echo '<br>Caracter: '.$output[$i];
				//echo '<br>ascii: '.ord($output[$i]);
		
				if (ord($output[$i]) >= 48 && ord($output[$i]) <= 57){
					$entrou=1;
					if ($parametro == 1){$pages.=$output[$i];}
				}
				else{
					if ($entrou == 1){break;}
				}
			}
			$pages=$pages*1;
	
			$sql2 = "SELECT id_pc, pc_data, pc_text, pc_pages, pc_tonner, pc_codigo, pc_erro ";
			$sql2 .= " FROM printers_count ";
			$sql2 .= " where pc_data=".date('Ymd')." and pc_codigo='".$line['pr_codigo']."'";
		
			$rlt2 = db_query($sql2);
		
			//echo '<br> registro = '.pg_num_rows($rlt2);
			
			if (pg_num_rows($rlt2)==0){
				$sql3 = "INSERT INTO printers_count(pc_data,  ";
				$sql3 .= " pc_pages, pc_tonner, pc_codigo, pc_erro) ";
				$sql3 .= " VALUES (".date('Ymd').", ".$pages.", 0, '".$line['pr_codigo']."', 0);";
		
			}
			else{
				$sql3 = " UPDATE printers_count ";
				$sql3 .= " SET pc_pages=".$pages."";
				$sql3 .= " where pc_data=".date('Ymd')." and pc_codigo='".$line['pr_codigo']."'";
			}
		
			$rlt3 = db_query($sql3);	
		
			$sql3='';
		
			$pages=0;
		}
		else{
			if ($msg_erro == 0){
				echo '<br><font color="#ff0000"><b>Página(s) não encontrada(s):</b></font>';
				$msg_erro=1;
			}
			echo '<br><font color="#ff0000"><b>'.$line['pr_counter'].'</b></font>';
		}
	}
	else if ($pagina == 'getUnificationCounter.cgi'){
		$Handle=fopen(trim($line['pr_counter']),"R");

		if ($Handle){
			$output='';
			while(!feof($Handle)){
				$output.= fgets($Handle,4096);
			}
			fclose($Handle);
			
			$output=strip_tags($output);
			//echo '<br>'.$output;
		
			$pos=strrpos($output,"Impressora");
			//echo '<br> $pos : '.$pos;
			//echo '<br> output[$pos]: '.$output[$pos];
			
			$entrou=0;$parametro=1;
			$pages=0;
		
			for ($i=$pos; $i<strlen($output); $i++){
				//echo '<br>Caracter: '.$output[$i];
				//echo '<br>ascii: '.ord($output[$i]);
		
				if (ord($output[$i]) >= 48 && ord($output[$i]) <= 57){
					$entrou=1;
					if ($parametro == 1){$pages.=$output[$i];}
				}
				else{
					if ($entrou == 1){break;}
				}
			}
			$pages=$pages*1;
	
			$sql2 = "SELECT id_pc, pc_data, pc_text, pc_pages, pc_tonner, pc_codigo, pc_erro ";
			$sql2 .= " FROM printers_count ";
			$sql2 .= " where pc_data=".date('Ymd')." and pc_codigo='".$line['pr_codigo']."'";
		
			$rlt2 = db_query($sql2);
		
			//echo '<br> registro = '.pg_num_rows($rlt2);
			
			if (pg_num_rows($rlt2)==0){
				$sql3 = "INSERT INTO printers_count(pc_data,  ";
				$sql3 .= " pc_pages, pc_tonner, pc_codigo, pc_erro) ";
				$sql3 .= " VALUES (".date('Ymd').", ".$pages.", 0, '".$line['pr_codigo']."', 0);";
		
			}
			else{
				$sql3 = " UPDATE printers_count ";
				$sql3 .= " SET pc_pages=".$pages."";
				$sql3 .= " where pc_data=".date('Ymd')." and pc_codigo='".$line['pr_codigo']."'";
			}
		
			$rlt3 = db_query($sql3);	
		
			$sql3='';
		
			$pages=0;
		}
		else{
			if ($msg_erro == 0){
				echo '<br><font color="#ff0000"><b>Página(s) não encontrada(s):</b></font>';
				$msg_erro=1;
			}
			echo '<br><font color="#ff0000"><b>'.$line['pr_counter'].'</b></font>';
		}
	}
}
visualizar_tabela();
require("../foot.php");	

function pagina_nome($endereco){
	//echo'<br>'.$endereco;
	$endereco=trim($endereco);
	//echo '<br> Tamanho do endereço: '.strlen($endereco);
	
	for($i=strlen($endereco); $i > 0; $i--){
		//echo'<br>'.$endereco[$i];
		
		if ($endereco[$i]=='/'){
			//echo '<br>Parei em: '.$i;
			break;
		}
	}
	
	$pagina=substr($endereco, ($i+1), strlen($endereco)-($i-1) );
	//echo '<br>Pagina: '.$pagina;
	
	return $pagina;
}

function visualizar_tabela(){
	global $tab_max;
	
	echo '<table border="0" class="1_naoLinhaVertical" width='.$tab_max.' align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">';
	
	echo '<tr>';
	echo '<td colspan="6">';
	echo '<p><b><i>Aviso:</i></b> Os registros listados abaixo foram cadastrados na data de hoje ('.date('d/m/Y').'). Caso esta operação se repita 
	apenas os campos <b><i>Páginas</i></b> e <b><i>Toner</i></b> serão atualizados.';
	echo '</p>';
	echo '</td>';
	
	echo '<tr>';
	echo '<TD colspan="6" class="lt5" align="center">Registros modificados</td>';
	echo '</tr>';
	
	echo '<tr>';
	echo '<TD colspan="6" class="lt1" align="center">Ordenação: <b><i>http</i></b></td>';
	echo '</tr>';
	
	echo '<TH class="1_th">Data</TH>';
	echo '<TH class="1_th">Código</TH>';
	echo '<TH class="1_th">Nome</TH>';
	echo '<TH class="1_th">http</TH>';
	echo '<TH class="1_th">Páginas</TH>';
	echo '<TH class="1_th">Toner</TH>';
	echo '</tr>';
	
	$sql = "SELECT pc_data, pc_codigo, pr_nome, pr_counter, pc_pages, pc_tonner
	  FROM printers_count
	  left join printers on pr_codigo = pc_codigo
	  where pc_data = ".date('Ymd')."
	  order by pr_counter, pc_data";
	  
	$rlt = db_query($sql);
	
	$reg=0;
	while ($line=db_read($rlt)){
		echo '<tr '.coluna().'>';
	
		echo '<td class="1_td" align="left">';
		echo stodbr($line['pc_data']);
		echo '</td>';
	
		echo '<td class="1_td" align="center">';
		echo $line['pc_codigo'];
		echo '</td>';
	
		echo '<td class="1_td" align="left">';
		echo $line['pr_nome'];
			echo '</td>';
	
		echo '<td class="1_td" align="left">';
		echo $line['pr_counter'];
		echo '</td>';
	
		echo '<td class="1_td" align="center">';
		echo $line['pc_pages'];
		echo '</td>';
	
		echo '<td class="1_td" align="center">';
		echo $line['pc_tonner'];
		echo '</td>';
	
		echo '</tr>';
		$reg++;
	}
	
	echo '<tr>';
	echo '<td colspan="6" class="rodapetotal">'.$reg.' ítens</td>';
	echo '</tr>';
	
	echo '</table>';
}
?>