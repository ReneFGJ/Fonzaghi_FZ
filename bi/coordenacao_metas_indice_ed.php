<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require('../cab_novo.php');
$user->le($_SESSION['nw_cracha']); 
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'_class_form.php');
$form = new form;
require('../db_bi.php');
require('../_class/_class_metas.php');
$met = new metas;
$cp = $met->cp_metas_indice();


if (strlen(trim(round($dd[0])))==0)
{
    $dd[2]=date(m);
    $dd[3]=date(Y);
}
$dd[10]=$_SESSION['nw_user'];
$dd[5]=str_replace(',','.',$dd[5]);
$dd[11]=date('Ymd');

$tela = $form->editar($cp,'metas_indice');

$tabela='metas_indice';
$editar = True;
$http_redirect = 'coordenacao_metas_indice.php';
$met->row_metas_indice();
$busca = true;
$offset = 20;
$http_edit = 'coordenacao_metas_indice_ed.php'; 

$tab_max = "100%";
echo '<h1>Cadastro metas</h1>';
    if ($form->saved  > 0)
    {
        redirecina("coordenacao_metas_indice.php");
    }else{
        echo utf8_decode($tela);
    }
   
   
/* Rodape */
echo $hd->foot();
?>