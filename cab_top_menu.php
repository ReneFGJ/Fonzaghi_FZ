<?
$menui = array();
switch ($LANG)
	{
	case 'en':
		break;
	default:
		array_push($menui,'Menu Principal');
		break;
	}
echo '
<div id="logo_pucpr"></div>
<nav id="menu">
	<div id="hamburger-helper">
		<div>
			<div id="ham1" class="barra"></div>
			<div id="ham2" class="barra"></div>
			<div id="ham3" class="barra"></div>
		</div>
	</div>
	<ul>
		<li>
			&nbsp;
		</li>
		<li>
			<a href="/fz/main.php" class="menu_top">INICIAL</a>
		</li>';
		
for ($r=0;$r < count($top_cab); $r++)
	{
		echo '
		<li>
			<a href="'.$top_cab[$r][1].'" class="menu_top">'.$top_cab[$r][0].'</a>
		</li>					
		';
	}

echo '	
	</ul>
	<div id="menus" class="menu_left menu_lateral">
	    	<div class="mobile-menu">
	    		<UL>
	    		<LI><a href="/fz/main.php" class="y-out">Menu Principal</a></LI>
	    		<LI><a href="/fz/precad/analise_consulta.php" class="y-out">Analise de cadastros</a></LI>

	    		</UL>
	    	</div>
	</div>	
</nav>
';
echo '<BR><BR>';
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