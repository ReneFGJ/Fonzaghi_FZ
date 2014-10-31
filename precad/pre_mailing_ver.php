<?php
require("cab.php");
//require($include."sisdoc_debug.php");
require($include.'sisdoc_tips.php');
require($include.'sisdoc_data.php');
require($include."sisdoc_colunas.php");

require("../_class/_class_consultora.php");
require("../_class/_class_consignado.php");
require("../_class/_class_duplicatas.php");
require("../_class/_class_telefone.php");
require("../_class/_class_cadastro_pre_mailing.php");

$include_db = '../../_db/';
$mail = new cadastro_pre_mailing;
$mail->include_class = $include_db;

$cons = new consultora;
$cons->include_class = $include_db;

$consignado = new consignado;
$consignado->include_class = $include_db;

$duplicata = new duplicatas;
$duplicata->include_class = $include_db;

$telefone = new telefone;
$telefone->include_class = $include_db;

$tab_max='100%';

$cliente = $dd[0];

$cons->le($cliente);
$cons->le_endereco($cliente);

$telefone->tel_cliente=$cliente;
$rsp = $telefone->telefones_busca_por_cliente();

$duplicata->db_cliente = $cliente;

$consignado->cliente = $cliente;
$consignado->pecas_quantidades();
$consignado->nome = $cons->nome;




echo $mail->menu_mailing();
echo '<table>';
echo '<tr><td align="center" colspan="3">'.$cons->codigo.' - '.$cons->nome.' - '.$cons->cpf.'</td></tr>';
echo '<tr><td  align="center" width="20%"><img src="'.$cons->foto().'" width="200"  alt="" border="0"></td>';
echo '<td align="center" width="40%">'.$cons->mostra_endereco().'</td>';
echo '<td align="center" width="40%">'.$cons->le_telefones($cliente,0).'</td>';
echo '<td align="center" width="40%">'.$telefone->mostra_telefone($rsp,0).'</td>';
echo '</tr></table>';

