<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/index_ocorrencias.php','Formulário de ocorrências'));
array_push($breadcrumbs, array('/fonzaghi/ger/ed_ocorrencias_formulario.php','Listagem das ocorrencias'));

$include = '../';
require($include."cab.php");
require($include."sisdoc_menus.php");
require($include."sisdoc_windows.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."cp2_gravar.php");
require($include."biblioteca.php");
require($include."letras.css");

require("../db_fghi2.php");

global $tab_max;
$sql = "SELECT id_of, of_codigo, of_descricao, of_log_solicitante, of_data, 
       of_hora, of_enviar_para, of_solucao, of_data_solucao, of_hora_solucao, 
       of_log_solucionou
  FROM ocorrencias_formulario
  where of_codigo='".troca($dd[0],"'","´")."'";
$rlt=db_query($sql);
$line=db_read($rlt);

$sql = "SELECT id_ot, ot_codigo, ot_nome, ot_log, ot_ativo, ot_area_atendimento
		  FROM ocorrencias_ti
		  where ot_log='".$line['of_enviar_para']."';";
$rlt=db_query($sql);
$line2=db_read($rlt);

echo '<table border="0" width="'.$tab_max.'" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">';
echo '<tr><td>';

echo '<table border="0" width="96%" align="center">';
echo '<tr>';
echo '<td colspan="2"><img src="img/logotipo.jpg" width="80" height="50" border="0"></td>';
echo '<tr><td align="center" colspan="2" class="lt4"><b>FORMULÁRIO DE OCORRÊNCIAS</b></td></tr>';
echo '</tr>';
echo '<tr><td class="lt2" colspan="2" height="30" valign="bottom"><b>Problema de: '.$line2['ot_area_atendimento'].'</b></td></tr>';
echo '<tr><td class="lt0" colspan="2" height="30" valign="top">(A/C de '.$line2['ot_nome'].')</td></tr>';

echo '<tr><td>';
echo '<table border="0" class="1_naoLinhaVertical" width="100%" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">';
$largura=200;
echo '<tr>
<th class="legenda" width="'.$largura.'">Descrição:</th><td bgcolor="#F0F0F0" class="1_td"><font color="#ff0000" size="+1">'.$line['of_descricao'].'</font></td>
<tr><th class="legenda" width="'.$largura.'">Log do solicitante:</th><td bgcolor="#F0F0F0" class="1_td">'.$line['of_log_solicitante'].'</td></tr>
<th class="legenda" width="'.$largura.'">Data e hora da ocorrência:</th><td bgcolor="#F0F0F0" class="1_td">'.stodbr($line['of_data']).' às '.$line['of_hora'].'</td>
</tr>';

echo '<tr>
<th class="legenda" width="'.$largura.'">Solução:</th><td bgcolor="#F0F0F0" class="1_td"><font color="#0000ff" size="+1">'.$line['of_solucao'].'</font></td>
<tr><th class="legenda" width="'.$largura.'">Data e hora da solução:</th><td bgcolor="#F0F0F0" class="1_td">'.stodbr($line['of_data_solucao']).' às '.$line['of_hora_solucao'].'</td></tr>
<tr><th class="legenda" width="'.$largura.'">Log de quem resolveu:</th><td bgcolor="#F0F0F0" class="1_td">'.$line['of_log_solucionou'].'</td></tr>
</tr>';
echo '</table>';
echo '</td></tr>';

echo '<tr><td height="30"></td></tr>';

echo '</table>';

echo '</td></tr>';
echo '</table>';

require("../foot.php");	
?>