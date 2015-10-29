<?php
include 'auth.php';
include 'lib.php';

$sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo where NR_SEQ_LOJA_PTRC = 1 and NR_SEQ_CATEGPRO_PTRC";
$sql = $sql . " not in (SELECT NR_SEQ_TIPO_TARC FROM atacado_tipos) order by DS_CATEGORIA_PTRC" ;
$st1 = mysql_query($sql);
$cbMn = "";

while($row1 = mysql_fetch_assoc($st1)) {
  $cbMn = $cbMn . "<option value='" . $row1["NR_SEQ_CATEGPRO_PTRC"] . "'>" . $row1["DS_CATEGORIA_PTRC"] . "</option>";
}

$sql = "SELECT NR_SEQ_TIPO_TARC, DS_CATEGORIA_PTRC ";
$sql = $sql . "FROM atacado_tipos, produtos_tipo WHERE NR_SEQ_TIPO_TARC = NR_SEQ_CATEGPRO_PTRC order by DS_CATEGORIA_PTRC";
$st2 = mysql_query($sql);
$cbPr = "";

while($row2 = mysql_fetch_assoc($st2)) {
  $cbPr = $cbPr . "<option value='" . $row2["NR_SEQ_TIPO_TARC"] . "'>" . $row2["DS_CATEGORIA_PTRC"] . "</option>";
}
	
?>
<?php include 'topo.php'; ?>
<script language="JavaScript">
  function moveOver(combo1,combo2) {
      var count = 0;
      /* recupera itens selecionados */
      arrSelected = new Array();
      arrRemove   = new Array();
      var isNew = true;
      for (i = 0; i < combo1.length; i++) {
         if (combo1.options[i].selected) {
            arrSelected[count] = combo1.options[i].value + '|' + combo1.options[i].text;
            arrRemove[count] = i;
            count++;
         }
      }
      /* remove itens do combo1 */
      for (var r=arrRemove.length; r >= 0; r--) {
         combo1.options[arrRemove[r]] = null;
      }
      /* adiciona itens no combo 2 */
      for (var z=0; z < arrSelected.length; z++) {
         var n = arrSelected[z].split("|");
         selectedText  = n[1];
         selectedValue = n[0];
         if (combo2.length != 0) {
            for (i = 0; i < combo2.length; i++) {
               thisitem = combo2.options[i].text;
               if (thisitem == selectedText) {
                  isNew = false;
                  break;
               }
            }
         } 
         if (isNew) {
            newoption = new Option(selectedText, selectedValue, false, false);
            combo2.options[combo2.length] = newoption; /* novo item */
         }
      }
      combo1.selectedIndex=-1;
   }

   function saveMe(obj) {
      var strValues = "";
      var boxLength = obj.form.combo2.length;
      var count = 0;
      if (boxLength != 0) {
         for (i = 0; i < boxLength; i++) {
            if (count == 0) {
               strValues = obj.form.combo2.options[i].value;
            }
            else {
               strValues = strValues + " | " + obj.form.combo2.options[i].value;
            }
            count++;
         }
      }
	  document.frm.str_perm.value = strValues;
     document.frm.submit();
   }
</script>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Atacado</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='clientes_lj.php';">Lojistas Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Tipos</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						<table cellpadding="5" cellspacing="0" width="95%" align="center" border="0">
                        <tr>
                           <td>
                           
                           <p style="padding: 10px;">Os tipos liberados cont&eacute;m os produtos fora de promo&ccedil;&atilde;o que receber&atilde;o o desconto configurado para cada lojista:</p>

                        <form name="frm" action="atacado_tipos2.php" method="post" onSubmit="return PostForm();">
                        <input type="Hidden" name="str_perm" />
                   
                           <table border="0" cellpadding="4" cellspacing="2">
                        
                           <tr>
                              <td valign="top" class="field">
                                 Tipos Dispon&iacute;veis:<br />
                                 <select name="combo1" size="12" style="width:200px;" class="input" multiple>
                                    <?php print $cbMn; ?>
                                 </select>
                              </td>
                              <td class="field">
                                 <input type="button" value="&raquo;" onClick="moveOver(document.frm.combo1,document.frm.combo2);" style="font-weight:bold;"><br />
                                 <input type="button" value="&laquo;" onClick="moveOver(document.frm.combo2,document.frm.combo1);" style="font-weight:bold;">
                              </td>
                              <td valign="top" class="field">
                              Tipos liberados:<br />
                              <select multiple name="combo2" size="12" style="width:200px;" class="input">
                                    <?php print $cbPr; ?>
                              </select>
                              </td>
                           </tr>
                           <tr><td colspan="3">&nbsp;</td></tr>
                           <tr class="head">
                               <td align="center" colspan="3">
                               <a href="#" onClick="javascript:saveMe(document.frm.combo2);"><img src="img/btn_alterar.gif" border="0" alt="Gravar Alteraçôes" /></a>
                               <a href="#" onClick="javascript:history.back();"><img src="img/btn_voltar.gif" border="0" alt="Abandonar Alterações" /></a>
                               </td>
                            </tr>
                           </table>
                           
                           </form>
                           </td>
                           </tr>
                           </table>
                           
                            </td>
                           </tr>
                           </table>
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaCriar","Criar");
					  defineAbaAtiva("abaCriar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>
<?php mysql_close($con);?>