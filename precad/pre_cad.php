<?php
require ('cab.php');
$editar = 1;
require ($include . 'sisdoc_data.php');
require ($include . 'sisdoc_debug.php');
require ("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

/* Insere PG1_DD) */
if (strlen($dd[0]) == 7)
	{
		$_SESSION['PG1_DD0'] = $dd[0];
	}

require ('../../_include/_class_form.php');
$form = new form;
echo '<link rel="stylesheet" href="' . $include . 'css/calender_data.css" type="text/css" media="screen" />' . chr(13) . chr(10);
$form -> required_message = 0;
$form -> required_message_post = 0;
$form -> class_string = 'fz_precad_form_string';
$form -> class_button_submit = 'fz_precad_form_submit';
$form -> class_form_standard = 'fz_precad_form';
$form -> class_textbox = 'fz_precad_form_string';
$form -> class_memo = 'fz_precad_form';
$form -> class_select = 'fz_precad_select';

/*lastupdate/lastlog*/
$_SESSION['angulo'] = 0;

$dd[0] = $_SESSION['PG1_DD0'];
if (strlen($dd[0]) == 0) {
	redirecina("index.php");
}

$pre -> le($dd[0]);
echo $pre -> mostra_nome('form_nome');

echo '<table border=0 class="tabela00" width="100%">';
echo '<TR valign="top"><TD width="200">';

$link = array();
array_push($link, array('Dados pessoais', '<A HREF="'.page().'?dd80=1">'));
array_push($link, array('Dados profissionais', '<A HREF="'.page().'?dd80=2">'));
array_push($link, array('Telefone', '<A HREF="'.page().'?dd80=3">'));
array_push($link, array('Endereço', '<A HREF="'.page().'?dd80=4">'));
array_push($link, array('Referências', '<A HREF="'.page().'?dd80=5">'));
array_push($link, array('Observações', '<A HREF="'.page().'?dd80=6">'));
array_push($link, array('Resumo', '<A HREF="'.page().'?dd80=7">'));


/* Menu */
echo '
<link rel="STYLESHEET" type="text/css" href="../css/style_pre_cad_menus.css">
<div class="navbox">
	<ul class="nav">
';
	for ($r = 0; $r < count($link); $r++){
			echo '<LI>' . $link[$r][1] . $link[$r][0] . '</A></LI>';
		}
echo '</ul></div>';

echo $dd[0];
/* Página */
if (strlen($dd[80]) > 0)
	{
		$_SESSION['page'] = $dd[80];
		redireciona(page());
		exit;		
	}

$ps = round('0' . $_SESSION['page']);
$_SESSION['page'] = $ps;

if ($ps < 1) { $ps = '1';}
if (strlen($dd[80]) > 0) { $ps = $dd[80]; }

echo '<TD>';
/* Dados CP01 */
switch ($ps) {
	case '1' :
		$cp = $pre -> cp_01();
		$tabela = $pre -> tabela;
		break;
	case '2' :
		$cp = $pre -> cp_02();
		$tabela = $pre -> tabela_complemento;
		break;
	case '3' :
		$cp = $pre -> cp_03();
		echo '<h3>Contatos Pessoal</h3>';
		echo $pre->lista_telefone(1);
		break;
	case '4' :
		$cp = $pre -> cp_04();
		echo '<h3>Endereço</h3>';
		echo $pre->lista_endereco(1);
		
		break;
	case '5' :
		$cp = $pre -> cp_05();
		echo '<h3>Referências</h3>';
		echo $pre->lista_referencia(1);
		break;
		
	case '6' :
		$cp = $pre -> cp_06();
		$tabela = $pre -> tabela_complemento;
		echo '<h3>Observações</h3>';
		break;	
			
	case '7':
		$cp = $pre -> cp_07();
		echo $pre->mostra();
		echo '<h3>Complemento</h3>';
		echo $pre->mostra_complemento();
		echo '<h3>Contatos Pessoal</h3>';
		echo $pre->lista_telefone(0);

		echo '<h3>Endereço</h3>';
		echo $pre->lista_endereco(0);

		echo '<h3>Referências</h3>';
		echo $pre->lista_referencia(0);
		break;
	case '8':
		redirecina('pre_cliente_ver.php?dd0='.$dd[0]);
		break;	
			
	}

if (count($cp) > 0) {
	$tela = $form -> editar($cp, $tabela);
	if ($form -> saved > 0) {
		$_SESSION['page'] = ($ps + 1);
		redirecina(page());
	} else {
		echo $tela;
	}
}
echo '</table>';
?>