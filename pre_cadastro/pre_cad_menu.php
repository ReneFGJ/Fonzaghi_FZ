<?
require('../_class/_class_progress.php');
$pg = new progress;
$pg->agl = $_SESSION['angulo'];
require('../_class/_class_acp.php');



?>
<div id="corpo"> 
<table> <tr> <td> 
    
 		 <div id="head">
 		 	<table  id="consult" class="txtconsult">
 		 		<tr>
 		 			<td class="radial_position"><?=$pg->radial();?></td>
 		 			<td class="radial_name"><?=$_SESSION['nome'];?></td>
 		 		</tr>
 		 		
 		 	</table> 
        </div>    
        <div id="div1_new" class="textmenu_new bg1" > DADOS PESSOAIS <a id="cl1" class="circle1"></a></div>
    	<div id="div2_new" class="textmenu_new bg2" > COMPLEMENTO <a id="cl2"  class="circle2"></a></div>
        <div id="div3_new" class="textmenu_new bg3" > REFERÊNCIAS <a id="cl3"  class="circle3"></a></div>
        <div id="div4_new" class="textmenu_new bg4" > MENU 4 <a id="cl4"  class="circle4"></a></div>
        <div id="div5_new" class="textmenu_new bg5" > MENU 5 <a id="cl5"  class="circle5"></a></div>
        <div> <input type="submit" class="precad_form_submit" value="Enviar" > </div> 
        </td> <td class="linha">
</div> </td> </tr> </table>

<script>

$( "#div1_new" ).click(function(){ save('1'); });
$( "#div2_new" ).click(function(){ save('2'); });
$( "#div3_new" ).click(function(){ save('3'); });
$( "#div4_new" ).click(function(){ save('4'); });
$( "#div5_new" ).click(function(){ save('5'); });

function save(page)
	{
		var str_to_append = '<input type="hidden" name="acao" id="acao" value="save"><input type="hidden" name="dd92" id="dd92" value="'+page+'">';
		$("#formulario").append(str_to_append);
		$("#formulario").submit();
	}
</script>