require($include_db."db_206_telemarket.php");
$tabela = "pre_cadastro";
$sql = "select * from ".$tabela." where pc_codigo = '".$dd[0]."' ";
$rlt = db_query($sql);
if ($line = db_read($rlt))
	{
	$idc = $line['id_pc'];
	$indicado = 'PRé-Cadastro';
	$status = $line['pc_status'];
	$sta = $line['pc_status'];
	$stax = $line['pc_status'];
	$cep = $line['pc_cep'];
	$cmt = $line['pc_analise'];
	$cpf = trim($line['pc_cpf']);
	$nome = UpperCaseSql(trim($line['pc_nome']));
	$pai = UpperCaseSql(trim($line['pc_pai']));
	$mae = UpperCaseSql(trim($line['pc_mae']));
	$nasc = trim($line['pc_dt_nasc']);
	$rg = trim($line['pc_rg']);
	$prop1 = trim($line['pc_propaganda_1']);
	$prop2 = trim($line['pc_propaganda_2']);
	
	if ($cep > 1) { $cep = substr($cep,0,2).'.'.substr($cep,2,3).'-'.substr($cep,5,3); }
	else { $cep = '<font color="#FF0000">sem CEP</font>'; }
	if ($sta == '@') { $sta = '<font color="#FF8000">Em Edição</font>'; }
	if ($sta == 'K') { $sta = '<font color="#FF8000">Aprovado no sistema</font>'; }
	if ($sta == 'E') { $sta = '<font color="#3333ff">Em Análise</font>'; }
	if ($sta == 'N') { $sta = '<font color="#ff0000">Não aprovado</font>'; }
	if ($sta == 'H') { $sta = '<font color="#FF8000">Revendedora autorizada</font>'; }
	$nome = trim($line['pc_nome']);
	if (substr($nome,0,5) == 'DOCTO') { $cp3 = '<A HREF="#" onclick="newxy2('.chr(39).'pg_consulta_ref_nome.php?dd0='.$idc.chr(39).',900,600);"><img src="img/icone_editar.gif" width="20" height="19" alt="" border="0"></A>';  }
	if (substr($nome,0,6) == '{nome}') { $cp3 = '<A HREF="#" onclick="newxy2('.chr(39).'pg_consulta_ref_nome.php?dd0='.$idc.chr(39).',900,600);"><img src="img/icone_editar.gif" width="20" height="19" alt="" border="0"></A>';  }
	if (substr($nome,0,6) == 'NOME I') { $cp3 = '<A HREF="#" onclick="newxy2('.chr(39).'pg_consulta_ref_nome.php?dd0='.$idc.chr(39).',900,600);"><img src="img/icone_editar.gif" width="20" height="19" alt="" border="0"></A>';  }

	if (strlen(trim($nome)) == 0) { $cp3 = '<A HREF="#" onclick="newxy2('.chr(39).'pg_consulta_ref_nome.php?dd0='.$idc.chr(39).',900,600);"><img src="img/icone_editar.gif" width="20" height="19" alt="" border="0"></A>';  }
	$link_cep = '';
	//if (($status == '@') or ($status == 'E'))
	//	{ 
		$link_cep = '<A HREF="#" onclick="newxy2('.chr(39).'/fonzaghi/tele2/pg_consulta_cep.php?dd1='.$dd[0].chr(39).',900,600);">'; 
		$link_cp1 = '<A HREF="#" onclick="newxy2('.chr(39).'/fonzaghi/tele2/pg_consulta_ref_dados.php?dd0='.$idc.chr(39).',900,600);"><img src="img/icone_editar.gif" width="20" height="19" alt="" border="0"></A>'; 
		$link_cp2 = '<A HREF="#" onclick="newxy2('.chr(39).'/fonzaghi/tele2/pg_consulta_ref_dados_2.php?dd0='.$idc.chr(39).',900,600);"><img src="img/icone_editar.gif" width="20" height="19" alt="" border="0"></A>'; 
	//	}
	?>-------------------------
	<table  width="<?=$tab_max;?>" cellpadding="0" cellspacing="0" border="1" align="center"><TR><TD>
	<table width="100%" class="lt0" align="center" border=0>
	<TR valign="top">
		<TD class="lt0" colspan="4"><?=$cp3;?><B><?=$nome;?></A></B> (<?=$line['pc_codigo'];?>)</TD><TD width="1%"><?=$link_cp1;?></TD></TR>
	<TR class="lt0">
		<TD>CPF:</TD>
		<TD>Cadastrado em:</TD>
		<TD>Status:</TD>
		<TD>Atendido por:</TD>
	<TR>
		<TD class="lt0" ><B><?=$line['pc_cpf'];?></TD>
		<TD><?=stodbr($line['pc_data_cadastro']);?> <?=$line['pc_hora_cadastro'];?></TD>
		<TD><B><?=$sta;?></TD>
		<TD><B><?=$line['pc_log'];?></TD>
	<TR class="lt0">
		<TD>RG:</TD>
		<TD>Dt Nascimento:</TD>
		<TD>Naturalidade</TD>
		<TD>Cidade</TD>
	<TR>
		<TD><B><?=$line['pc_rg'];?></TD>
		<TD><B><?=stodbr($line['pc_dt_nasc']);?></TD>
		<TD><B><?=$line['pc_naturalidade'];?></TD>
		<TD><B><?=$line['pc_cidade'];?> - <?=$line['pc_estado'];?></TD>		

	<TR class="lt0">
		<TD>CEP:</TD>
		<TD>Cidade / Bairro:</TD>
		<TD colspan="2">Endereço:</TD>
	<TR>
		<TD><B><?=$link_cep.$cep;?></TD>
		<TD><B><?=$line['pc_cidade'];?> / <?=$line['pc_bairro'];?></TD>
		<TD colspan="2"><B><?=$line['pc_endereco'];?></TD>

	<TR class="lt0">
		<TD colspan="2">Nome do Pai</TD>
		<TD colspan="2">Nome da Mãe</TD>
	<TR>
		<TD colspan="2"><B><?=$line['pc_pai'];?>&nbsp;</TD>
		<TD colspan="2"><B><?=$line['pc_mae'];?>&nbsp;</TD>

	<TR class="lt0">
		<TD colspan="2">Propaganda</TD>
		<TD colspan="2">Propaganda</TD>
	<TR>
		<TD colspan="2"><B><?=$line['pc_propaganda_1'];?>&nbsp;</TD>
		<TD colspan="2"><B><?=$line['pc_propaganda_2'];?>&nbsp;</TD>

	<TR class="lt0">
		<TD colspan="4">e-mail</TD>
	<TR>
		<TD colspan="4"><B><?=$line['pc_email'];?>&nbsp;</TD>

	</table>
	</TD></TR>
	</table>
<?
	}

	$stx = $line['pc_resi_propria'];
if ($stx == 'N') { $stx = 'Não (é alugada)'; }
if ($stx == 'S') { $stx = 'SIM, Própria'; }
?>
<table  width="<?=$tab_max;?>" cellpadding="0" cellspacing="0" border="1" align="center"><TR><TD>
	<table width="100%" class="lt2" align="center" border=0 >
	<TR>
		<TD width="25%">Residência própria</TD>
		<TD width="25%">Valor aluguel</TD>
		<TD width="50%">Observação</TD>
	</TR>
	<TR class="lt2">
		<TD ><B><?=$stx;?></TD>
		<TD><B><?=number_format($line['pc_vlr_aluguel'],2);?></TD>
		<TD  colspan="2" ><B><?=($line['pc_casa_obs']);?></TD>
		<TD width="1%"><?=$link_cp2;?>
	</table>
