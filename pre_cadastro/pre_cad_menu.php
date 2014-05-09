<?
require('../_class/_class_progress.php');
$pg = new progress;
$pg->agl = $_SESSION['angulo'];
?>

<div id="corpo">     
 		 <div id="head">
 		 	<table  id="consult" class="txtconsult">
 		 		<tr><td><?=$pg->radial();?></td><td><h3> MARIA DA SILVA FERREIRA FONZAGHI</h3></td></tr>
 		 		<tr><td>CONSULTORA</td><td></td></tr>
 		 	</table> 
        </div>    	
        <div id="div1_new" class="textmenu_new bg1" style="display:none;"> DADOS PESSOAIS </div>
    	<div id="div2_new" class="textmenu_new bg2" style="display:none;"> ENDEREǇO </div>
        <div id="div3_new" class="textmenu_new bg3" style="display:none;"> ESTADO CIVIL </div>
        <div id="div4_new" class="textmenu_new bg4" style="display:none;"> PROFISSIONAL </div>
        <div id="div5_new" class="textmenu_new bg5" style="display:none;"> REFERÊNCIAS </div>
        <div><input type="submit" class="precad_form_submit" value="Enviar"></div>
</div>

<script>
$(document).ready(function(){

    $("#div1_new").fadeIn();
    $("#div2_new").fadeIn("slow");
    $("#div3_new").fadeIn(1500);
    $("#div4_new").fadeIn(2000);	
    $("#div5_new").fadeIn(2500);	

});
</script>

