<?
require('../_class/_class_progress.php');
$pg = new progress;
$pg->agl = $_SESSION['angulo'];
require('../_class/_class_acp.php');
echo $_SESSION['pre_aba_aberta'];
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
        <div id="div3_new" class="textmenu_new bg3" > RESUMO <a id="cl3"  class="circle3"></a></div>
        <div> <input type="submit" class="precad_form_submit" value="Enviar" > </div> 
        </td> <td class="linha">
</div> </td> </tr> </table>
<div id="pre_ajax"></div>
<script>

$( "#div1_new" ).click(function(){ save('1'); });
$( "#div2_new" ).click(function(){ save('2'); });
$( "#div3_new" ).click(function(){ save('3'); });

function save(page)
	{
		$("#formulario").submit();
	}
</script>


