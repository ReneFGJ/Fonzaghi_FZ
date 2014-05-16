<?php
class acp
    {
    	
	var $xml_link = 'https://www.scpc.inf.br/cgi-bin/spcaxml';
	
	/*Setado via db*/
	var $acp_codigo = '';
	var $acp_senha = '';
	var $acp_service = '';
	var $acp_solicitante = '';
	var $acp_nome = '';
	var $acp_nasc = '';
	var $acp_mae = '';
	  
	/*  CD Cr�dito Direto 
		CP Cr�dito Pessoal 
		CV Cr�dito de ve�culos 
		CC Cart�o de cr�dito 
		CH Cheque 
		OU Outros
	 */
	var $tipo_credito = 'CP';
	var $atualizado;
	var $result;
	var $registrado;
	function __construct()
	{
		global $acp_codigo, $acp_senha, $acp_service, $acp_solicitante;
		$this->acp_codigo = $acp_codigo;
		$this->acp_senha = $acp_senha;
		$this->acp_service = $acp_service;
		$this->acp_solicitante = $acp_solicitante;
	}
	
	function mostra_consulta($cpf,$tel='')
		{
			global $base_name,$base_server,$base_host,$base_user,$base;
			require("../../_db/db_informsystem.php");
			$sql = "select * from consulta_acp where c_cpf = '".$cpf."' 
     				order by c_data desc limit 1
     		";
     		$rlt = db_query($sql);
			
			if ($line = db_read($rlt))
				{
					echo '<br>======================================================================</br>';
					print_r($line);
					$xmlc = $line['c_texto'];
					$xml=simplexml_load_string($xmlc);
				}
				
			echo '<HR>';
			echo 'SPC:'.$xml->{'RESPOSTA'}->{'RESPOSTA-RETORNO'}->{'STATUS-RESPOSTA'};
			
			/* Score */
			$score = $xml->{'RESPOSTA'}->{'REGISTRO-ACSP-SCORE'}->{'SCORE-600-DADOS'}->{'SCORE-600-DADOSR'}->{'SCORE-600-SCORE'};
			echo '<BR>Score:'.$score;
			
			/* Nome */
			$this->acp_nome = $nome = $xml->{'RESPOSTA'}->{'REGISTRO-ACSP-CHQ'}->{'CHQ-250-SINTESE-PF'}->{'CHQ-250-DADOS'}->{'CHQ-250-NOME'};
			$this->acp_nasc = $nasc = $xml->{'RESPOSTA'}->{'REGISTRO-ACSP-CHQ'}->{'CHQ-250-SINTESE-PF'}->{'CHQ-250-DADOS'}->{'CHQ-250-NASCIMENTO'};
			$this->acp_mae  = $mae  = $xml->{'RESPOSTA'}->{'REGISTRO-ACSP-CHQ'}->{'CHQ-250-SINTESE-PF'}->{'CHQ-250-DADOS'}->{'CHQ-251-MAE'};
			echo '<h2>'.$nome.'</h2>';
			echo '<UL>';
			echo '<LI>'.$mae.'</li>';
			//echo '<LI>'.stodbr($nasc).'</li>';
			echo '<LI>'.$nasc.'</li>';
			echo '</ul>';
			
			/* Consulta */
			$nd = $xml->{'RESPOSTA'}->{'REGISTRO-ACSP-CHQ'}->{'CHQ-240-MENSAGEM'}->{'CHQ-240-TEXTO'};
			echo '<UL><LI>Resultado:'.$nd.'</LI></UL>';
			
			echo '<HR>';
			echo '<PRE>';
			print_r($xml);
			echo '</PRE>';			
		}
	
	function consulta_curl($cpf,$tel='')
		{
			$postXML = $this->SPCA_XML($cpf,$tel);
			
			$flt = fopen('acp.xml','w+');
			fwrite($flt,$postXML);
			fclose($flt);
			echo '<A HREF="acp.xml" target="_blank">XML</A>';
			
			$soap_do = curl_init($this->xml_link);
			curl_setopt($soap_do, CURLOPT_URL,            $this->xml_link );   
			curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($soap_do, CURLOPT_POSTFIELDS, $postXML);
			curl_setopt($soap_do, CURLOPT_HTTPHEADER, Array('Content-Type: application/xml; charset=ISO-8859-1'));
			curl_setopt($soap_do, CURLOPT_POSTFIELDS, $postXML);
			
			$result = curl_exec($soap_do);
			$err = curl_error($soap_do); 
			echo '<font color="red">'.$err.'</font><BR>';
			echo '<BR>Consulta realizada';
			
			$this->salva_consulta($cpf,$result);
		}
	
	function salva_consulta($cpf,$result)
		{
			$data = date('Ymd');
			$hora = date('H:i');
			$log = 'AUTO';
			
			$servico = $this->acp_service;
			echo '<br>'.$sql = "insert into consulta_acp
						(
							c_data, c_cpf, c_texto,
							c_log, c_ativo, c_hora, 
							c_servico, c_string, c_resultado
						) values (
							$data,'$cpf','$result',
							'$log',1,'$hora',
							'$servico','','0'
						)		
			";
			$rlt = db_query($sql);
			return(1);
		}
	
	function SPCA_XML($cpf='',$tel='')
		{
			$cr = chr(13).chr(10);
			$cr = chr(13);
			$sx = '<?xml version="1.0"?>'.$cr;
			$sx .= '<SPCA-XML xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="https://www.scpc.inf.br/spcn/spcaxml.xsd">'.$cr;
			$sx .= '<VERSAO>20111101</VERSAO>'.$cr;
			$sx .= '<SOLICITACAO>'.$cr;
			$sx .= '<S-CODIGO>'.$this->acp_codigo.'</S-CODIGO>'.$cr; 
 			$sx .= '<S-SENHA>'.$this->acp_senha.'</S-SENHA>'.$cr; 
 			$sx .= '<S-CONSULTA>'.$this->acp_service.'</S-CONSULTA>'.$cr; 
 			$sx .= '<S-SOLICITANTE>'.$this->acp_solicitante.'</S-SOLICITANTE>'.$cr; 
 			$sx .= '<S-CPF>'.$cpf.'</S-CPF>'.$cr; 
 			$sx .= '<S-RG/>'.$cr; 
 			$sx .= '<S-UFRG/>'.$cr; 
 			$sx .= '<S-RG-DATA/>'.$cr; 
 			$sx .= '<S-RG-DIG/>'.$cr; 
 			$sx .= '<S-CNPJ/>'.$cr; 
 			$sx .= '<S-NASCIMENTO/>'.$cr;
			$sx .= '<S-NOME></S-NOME>'.$cr;
			$sx .= '<S-DDD-1>041</S-DDD-1>'.$cr;
			$sx .= '<S-TELEFONE-1>'.$tel.'</S-TELEFONE-1>'.$cr;
			$sx .= '<S-VALOR>0</S-VALOR>'.$cr;
			$sx .= '<S-TIPO-CREDITO>'.$this->tipo_credito.'</S-TIPO-CREDITO>'.$cr; 
			/*
			 * . CPF 
			 * . Tipo de cr�dito
			 * . Valor
			 * . Os campos n�o utilizados, preencher com brancos ou zeros
			 */
			$sx .= '</SOLICITACAO>'.$cr;
			$sx .= '</SPCA-XML>'.$cr;
			return($sx);
		}
		
		
    function getcontent($server, $port, $file)
    {
        $cont = "";
        $ip = gethostbyname($server);
        $fp = fsockopen($ip, $port);
        if (!$fp)
        {
            return "Unknown";
        }
        else
        {
            $com = "GET $file HTTP/1.1\r\nAccept: */*\r\nAccept-Language: de-ch\r\nAccept-Encoding: gzip, deflate\r\nUser-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.0)\r\nHost: $server:$port\r\nConnection: Keep-Alive\r\n\r\n";
            fputs($fp, $com);
            $it = 0;
            while (!feof($fp))
            {
                $it++;
                $cont .= fread($fp, 2500);
                if ($it > 10)
                    {
                        echo $cont;
                        exit;
                    }
            }
            fclose($fp);
            //$cont = substr($cont, strpos($cont, "\r\n\r\n") + 4);
            return $cont;
        }
    }
	
    function le_http()
        {
            echo '<HR>';
            echo $this->getcontent("csr.consultaacp.com.br", "2462", "/");
            echo '<HR>';
        }
        
    function consulta($cpf,$forced=0,$tel='')
        {
			global $base_name,$base_server,$base_host,$base_user;
			require("../../_db/db_informsystem.php");

			$cpf = strzero(sonumero($cpf),11);
			$ok = $this->last_consulta($cpf);
			if ($forced==1) { $ok = 0; }
			echo '<br>-->'.$forced.'--'.$ok.'--TEL:('.$tel.')';
			if ($ok == 0)
				{
					$this->consulta_curl($cpf,$tel);
				} else {
					echo '<BR>Consulta realizada em: '.$this->atualizado;
				}
			return(1);			            
        }   
		       
     function last_consulta($cpf)
     	{
     		echo '<br>'.$sql = "select * from consulta_acp where c_cpf = '".$cpf."' 
     				order by c_data
     		";
     		$rlt = db_query($sql);
			$ok = 0;
			while ($line = db_read($rlt))
				{
					$ok = 1;
					$this->result = $line['c_texto'];
					$this->atualizado = $line['c_data'];
					$this->registrado = $line['c_resultado'];
				}
			return($ok);
     	}
    }
?>