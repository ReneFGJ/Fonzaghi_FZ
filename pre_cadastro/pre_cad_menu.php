<?
require('../_class/_class_progress.php');
$pg = new progress;
$pg->agl = $_SESSION['angulo'];
require('../_class/_class_acp.php');
//echo '--------------<pre>';
//print_r($_SESSION);
//echo '---------------</pre>';




//echo date("Ymd H:i:s");
//echo '<BR>------->'.$dd[92];
?>

<div id="corpo">     
 		 <div id="head">
 		 	<table  id="consult" class="txtconsult">
 		 		<tr><td class="radial_position"><?=$pg->radial();?></td><td class="radial_name"> MARIA DA SILVA FERREIRA FONZAGHI</td></tr>
 		 		
 		 	</table> 
        </div>   
        <a class="linha"></a> 	
        <div id="div1_new" class="textmenu_new bg1 " style="display:none;" > DADOS PESSOAIS <a class="circle1"></a></div>
    	<div id="div2_new" class="textmenu_new bg2" style="display:none;"> ENDEREÇO <a class="circle1"></a></div>
        <div id="div3_new" class="textmenu_new bg3" style="display:none;"> ESTADO CIVIL <a class="circle1"></a></div>
        <div id="div4_new" class="textmenu_new bg4" style="display:none;"> PROFISSIONAL <a class="circle1"></a></div>
        <div id="div5_new" class="textmenu_new bg5" style="display:none;"> REFERÊNCIAS <a class="circle1"></a></div>
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

$( "#div1_new" ).click(function() { save('1'); });
$( "#div2_new" ).click(function() { save('2'); });
$( "#div3_new" ).click(function() { save('3'); });
$( "#div4_new" ).click(function() { save('4'); });
$( "#div5_new" ).click(function() { save('5'); });

function save(page)
	{
		var str_to_append = '<input type="hidden" name="acao" id="acao" value="save"><input type="hidden" name="dd92" id="dd92" value="'+page+'">';
		$("#formulario").append(str_to_append)
		$( "#formulario" ).submit();		
	}
	

</script>

