<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/index_ocorrencias.php','Formulário de ocorrências'));
array_push($breadcrumbs, array('/fonzaghi/ger/ocorrencias_formulario.php','Cadastrar nova ocorrência'));

$include = '../';
require("../cab.php");
require($include."sisdoc_windows.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."cp2_gravar.php");
require("../db_fghi2.php");

$dr='ocorrencias_formulario.php?dd0=';
$tabela='ocorrencias_formulario';
$dd[99]=$tabela;

$cp=array();
array_push($cp,array('$H8','id_of','',True,True,''));
array_push($cp,array('$H7','of_codigo','',True,True,''));
array_push($cp,array('$T50:5','of_descricao','Descrição do problema',True,True,''));
array_push($cp,array('$HV','of_log_solicitante',$user_log,True,True,''));
array_push($cp,array('$HV','of_data', date('Ymd'),True,True,''));
array_push($cp,array('$HV','of_hora',date('H:i'),True,True,''));
array_push($cp,array('$Q ot_nome:ot_log:select ot_log, (ot_nome ||\' ( \'|| ot_area_atendimento ||\' ) \') as ot_nome from ocorrencias_ti where ot_ativo = \'1\' order by ot_nome','of_enviar_para','Enviar para',False,True,''));

$dd[1] = '1'; //Para salvar no banco de dados

echo '<CENTER><font class="lt5">Cadastrar nova ocorrência</font></CENTER>';
echo '<TABLE border="0" align="center" width="'.$tab_max.'">';
echo '<TR><TD>';
editar();
echo '</TD></TR>';
echo '</TABLE>';	

if ($saved > 0){
	$sql = "update ocorrencias_formulario set of_codigo=trim(to_char(id_of,'".strzero(0,7)."')) where (length(trim(of_codigo)) < 7) or (of_codigo isnull);";
	db_query($sql);
	
	$sql="INSERT INTO lista_atividades(
            la_data, la_hora, 
			la_de, la_para, 
			la_perfil, la_cod_atendimento, 
            la_titulo, la_descricao, 
			la_status)
		    VALUES (".date('Ymd').", '".date('H:i')."',
			'".$user_log."', '".$dd[6]."',
			0, 'MSG',
			'Formulário de ocorrências','".$dd[2]."',
			'A');";
	db_query($sql);

	?><script>
	alert("Registro de ocorrência salvo com sucesso!");
	window.location="index_ocorrencias.php";
	</script><?
}

require($vinclude."foot.php");	
?>