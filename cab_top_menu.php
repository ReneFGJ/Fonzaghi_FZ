<?php
echo '
<div id="logo_pucpr"></div>
<ul id="gn-menu" class="gn-menu-main"> 
				<li class="gn-trigger">
					<a class="gn-icon gn-icon-menu"></a>
					<nav class="gn-menu-wrapper">
						<div class="gn-scroller"> 
							<ul class="gn-menu">
								<li> <a href="'.$http.'index.php"><i class="fa fa-home"></i> Início</a></li>								
								<li> <a href="'.$http.'precad/"><i class="fa fa-comment"></i> Telemarketing</a></li>
								<li> <a href="'.$http.'venda_funcionario/"><i class="fa fa-users"></i> Venda Funcionário</a></li>
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
echo '<li><span>';
echo $user->mosta_dados_mini();
echo '</span></li>';
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