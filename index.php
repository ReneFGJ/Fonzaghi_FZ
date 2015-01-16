<?php
//header('Location: _login.php');
require("cab.php");

echo '<h1>Home</h1>';


//echo '<link rel="stylesheet" type="text/css" href="css/normalize.css" />'.chr(13);
//echo '<link rel="stylesheet" type="text/css" href="css/demo.css" />'.chr(13);
echo '<link rel="stylesheet" type="text/css" href="css/sansung_menu.css" />'.chr(13);

echo '
		<script src="js/modernizr.custom.js"></script>

			<section class="grid-wrap">
				<ul class="grid swipe-right" id="grid">
					<li class="title-box">
						<h2>Telemarketing</h2>
					</li>
					<li><a href="precad/"><img src="img/icone/img_telemarketing.jpg" alt="dummy"><h3>Telemarketing</h3></a></li>
					<li class="title-box">					
						<h2>Fonzaghi - 30 anos</h2>
					</li>
					<li><a href="venda_funcionario/"><img src="img/icone/img_venda_funcionario.jpg" alt="venda funcionario"><h3>Venda Funcionário</h3></a></li>
					<li><a href="venda_funcionario/"><img src="img/icone/img_aniversariantes.jpg" alt="aniversariantes"><h3>Aniversariantes do mês</h3></a></li>
					<li><a href="campanhas/"><img src="img/icone/img_campanhas.jpg" alt="campanhas"><h3>Campanhas Fonzaghi</h3></a></li>
					';
					
	if ($perfil->valid('#MST'))
		{
			echo '<li><a href="juridico/"><img src="img/icone/img_juridico.jpg" alt="Cobrança"><h3>Cobrança & Juridoco</h3></a></li>';
		}
	
   if ($perfil->valid('#MST#DIR#SSS#CCC#CMK'))
    {					
		echo '<li><a href="bi/"><img src="img/icone/img_bi.jpg" alt="campanhas"><h3>Indicadores (BI)</h3></a></li>';
	}
	
echo '		<li class="title-box">					
						<h2>mais de 50.000 consultadas atendidas</h2>
					</li>
				</ul>
			</section>
		</div><!-- /container -->
		<script src="js/masonry.pkgd.min.js"></script>
		<script src="js/imagesloaded.pkgd.min.js"></script>
		<script src="js/classie.js"></script>
		<script src="js/colorfinder-1.1.js"></script>
		<script src="js/gridScrollFx.js"></script>
		<script>
			new GridScrollFx( document.getElementById( \'grid\' ), {
				viewportFactor : 0.4
			} );
		</script>
';
 
?>

