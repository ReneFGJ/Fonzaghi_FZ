<?php
    /**
     * GED
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage ged
    */
class ged
	{
		var $id_file;
		var $file_name;
		var $file_size;
		var $file_path;
		var $file_type;
		var $file_date;
		var $file_time;
		var $file_saved;
		var $protocol;
		var $versao;
		
		/* Class CSS */
		var $table_class = '';
		
		/* Ref. Upload */
		var $up_path; /* Pasta de destino */
		var $up_maxsize; /* Tamanho maximo do upload */
		var $up_format = array('*'); /* Formatos aceitos */
		var $up_month_control = 1; /* Criar pastas conforme o mes de postagem */
		var $up_doc_type;
		
		var $total_files = 0;
		/* Dados da tabela */
		var $tabela = '';
		
		function upload_botton_with_type($proto='',$base='',$tp='',$bt='')
			{
				global $messa, $edit_mode;
				if ($tp == '')
				{				
					$sx = '
					<select id="filetype_1">
						<option>::'.msg('Tipo do documento').'::</option>
					';
					$sql= "select * from ".$this->tabela.'_tipo where doct_ativo = 1 order by doct_nome';
					$rlt = db_query($sql);
					while ($line = db_read($rlt))
						{
							$check = '';
							if (trim($line['doct_codigo']) == $tp) { $check = "selected"; }
							$sx .= '<option value="'.trim($line['doct_codigo']).'" '.$check.'>';
							$sx .= trim($line['doct_nome']);
							$sx .= '</option>';
						}								
					$sx .= '
					</select>';
				} else {
					$sx .= '<input type="hidden" value="'.$tp.'" id="filetype_1">';
				}
				$sx .= '
				<input type="button" value="'.msg('Adicionar').'" id="fileup">
				<input type="hidden" id="filetype_2" value="">
				<input type="hidden" id="filetype_3" value="">
				<script>
					$("#fileup").click(function() 
						{
				  		var dd10=$("#filetype_1").val();
						var dd11=$("#filetype_2").val();
						var dd13=$("#filetype_3").val();
						var url = \'ged_upload.php?dd5='.trim($base).'&dd1='.$proto.'\&dd2=\'+dd10;
						NewWindow=window.open(url,\'newwin3\',\'scrollbars=yes,resizable=yes,width=600,height=300,top=10,left=10\');  
						NewWindow.focus(); 
						void(0);
						});
				</script>';

				return($sx);
			}
						
		function upload_botton($tp='',$bt='')
			{
				if (strlen($bt)==0) { $bt=msg('Adicionar'); }
				$link = "javascript:newxy2('ged_upload.php?dd1=".$this->protocol."&dd2=".$tp."',400,400);";
				$link = '<A HREF="'.$link.'">';
				$link .= $bt;
				$link .= '</A>';
				return($link); 
			}

		function cp()
			{
				global $messa;
				$cp = array();
				array_push($cp,array('$H8','id_doct','id',False,true));
				array_push($cp,array('$S5','doct_codigo',msg('codigo'),true,true));
				array_push($cp,array('$S100','doct_nome',msg('nome'),true,true));
				array_push($cp,array('$O 1:SIM&0:NAO','doct_ativo',msg('ativo'),False,true));
				
				array_push($cp,array('$O 1:SIM&0:NAO','doct_publico',msg('publico'),False,true));
				array_push($cp,array('$O 1:SIM&0:NAO','doct_avaliador',msg('avaliador'),False,true));
				array_push($cp,array('$O 1:SIM&0:NAO','doct_autor',msg('autor'),False,true));
				array_push($cp,array('$O 0:NAO&1:SIM','doct_restrito',msg('restrito'),False,true));

				return($cp);
			}
		function updatex()
			{
				return(1);
			}
		function row()
			{
				global $cdf,$cdm,$masc;
				$cdf = array('id_doct','doct_nome','doct_publico','doct_avaliador','doct_autor','doct_restrito','doct_ativo');
				$cdm = array('cod',msg('nome'),msg('publico'),msg('avaliador'),msg('autor'),msg('restrito'),msg('ativo'));
				$masc = array('','','SN','SN','SN','SN','SN','SN');
				return(1);				
			}		
		
		function download_send()
			{
        		header("Pragma: public");
        		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");					
				header("Expires: 0");
				//header('Content-Length: $len');
				header('Content-Transfer-Encoding: none');
				$file_extension = $this->file_type;
				switch( $file_extension ) {
	      			case "pdf": $ctype="application/pdf"; break;
    	  			case "exe": $ctype="application/octet-stream"; break;
	      			case "zip": $ctype="application/zip"; break;
	      			case "doc": $ctype="application/msword"; break;
	      			case "xls": $ctype="application/vnd.ms-excel"; break;
	      			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
	      			case "gif": $ctype="image/gif"; break;
	      			case "png": $ctype="image/png"; break;
	      			case "jpeg":
	      			case "jpg": $ctype="image/jpg"; break;
	      			case "mp3": $ctype="audio/mpeg"; break;
	      			case "wav": $ctype="audio/x-wav"; break;
	      			case "mpeg":
	      			case "mpg":
	      			case "mpe": $ctype="video/mpeg"; break;
	      			case "mov": $ctype="video/quicktime"; break;
	      			case "avi": $ctype="video/x-msvideo"; break;
					}
				header("Content-Type: $ctype");
				header('Content-Disposition: attachment; filename="'.$this->file_name.'"');
				header("Content-type: application-download");
				header("Content-Transfer-Encoding: binary");				
				readfile($this->file_path);
			}
		
		function download($id='')
			{
				$arq = $this->file_path;
				if (strlen($id) > 0) { $this->id_file = $id; }
				if ($this->le($this->id_file))
					{
						$arq = $this->file_path;
						if (!(file_exists($arq)))
							{
								echo $arq;
								echo '<BR> Arquivo n�o localizado ';
								echo '<BR> Reportando erro ao administrador';
							exit;
							} else {
								/** Download do arquivo **/
								$this->download_send();
							}
					} else { echo '<BR><font color="red">ID not found'; }							
			}
		
		function le($id)
			{
				if (strlen($id) > 0) { $this->id_file = $id; }
				if (strlen($this->tabela) > 0)
					{
						$sql = "select * from ".$this->tabela;
						$sql .= " where id_doc = ".round($this->id_file);
						$sql .= " limit 1 ";
						$rlt = db_query($sql);
						if ($line = db_read($rlt))
							{
								$this->id_file = trim($line['id_doc']);
								$this->file_name = trim($line['doc_filename']);
								$this->file_size = trim($line['doc_size']);
								$this->file_path = trim($line['doc_arquivo']);
								$this->file_type = trim($line['doc_extensao']);
								$this->file_date = trim($line['doc_data']);
								$this->file_saved = trim($line['doc_ativo']);
								return(1);
							} else {
								echo msg('file_not_found');
							}
						
					} else { echo msg('table_not_set'); }
				return(0);								
			}
			
		function filelist_download()
			{
				global $messa,$secu,$ged_del,$dd,$LANG;
				$sx .= '<h3>Documentos anexados</h3>';
				$sx .= '<table width=100% class="'.$this->table_class.'">';
				$sx .= '<TR>';
				$sx .= '<TH width="30%">'.msg('T�tulo do arquivo');
				$sx .= '<TH width="60%">'.msg('Nome do arquivo');
				$sx .= '<TH width="10%">'.msg('Tamanho do arquivo');
			
				$sql = "select * from ".$this->tabela;
				$sql .= " left join ".$this->tabela."_tipo on doc_tipo = doct_codigo ";
				$sql .= " where doc_dd0 = '".$this->protocol."' and doc_ativo=1 ";
				$sql .= " order by doc_data desc, doc_hora desc, id_doc desc ";
				$rlt = db_query($sql);
				$tot = 0;
				while ($line = db_read($rlt))
					{
						$type = trim($line['doc_type']);
						$capt = trim($line['doct_nome']);
						if (substr($capt,0,1)=='#') { $capt = msg(substr($capt,1,strlen($capt))); }
						//$link = 'ged_download.php?dd0='.$line('id_doc').'&dd90='.checkpost($line['id_doc'].$secu);
						$link = 'ged_download.php?dd0='.$line['id_doc'];
						$link .= '&dd50='.$this->tabela;
						$link .= '&dd90='.checkpost($line['id_doc'].$secu);
						$link .= '&dd91='.$secu;
						$link = newwin($link,300,150);
						$sx .= '<TR>';
						$sx .= '<TD>'.$link.$capt.'</A>';
						$sx .= '<TD><B>'.$link.msg(trim($line['doc_filename'])).'</B></A>';
						$sx .= '<TD align="center" class="lt0">'.$this->size_mask($line['doc_size']).'</A>';
						$tot++;
					}
				$frame = $dd[3];
				$sx .= '</table>'.chr(13);
				$this->total_files = $tot;
				return($sx);	
			}
			
		function filelist()
			{
				global $messa,$secu,$ged_del,$dd,$LANG;
				
				$sx .= '<h3>Documentos anexados</h3>';
				$sx .= '<table width=100% cellpadding=2 cellspacing=0 border=0 class="lt1 left radius5 margin5 pad5 border1 orange_light">';
				$sx .= '<TR>';
				$sx .= '<TH align="left">'.msg('T�tulo do arquivo');
				$sx .= '<TH align="left">'.msg('Nome do arquivo');
				$sx .= '<TH>'.msg('Tamanho do arquivo');
				$sx .= '<TH>'.msg('Data do arquivo');
				$sql = "select * from ".$this->tabela;
				$sql .= " left join ".$this->tabela."_tipo on doc_tipo = doct_codigo ";
				$sql .= " where doc_dd0 = '".$this->protocol."' and doc_ativo=1 ";
				$sql .= " order by doc_data desc, doc_hora desc, id_doc desc ";
				$rlt = db_query($sql);
				$tot = 0;
				while ($line = db_read($rlt))
					{
						$capt = msg(trim($line['doct_nome']));
						if (substr($capt,0,1)=='#') { $capt = msg(substr($capt,1,strlen($capt))); }
						//$link = 'ged_download.php?dd0='.$line('id_doc').'&dd90='.checkpost($line['id_doc'].$secu);
						$link = 'ged_download.php?dd0='.$line['id_doc'];
						$link .= '&dd50='.$this->tabela;
						$link .= '&dd90='.checkpost($line['id_doc'].$secu);
						$link .= '&dd91='.$secu;
						//$link = newwin($link,300,150);
						$link = ' <A href="'.$link.'" target="_new'.$line['id_doc'].'"  > ';
						$sx .= '<TR>';
						$sx .= '<TD>'.$link.$capt.'</A>';
						$sx .= '<TD>'.$link.$line['doc_filename'].'</A>';
						$sx .= '<TD align="center" class="lt0">'.$this->size_mask($line['doc_size']).'</A>';
						$sx .= '<TD align="center" class="lt0">'.stodbr($line['doc_data']).' '.$line['doc_hora'].'</A>';
						$tot++;
					}
				$frame = $dd[3];
				$sx .= '</table>'.chr(13);
				$this->total_files = $tot;
				return($sx);
			}	
			
		function file_list()
			{
				global $messa,$secu,$ged_del,$dd,$page,$popup;
				$sx = '<table width=100% cellpadding=2 cellspacing=0 border=1 class="lt1">';
				$sx .= '<TR>';
				$sx .= '<TH>'.msg('file_name');
				$sx .= '<TH>'.msg('file_filename');
				$sx .= '<TH>'.msg('file_size');
				$sx .= '<TH>'.msg('file_data');
				$sx .= '<TH>'.msg('file_acao');
				$sql = "select * from ".$this->tabela;
				$sql .= " left join ".$this->tabela."_tipo on doc_tipo = doct_codigo ";
				$sql .= " where doc_dd0 = '".$this->protocol."' and doc_ativo=1 ";
				if (strlen($this->file_type) > 0)
					{ $sql .= " and doc_tipo = '".$this->file_type."' ";}
				$sql .= " order by doc_data desc, doc_hora desc, id_doc desc ";
				$rlt = db_query($sql);
				
				$tot = 0;
				while ($line = db_read($rlt))
					{
						
						$capt = trim($line['doct_nome']);
						if (substr($capt,0,1)=='#') { $capt = msg(substr($capt,1,strlen($capt))); }
												
						//$link = 'ged_download.php?dd0='.$line('id_doc').'&dd90='.checkpost($line['id_doc'].$secu);
						$link = 'ged_download.php?dd0='.$line['id_doc'];
						$link .= '&dd50='.$this->tabela;
						$link .= '&dd90='.checkpost($line['id_doc'].$secu);
						$link .= '&dd91='.$secu;
						$link = ' <A href="'.$link.'" target="_new'.$line['id_doc'].'"  > ';
						$sx .= '<TR>';
						$sx .= '<TD>'.$link.$capt.'</a>';
						$sx .= '<TD>'.$link.$line['doc_filename'].'</a>';
						$sx .= '<TD align="center" class="lt0">'.$this->size_mask($line['doc_size']).'</A>';
						$sx .= '<TD align="center" class="lt0">'.stodbr($line['doc_data']).' '.$line['doc_hora'].'</A>';
						$sx .= '<TD align="center">';
				
						if ($line['doc_status'] == '@')
							{
								if ((strlen($frame) > 0) or (strlen($popup) > 0))
								{
									if (strlen($popup) > 0)
										{
											$sx .= '<a href="javascript:newxy2(\'ged_delete.php?dd0='.$line['id_doc'].'&dd2=DEL&dd90='.checkpost($line['id_doc']).'&dd91='.$secu.'&dd50='.$this->tabela.'\',400,200);">';
								 			$sx .= '<img src="img/icone_remove.png" border=0 >';
											$sx .= '</A>';
										} else {
								 			$sx .= '<img src="img/icone_remove.png" id="remove" onclick="ged_excluir('.$line['id_doc'].');">';
											$sx .= '</A>';
										}
								} else {
									
									$link = page().'?page='.$page.'&ddf='.$line['id_doc'].'&ddg=DEL';
									$link .= '&ddh='.checkpost($line['id_doc'].$secu);
									$sx .= '<A HREF="'.$link.'">';
								 	$sx .= '<img src="img/icone_remove.png" id="remove" onclick="ged_excluir('.$line['id_doc'].');" border=0>';
									$sx .= '</A>';				
								}
							}
						$tot++;
					}
				$frame = $dd[3];
				if ($tot == 0) { $sx .= '<TR><TD colspan=5 align=center><font color="red"><B>'.msg('not_file_posted').'</B></font>'; }
				$sx .= '</table>'.chr(13);
				if (strlen($frame) > 0)
					{
					$sx .= '<script type="text/javascript">'.chr(13);
					$sx .= 'function ged_excluir(id)'.chr(13);
					$sx .= " { alert('ola'); ";
					$sx .= '    var tela01 = $.ajax( "'.page().'?dd0="+id+"&dd1='.$dd[1].'&dd2=files_del&dd3='.$frame.'&dd90='.$dd[90].'" ) .done(function(data) { $("#'.$frame.'").html(data); }) .fail(function() { alert("error"); }) .always(function(data) { $("#'.$frame.'").html(data); }); '.chr(13);
					$sx .= " } ";		
					$sx .= '</script>'.chr(13);
					}
				return($sx);
			}	

		function convert($tb1,$tb2)
			{
				$sql .= "select * from ".$tb1." where pl_codigo = '".$this->protocol."' ";
				$rlt = db_query($sql);
				while ($line = db_read($rlt))
					{
						$protocolo = $line['pl_codigo'];
						$tipo = trim($line['pl_tp_doc']);
						$ano = substr($line['pl_data'],0,4);
						$filename = trim($line['pl_texto']);
						$data = $line['pl_data'];
						$hora = $line['pl_hora'];
						$file = $line['pl_codigo'];
						$ext = $line['pl_type'];
						$size = $line['pl_size'];
						$file = '/pucpr/httpd/htdocs/www2.pucpr.br/reol/pibic/public/submit/';
						$file .= substr($data,0,4).'/'.substr($data,4,2).'/';
						$file .= trim($line['pl_filename']);
						$ok=0;
						if ($tipo == '00006') { $tipo = 'PLANO'; $ok=1; }
						echo '</font>';
						if ($ok==0) { echo 'Erro de tipo '.$tipo; exit; }

						$sql = "insert into ".$tb2." (
							doc_dd0, doc_tipo, doc_ano, 
							doc_filename, doc_status, doc_data, 
							doc_hora, doc_arquivo, doc_extensao, 
							doc_size, doc_ativo
							) values (
							'$protocolo','$tipo','$ano',
							'$filename','A','$data',
							'$hora','$file','$ext',
							$size,1
							)";
						$rrr = db_query($sql);
						$sql = "update ".$tb1." set pl_codigo = 'X".substr($protocolo,1,6)."' where id_pl = ".$line['id_pl'];
						$rrr = db_query($sql);
					}
				return(1);
			}

		function file_delete()
			{
				$sql = "update ".$this->tabela;
				$sql .= " set doc_ativo = 0 ";
				$sql .= " where id_doc = ".$this->id_doc;
				$rlt = db_query($sql);
				return(1);
			}	
		
		function file_undelete()
			{
				$sql = "update ".$this->tabela;
				$sql .= " set doc_ativo = 1 ";
				$sql .= " where id_doc = ".$this->id_doc;
				$rlt = db_query($sql);
				return(1);
			}	

		function file_attach_form()
			{
				global $dd,$messa,$acao,$tipo;
				$page = page().'?';
				$page .= 'dd0='.$dd[0].'&dd5='.$dd[5].'&dd2='.$dd[2].'&dd1='.$dd[1].'&dd90='.$dd[90];
				$saved = 0;
				
				if (strlen($acao) > 0)
					{
						$tipo = $dd[2];
					    $nome = lowercasesql($_FILES['arquivo']['name']);
    					$temp = $_FILES['arquivo']['tmp_name'];
						$size = $_FILES['arquivo']['size'];

						$path = $this->up_path;
						$extensoes = $this->up_format;
						
						/* valida extensao */
						$ext = strtolower($nome);
						while (strpos(' '.$ext,'.') > 0)
							{ $ext = substr($ext,strpos($ext,'.')+1,strlen($ext)); }
						$ext = '.'.$ext;
										
						$ind = -1;
						
						for ($rt=0;$rt < count($extensoes);$rt++)
							{ if ($ext == $extensoes[$rt]) { $ind = $rt; }	}
							
						if ($extensoes[0] == '*') { $ind=0; }
						if ($ind < 0) { $erro = '<font color=red >Erro:01 - '.msg('erro_extensao').'</font>'; }

						/* diret�rio */
						$nome = substr($nome,0,strlen($nome)-4);
						$nome = lowercasesql(troca($nome,' ','_'));
						$nome .= $ext;
		
						if (strlen($tipo)==0)
							{ $erro = msg('type_doc_not_defined'); }

						$this->dir($path);
						if ($this->up_month_control == 1)
							{
								$path .= date("Y").'/'; $this->dir($path);
								$path .= date("m").'/'; $this->dir($path);
							}
						
						/* caso n�o apresente erro */
						if (strlen($erro)==0) 
						{
							$compl = $dd[1].'-'.substr(md5($nome.date("His")),0,5).'-';
							$compl = troca($compl,'/','-');
        					if (!move_uploaded_file($temp, $path .$compl.$nome))
            					{ $erro = msg('Erro ao salvar'); } else 
            					{
            						$this->file_saved = $path.$compl.$nome;
            						$this->file_name = $nome;
									$this->file_size = $size;
									$this->file_path = $path;
									$this->file_data = date("Ymd");
									$this->file_time = date("H:i:s");
									$this->file_type = $tipo;
									$this->protocol = $dd[1];
									$this->save();          						
									$saved = 1;
									if (file_exists('close.php')) { require("close.php"); exit; }
									require("../close.php");
								}		
						} else {
							echo '<center>'.msg($erro).'</center>';
						}
						
				}

			if ($saved == 0)
				{
				$options = '<option value="">'.msg('not_defined').'</option>';
				$options .= $this->documents_type_form();
				$page = page();
		
				$sx .= '<form id="upload" action="'.$page.'" method="post" enctype="multipart/form-data">
					<fieldset><legend>'.msg('file_tipo').'</legend>
    				<select name="dd2" size=1>'.$options.'</select>
    				</fieldset>
    				<BR>
	    			<nobr><fieldset><legend>'.msg('Enviar arquivo').'</legend> 
    				<span id="post"><input type="file" name="arquivo" id="arquivo" /></span>
    				<input type="hidden" name="dd0" value="'.$dd[0].'"> 
    				<input type="hidden" name="dd1" value="'.$dd[1].'">
    				<input type="hidden" name="dd5" value="'.$dd[5].'">  
    				<input type="hidden" name="dd90" value="'.$dd[90].'"> 
    				<input type="submit" value="enviar arquivo" name="acao" id="idbotao" />
    				</fieldset>  
    				<BR>
    				<fieldset><legend>'.msg('Tipo do arquivo').'</legend>
    				MaxSize: <B>'.numberformat($this->up_maxsize / (1024 * 1024),0,',','.').'MByte</B>
    				&nbsp;&nbsp;&nbsp;
					Extension Valid: <B>'.$this->display_extension().'</B>';
				$sx .= '</fieldset></form>';
				}
				$sc .= '<font color="black">';
				$sc .= '<center><h2>'.msg('gt_'.substr($this->tabela,0,10)).'</h2></center>';
				$sc .= '<div>'.msg('gi_'.substr($this->tabela,0,10)).'</div>';
			return($sc.$sx);
			}

		function display_extension()
			{
				$sx = '';
				$ext = $this->up_format;
				for ($r=0;$r < count($ext);$r++)
					{
						if (strlen($sx) > 0) { $sx .= ', '; }
						$sx .= $ext[$r];
					}
				return($sx);
			}
		function documents_type_form()
			{
				global $dd;
				$sql = "select * from ".$this->tabela."_tipo where doct_ativo = 1 ";
				$rlt = db_query($sql);
				$sx = '';
				while ($line = db_read($rlt))
					{
						$sel = '';
						if (trim($dd[2]) == trim($line['doct_codigo'])) { $sel = 'selected'; }
						$sx .= '<option value="'.$line['doct_codigo'].'" '.$sel.'>';
						$sx .= msg(trim($line['doct_nome']));
						$sx .= '</option>';
						$sx .= chr(13);
					}
				return($sx);
				
			}
		function save()
			{
				$sql = "insert into ".$this->tabela;
				$sql .= " (doc_dd0,doc_tipo,doc_ano,doc_filename,doc_status,doc_data,doc_hora,
							doc_arquivo,doc_extensao,doc_size,doc_ativo,
							doc_versao)";
				$sql .= " values ";
				$sql .= " ('".$this->protocol."',";
				$sql .= "'".$this->file_type."',";
				$sql .= "'".date("Y")."',";
				$sql .= "'".$this->file_name."',";
				$sql .= "'@',";
				$sql .= "'".$this->file_data."',";
				$sql .= "'".substr($this->file_time,0,5)."',";
				$sql .= "'".$this->file_saved."',";
				$sql .= "'".$this->file_extensao($this->file_name)."'";
				$sql .= ",".round($this->file_size);
				$sql .= ",1 ";
				$sql .= ",'".$this->versao."'";
				$sql .= " )";
				$rlt = db_query($sql);
			}
			
		/* recupera a extens�o do aquivo */
		function file_extensao($fl)
			{
				$fl = lowercase($fl);
				$fs = strlen($fl);
				$ex = '???';
				if (substr($fl,$fs-1,1) == '.') { $ex = substr($fl,$fs,1); }
				if (substr($fl,$fs-2,1) == '.') { $ex = substr($fl,$fs-1,2); }
				if (substr($fl,$fs-3,1) == '.') { $ex = substr($fl,$fs-2,3); }
				if (substr($fl,$fs-4,1) == '.') { $ex = substr($fl,$fs-3,4); }
				if (substr($fl,$fs-5,1) == '.') { $ex = substr($fl,$fs-4,5); }
				return(substr(trim($ex),0,4));
				}

		/* checa e cria diretorio */
		function dir($dir)
			{
				if (is_dir($dir))
					{ $ok = 1; } else 
					{
						mkdir($dir);
						$rlt = fopen($dir.'/index.php','w');
						fwrite($rlt,'acesso restrito');
						fclose($rlt);
					}
				return($ok);
			}
			
		/* Mascara do tamanho em Bytes */
		function size_mask($limit)
			{
				$limit = round($limit);
				if ($limit >= (1024 * 1024))
				{
					$limit_u = 's';
					$limit_msk = round(10 * $limit / (1024*1024))/10;
					$limit_unidade = "Mega"; 
					if ($limit_msk == 1) { $limit_u = ''; }
				} else {
					$limit_u = 's';
					$limit_msk = round(10 * $limit / (1024))/10;
					$limit_unidade = "k";
					if ($limit_msk == 1) { $limit_u = ''; }
				}
			return($limit_msk.' '.$limit_unidade. 'B'.$limit_u);
			}
		function structure()
			{
				//$sql = "DROP TABLE ".$this->tabela;
				//$rlt = db_query($sql);
				
				$table = $this->tabela;
				if (strlen($this->tabela)==0) { echo 'Table name not found'; exit; }
				$sql = "CREATE TABLE ".$table." (
  						id_doc serial NOT NULL,
  						doc_dd0 char(7),
  						doc_tipo char(5),
  						doc_ano char(4),
  						doc_filename text,
  						doc_status char(1),
  						doc_data integer,
  						doc_hora char(8),
  						doc_arquivo text,
  						doc_extensao char(4),
  						doc_size float,
  						doc_ativo integer
						) ";
				$rlt = db_query($sql);
						
				
				$sql = "CREATE TABLE  ".$table."_tipo (
					  id_doct serial NOT NULL,
  						doct_nome char(50),
  						doct_codigo char(5),
  						doct_publico integer,
  						doct_avaliador integer,
  						doct_autor integer,
  						doct_restrito integer,
  						doct_ativo integer
						) ";
				$rlt = db_query($sql);						
			}		
	}
