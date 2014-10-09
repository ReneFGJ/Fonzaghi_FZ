<?
require("../cab.php");
require($include.'_class_form.php');
$form = new form;
?>
<h1>Venda para Funcionário</h1>

<Table width="100%" class="tabela00">
	<TR valign="top">
		<TD width="33%" class="border1 radius5 pad5" >
			<h2>Identificação</h2>
			<div id="funcionario_login_main" style="min-height: 350px;">
			<?php echo $form->ajax('funcionario_login',''); ?>
			</div>
		</TD>
		<TD>&nbsp;</TD>
		<TD width="33%" class="border1 radius5 pad5">
			<h2>Produtos</h2>
			<div id="produtos_venda_main" style="display: none;">
			</div>
		</TD>
		<TD>&nbsp;</TD>
		<TD width="33%" class="border1 radius5 pad5">
			<h2>Resumo</h2>
			<div id="venda_resumo_main" style="display: none;">
			</div>
		</TD>
	</TR>
	
</Table>