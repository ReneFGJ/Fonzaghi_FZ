<?
require("../cab.php");
require($include.'_class_form.php');
$form = new form;
?>
<h1>Venda para Funcionário</h1>

<Table width="100%" class="tabela00">
	<TR valign="top">
		<TD width="50%" class="border1 radius5 pad5" >
			<h2>Identificação</h2>
			<div id="funcionario_login_main" style="min-height: 200px;">
			<?php echo $form->ajax('funcionario_login',''); ?>
			</div>
			<div id="venda_resumo_main" style="min-height: 150px;">
			</div>			
		</TD>
		<TD>&nbsp;</TD>
		<TD width="50%" class="border1 radius5 pad5">
			<h2>Produtos</h2>
			<div id="produtos_venda_main">
				Não identificado
			</div>
		</TD>
	</TR>
	
</Table>
<div id="status"></div>