</table>
<table  width="<?=$tab_max;?>" cellpadding="0" cellspacing="0" border="1" align="center"><TR><TD>
	<table width="100%" class="lt2" align="center" border=0>
	<TR>
		<TD>Telefone :<B><?=$line['pc_fone_cliente'];?></TD>
		<TD>Telefone (celular/recado) :<B><?=$line['pc_fone1'];?> / <?=$line['pc_fone2'];?></TD>
		<TD>Telefone (trabalho) :<B><?=$line['pc_empresa_fone'];?></TD>
		<TD>Telefone (marido) :<B><?=$line['pc_fone_conjuge'];?></TD>
	</TR>
	
	<TR>
		<TD colspan="2">Empresa onde trabalha</TD>
		<TD colspan="2">Endereço</TD>
	<TR class="lt2">
		<TD colspan=2 ><B><?=$line['pc_empresa_trabalha'];?>&nbsp;</TD>
		<TD colspan=2 ><B><?=$line['pc_empresa_endereco'];?></TD>
	<TR>
		<TD colspan="1">Função</TD>
		<TD colspan="1">Salário</TD>
		<TD colspan="2">Observação</TD>
	<TR class="lt2">
		<TD colspan=1 ><B><?=$line['pc_funcao'];?>&nbsp;</TD>
		<TD colspan=1 ><B><?=number_format($line['pc_salario'],2);?></TD>
		<TD colspan=2 ><B><?=$line['pc_obs'];?></TD>


	</table>
</table>
<table  width="<?=$tab_max;?>" cellpadding="0" cellspacing="0" border="1" align="center"><TR><TD>
	<table width="100%" class="lt2" align="center" border=0 >
	<TR>
		<TD >Estado Cíveil  :<B><?=$line['pc_estado_civil'];?></B></TD>
		<TD >Nome do marido :<B><?=$line['pc_nome_conj'];?></B></TD>
		<TD >Data nasc      :<B><?=stodbr($line['pc_dt_nasc_conj']);?></B></TD>
	</TR>
		<TD colspan="2" width="50%">Empresa (marido)   :<B><?=$line['pc_empresa_trabalha_conj'];?></TD>
		<TD colspan="2" width="50%">Endereço           :<B><?=$line['pc_empresa_endereco_conj'];?></TD>
	<TR>
		<TD colspan="1">Função    :<B><?=$line['pc_funcao_conj'];?></TD>
		<TD colspan="1">Salário   :<B><?=number_format($line['pc_salario_conj'],2);?></TD>
		<TD colspan="2">Telefones :<B><?=$line['pc_fone_conjuge'];?> / <?=$line['pc_empresa_fone_conj'];?></TD>
		</table>
</table>
<table  width="<?=$tab_max;?>" cellpadding="0" cellspacing="0" border="1" align="center"><TR><TD>
	<table width="100%" class="lt2" align="center" border=0>
	<TR><TH>Nr.</TH><TH>Nome</TH><TH>Telefone</TH><TH>Status</TH><TH width="10%">Análise</TH><TH>Atualizado</TH><TH>Obs</TH></TR>
	<?
	$sql = "select * from contatos_referencia ";
	$sql .= " inner join ref_status on rs_codigo = cr_ativo ";
	$sql .= " where cr_pc_codigo = '".$dd[0]."' ";
	$rlt = db_query($sql);
	$id = 0;
	while ($line = db_read($rlt))
		{ 
		$id++;
		$sta = '<font color="'.$line['rs_cor'].'">'.$line['rs_descricao'];
		$data = $line['cr_data'];
		if (strlen($data) == 0) { $data = date("Ymd"); }
		$analise  = $line['cr_analise_data'];
		if ($analise > 19000101) 
			{ $analise = stodbr($analise).' / '.$line['cr_analise_log']; }
		
	if ($status == 'E')	
		{ $link_a = '<A HREF="#" onclick="newxy2('.chr(39).'pg_consulta_ref.php?dd0='.$line['id_cr'].chr(39).',800,500);">'; }
	if ($status == '@') 
		{ 	
			$link_a = '';
			$link_cp3 = '<A HREF="#" onclick="newxy2('.chr(39).'pg_consulta_ref_novo.php?dd0='.$line['id_cr'].chr(39).',900,600);"><img src="img/icone_editar.gif" width="20" height="19" alt="" border="0"></A>'; 
			
		}

		?>
	<TR valign="top" <?=coluna();?>>
		<TD width="1%"><B><NOBR><?=$id;?>.</TD>
		<TD width="30%"><B><?=trim($line['cr_nome']).'</B> ('.trim($line['cr_parentesco']);?>)</TD>
		<TD align="center"><B><?=$line['cr_fone'];?></TD>
		<TD align="center"><?=stodbr($data);?></TD>
		<TD align="center"><?=$link_a.$sta.'</a>';?></TD>
		<TD align="center"><?=$analise;?></TD>
		<TD width="30%"><?=$line['cr_obs'];?></TD>
		<TD width="1%"><?=$link_cp3;?>
		<? } ?>
</table>
<?
$link_n = 'newxy2('.chr(39).'pg_consulta_ref_novo.php?dd1='.$dd[0].chr(39).',800,500);';
if ($status == '@') { ?><TR><TD><input type="button" name="id" value="nova referência" onclick="<?=$link_n;?>"></TD></TR><? } ?>
</table>
<?


//require('../tele2/main_pg_391z.php');
echo $consignado->pecas_retiradas();
echo $duplicata->tabelas();
?>
