<?php
echo '
<div id="logo_pucpr"></div>
<ul id="gn-menu" class="gn-menu-main"> 
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller"> 
							<ul class="gn-menu">
								<li> <a href="'.$http.'index.php"><i class="fa fa-home"></i> In�cio</a></li>								
								<li> <a href="'.$http.'precad/"><i class="fa fa-comment"></i> Telemarketing</a></li>
								<li> <a href="'.$http.'venda_funcionario/"><i class="fa fa-users"></i> Venda Funcion�rio</a></li>
								<!--
								<li> <a href="programacao.php"><i class="fa fa-clock-o"></i> Programação</a></li>
								<li> <a href="submissao-de-trabalhos.php"><i class="fa fa-file"></i> Submissão de trabalhos</a></li>
								<li> <a href="comissoes.php"><i class="fa fa-users"></i> Comissão Organizadora</a></li>
								<li> <a href="instituicoesparticipantes.php"><i class="fa fa-university"></i> Instituições Participantes</a></li>
								<li> <a href="mapas.php"><i class="fa fa-map-marker"></i>  Localização e Hospedagem</a></li>
								<li> <a href="materiais-para-divulgacao.php"><i class="fa fa-thumbs-up"></i> Materiais para divulgação</a></li>
								<li> <a href="perguntas-frequentes.php"><i class="fa fa-question-circle"></i> Perguntas Frequentes</a></li>
								<li> <a href="politicas-de-adesao.php"><i class="fa fa-check-square-o"></i> Políticas de Adesão</a></li>
								<li> <a href="sobre-curitiba.php"><i class="fa fa-bus"></i> Sobre Curitiba</a></li><li> <a href="galeria-de-homenageados.php"><i class="fa fa-star"></i> Galeria de Homenageados</a></li>
								<li> <a href="contato.php"><i class="fa fa-envelope"></i></i> Contato</a></li>
								-->
							</ul>
						</div><!-- /gn-scroller -->
					</nav>
				</li> 
';
/* Menu Superior */
if (!(isset($menus)))
	{
		$menus = array();
		array_push($menus,array('/fz/','Tela Principal'));
	}
for ($r=0;$r < count($menus);$r++)
	{
		echo '<li class="submissao-botao"><a href="'.$menus[$r][0].'" class="linka">'.$menus[$r][1].'</a></li>';
	}				
echo '<li><a class="codrops-icon codrops-icon-drop" href=""><span></span></a></li>';
echo '</ul>';
?>

<script>
	$("#hamburger-helper").click(function() {
		$("#ham1").toggleClass('barra_first');
		$("#ham2").toggleClass('barra_middle');
		$("#ham3").toggleClass('barra_last');
		$("#ham3").animate('barra_last');
		$("#menus").animate({
			opacity : 1,
			top : "50",
			height : "toggle"
		}, 500, function() {/* Animation complete. */
		});
	});

</script> 