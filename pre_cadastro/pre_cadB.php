<?php
require('cab.php');
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require('../_class/_class_acp.php');
require('../_include/_class_form.php');
$form = new form;
$form->required_message = 0;
$form->required_message_post = 0;
$form->class_string = 'precad_form_string';
$form->class_string = 'precad_form_string';
$form->class_button_submit = 'precad_form_submit';
$form->class_form_standard = 'precad_form';
$form->class_memo = 'precad_form';
$id = $dd[0];
echo $hd->cab_banner($pre->gerar_tabela_tela_inicial());
echo '<center><div id="corpo">';
echo '<table>	
				<tr><td>
					<div id="painel1" align="center" width="30%" style="position:relative; float:left">
						<img width="300px" src="../img/imgboxinfo.png">
						<div class="box_cont"></div>
					</div>
				</td><td width="20px"></td>
				<td>
					<div id="painel2"  align="center" width="30%" style="position:relative; float:left">
						<img width="300px" src="../img/imgboxcont.png">
						<div  class="box_cont">'.$pre->listar_contatos().'</div>
					</div>
				</td><td width="20px"></td>
				<td>
					<div  id="painel3" align="center" width="30%" style="position:relative; float:left">
						<img width="300px" src="../img/imgboxcad.png">
						<div  class="box_cont">'.$pre->mostrar_contato($id).'</div>
					</div>
				</td></tr></table>
			';
echo '</div>';
echo '</div>';
?>


 
	

