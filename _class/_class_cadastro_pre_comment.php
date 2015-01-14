<?php
    /**
     * Ethics Comment
	 * @author Rene Faustino Gabriel Junior <renefgj@gmail.com> (Analista-Desenvolvedor)
	 * @copyright Copyright (c) 2011 - sisDOC.com.br
	 * @access public
     * @version v0.11.29
	 * @package Class
	 * @subpackage cep_comment
    */
class cad_comment
	{
		var $protocol;
		var $version;
		var $codigo;
		var $user;
		var $user_login;
		var $comment;
		var $avaliation;
		var $tabela = 'cep_comment';
				
		function comment_save()
			{
				global $user,$ss;
				
				$comment = $this->comment;
				$codigo = $this->codigo;
				$data = date("Ymd");
				$hora = date("H:i:s");
				$aval = $this->avaliation;
				$user = $this->user_login;

				$sql = "select * from ".$this->tabela;
				$sql .= " where cepc_codigo='$codigo' and 
					cepc_user='$user' and cepc_comment = '$comment' ";
					
				$rlt = db_query($sql);
				if (!($line = db_read($rlt)))
					{
					$sql = "insert into ".$this->tabela." 
						(cepc_codigo,cepc_user,cepc_comment,
						cepc_data, cepc_hora, cepc_avaliation )
						values
						('$codigo','$user','$comment'
						,$data,'$hora','$aval')";
					$rlt = db_query($sql);
					}
				
				return(1);
			}
		
		function comment_form()
			{
				global $dd,$ss;
				$us = $this->user_login;
				
				$sx = ''; $sxf = '';
				if ((strlen($dd[1]) > 0))
					{
						if  (strlen($dd[2])== 0)
							{
								//$sxf = '<script>'.chr(13);
								//$sxf .=  " alert('".msg('need_comment_type')."');";
								//$sxf .=  '</script>'.chr(13);
							} else {
								$this->comment = $dd[1];
								$this->avaliation = $dd[2];
								$this->user = $us;
								$this->comment_save();
								$dd[1]='';
								$dd[2]='';
								
								redirecina(page().'?dd0='.$dd[0].'&dd90='.$dd[90]);
							}
					  
					}
				
				$disp1 = 'display: none;';
				$disp2 = 'display: block;';
				if (strlen($dd[1]) > 0)
					{
						$disp2 = 'display: none;';
						$disp1 = 'display: block;';						  
					}
					
				$sx .= '<div id="posted" style="'.$disp1.'">';
				$sx .= '<form method="post" action="'.page().'">';
				$sx .= '<input type="hidden" name="dd0" value="'.$dd[0].'">'.chr(13);
				$sx .= '<input type="hidden" name="dd90" value="'.$dd[90].'">'.chr(13);
				
				$sx .= '<table width="98%">';
				$sx .= '<TR><TD>';
				$sx .= msg('Dados do comentário').'<BR>';
				$sx .= '<TR><TD><textarea name="dd1" cols="80" rows="5">';
				$sx .= $dd[1];
				$sx .= '</textarea>';
				$sx .= '<TR><TD>';
				
				/** Avaliation **/
					/* $sx .= msg('comment_type').':';
					
					$chk1 = ''; $chk2 = '';
					if ($dd[2]=='1') { $chk1 = 'checked'; }
					if ($dd[2]=='0') { $chk2 = 'checked'; }
					
					/** Radio **/		
					/** com avaliaï¿½ï¿½o		
					$sx .= '<input type="radio" value="1" name="dd2" '.$chk1.'>';
					$sx .= '<img src="img/icone_coment_ok.png">';
	
					$sx .= '<input type="radio" value="0" name="dd2" '.$chk2.'>';
					$sx .= '<img src="img/icone_coment_nook.png">';
					**/
					
				/** sem avaliacao **/
				$sx .= '<input type="hidden" value="1" name="dd2" >';
				/**  **/
				$sx .= '<BR><input type="submit" value="'.msg('Enviar Comentário').'">';
				$sx .= '</table>';
				$sx .= '</form>';
				$sx .= '</div>';
				/** **/
				$sx .= '<input id="mst" class="submit_comment" type="button" value="'.msg('Adicionar comentário').'" onclick="mostrar();"  style="'.$disp2.'">';
				$sx .= chr(13).'<script>
					      $("#mst").click(function () {
					      		$("#posted").fadeIn("slow"); 
						   		$("#mst").fadeOut("slow"); 
						  }); 
						';				
				$sx .= chr(13).'</script>';
				return($sx.$sxf);
			}
		
		function comment_display()
			{
				$sql = "select * from ".$this->tabela." ";
				//$sql .= " left join usuario on cepc_user = us_codigo ";
				$sql .= " where cepc_codigo = '".$this->codigo."' ";
				$sql .= " order by cepc_data desc, cepc_hora desc ";
				
				$rlt = db_query($sql);
				$totc = 0;
				$sx .= '<h3>Comentários</h3>';
				$sx .= '<table class="bdcomment left radius5 margin5 pad5 border1 orange_light" width="100%" aling="center">';
				$sx .= '<TR  class="bdcomment_hd">';
				$sx .= '<th>Data<th>Login<th>Comentário';
				while ($line = db_read($rlt))
					{
						$totc++;
						$she = trim($line['us_genero']);
						$sx .= '<tr  valign="top" >';
						$sx .= '<td width="10%" align="center" class="radius5 margin5 pad5 border1 orange_light">';
						$sx .= '<font class="lt0">'.stodate($line['cepc_data']).'<br> '.$line['cepc_hora'];
						$sx .= '<td width="10%" align="center" class="radius5 margin5 pad5 border1 orange_light"><B><I>'.$line['cepc_user'].'</B></I>';
						$sx .= '<td width="80%"  class="radius5 margin5 pad5 border1 orange_light"><font class="lt1">';
						$sx .= $line['cepc_comment'];
						$sx .= '<tr><td>';
					}
				$sx .= $this->comment_form();
				$sx .= '</table>';
				return($sx);
			}	
		
		function strucuture()
			{
				$sql = "create table cep_comment
					(
					id_cepc serial NOT NULL,
					cepc_codigo char(7),
					cepc_user char(7),
					cepc_comment text,
					cepc_data int8,
					cepc_hora char(8),
					cepc_avaliation char(1)					
					)";
				$rlt = db_query($sql);
				
			}
	}
?>
