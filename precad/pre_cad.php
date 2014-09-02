<?php
require ('cab.php');
$editar = 1;
require ($include . 'sisdoc_data.php');

require ("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

require ('../../_include/_class_form.php');
$form = new form;
echo '<link rel="stylesheet" href="' . $include . 'css/calender_data.css" type="text/css" media="screen" />' . chr(13) . chr(10);
$form -> required_message = 0;
$form -> required_message_post = 0;
$form -> class_string = 'precad_form_string';
$form -> class_button_submit = 'precad_form_submit';
$form -> class_form_standard = 'precad_form';
$form -> class_textbox = 'precad_form_string';
$form -> class_memo = 'precad_form';
$form -> class_select = 'precad_select';

/*lastupdate/lastlog*/
$_SESSION['angulo'] = 0;

$dd[0] = $_SESSION['PG1_DD0'];
if (strlen($dd[0]) == 0) {
	redirecina("index.php");
}

$pre -> le($dd[0]);
echo $pre -> mostra_nome();

echo '<table border=0 class="tabela00" width="100%">';
echo '<TR valign="top"><TD width="200">';

$link = array();
array_push($link, array('Dados pessoais', '<A HREF="'.page().'?dd80=1">'));
array_push($link, array('Dados profissionais', '<A HREF="'.page().'?dd80=2">'));
array_push($link, array('Endereço', '<A HREF="'.page().'?dd80=3">'));
array_push($link, array('Telefone', '<A HREF="'.page().'?dd80=4">'));
array_push($link, array('Referências', '<A HREF="'.page().'?dd80=5">'));
array_push($link, array('Resumo', '<A HREF="'.page().'?dd80=6">'));

/* Menu de items */
echo '<div class="menu_simple"><UL>';
for ($r = 0; $r < count($link); $r++)
	echo '<LI>' . $link[$r][1] . $link[$r][0] . '</A></LI>';
echo '</UL></div>';
echo $dd[0];
$ps = round('0' . $_SESSION['page']);
if ($ps < 1) { $ps = '1';
}
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
	case '6':
		$cp = $pre -> cp_06();
		echo $pre->mostra();
		echo '<h3>Contatos Pessoal</h3>';
		echo $pre->lista_telefone(0);

		echo '<h3>Endereço</h3>';
		echo $pre->lista_endereco(0);

		echo '<h3>Referências</h3>';
		echo $pre->lista_referencia(0);		
	}

if (count($cp) > 0) {
	$tela = $form -> editar($cp, $tabela);

	if ($form -> saved > 0) {
		echo 'PAGE-->' . $dd[1];
		$_SESSION['page'] = ($ps + 1);
		redirecina(page());

	} else {
		echo $tela;
	}
}
echo '</table>';
?>