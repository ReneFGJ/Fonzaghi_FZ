﻿<?php
$include = '../';
require($include.'cab.php');
?>
	<div id="corpo">
       
 		 <div id="head"> 
        	<div id="consult" class="txtconsult"> CONSULTORA<br />
<h3> MARIA DA SILVA FERREIRA FONZAGHI </h3> </div>
        </div>    	
        
    	<div id="div1_new" class="textmenu_new bg1" style="display:none;"> DADOS PESSOAIS </div>
    	<div id="div2_new" class="textmenu_new bg2" style="display:none;"> ENDEREÇO </div>
        <div id="div3_new" class="textmenu_new bg3" style="display:none;"> ESTADO CIVIL </div>
        <div id="div4_new" class="textmenu_new bg4" style="display:none;"> PROFISSIONAL </div>
        <div id="div5_new" class="textmenu_new bg5" style="display:none;"> REFERÊNCIAS </div>
     
        <div id="button" class="btn_enviar"> Enviar</div>
       
    </div>
</body>
</html>

<script>
$(document).ready(function(){

    $("#div1_new").fadeIn();
    $("#div2_new").fadeIn("slow");
    $("#div3_new").fadeIn(1500);
    $("#div4_new").fadeIn(2000);	
    $("#div5_new").fadeIn(2500);	

});
</script>
</head>