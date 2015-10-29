<?php
include 'auth.php';
include 'lib.php';
$idu = request("idu");

$sql = "SELECT NR_SEQ_MENU_MERC, DS_DESCRICAO_MERC ";
$sql = $sql . "FROM menus WHERE NR_SEQ_MENU_MERC not in (SELECT NR_SEQ_MENU_PERC FROM permissoes WHERE NR_SEQ_USUARIO_PERC=" . $idu . ") and DS_STATUS_MERC = 'A' and (NR_SEQ_LOJA_MERC = ".PegaLojaAdm($idu)." OR NR_SEQ_LOJA_MERC = 0)";
$st1 = mysql_query($sql);
$cbMn = "";

while($row1 = mysql_fetch_assoc($st1)) {
  $cbMn = $cbMn . "<option value='" . $row1["NR_SEQ_MENU_MERC"] . "'>" . $row1["DS_DESCRICAO_MERC"] . "</option>";
}

$sql = "SELECT NR_SEQ_MENU_MERC, DS_DESCRICAO_MERC ";
$sql = $sql . "FROM menus, permissoes WHERE NR_SEQ_MENU_MERC = NR_SEQ_MENU_PERC and NR_SEQ_USUARIO_PERC = $idu";
$st2 = mysql_query($sql);
$cbPr = "";

while($row2 = mysql_fetch_assoc($st2)) {
  $cbPr = $cbPr . "<option value='" . $row2["NR_SEQ_MENU_MERC"] . "'>" . $row2["DS_DESCRICAO_MERC"] . "</option>";
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
                      <li id="menuDepo" class="abaativa">Usu&aacute;rios</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='usuarios.php';">Usu&aacute;rios Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Permissoes</li>
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

                        <form name="frm" action="altPermissaoMenu.php" method="post" onSubmit="return PostForm();">
                       <input type="Hidden" name="idu" value="<?php print $idu; ?>" />
                       <input type="Hidden" name="str_perm" />
                   
                           <table border="0" cellpadding="4" cellspacing="2">
                        
                           <tr>
                              <td valign="top" class="field">
                                 Menus Dispon&iacute;veis:<br />
                                 <select name="combo1" size="12" style="width:200px;" class="input" multiple>
                                    <?php print $cbMn; ?>
                                 </select>
                              </td>
                              <td class="field">
                                 <input type="button" value="&raquo;" onClick="moveOver(document.frm.combo1,document.frm.combo2);" style="font-weight:bold;"><br />
                                 <input type="button" value="&laquo;" onClick="moveOver(document.frm.combo2,document.frm.combo1);" style="font-weight:bold;">
                              </td>
                              <td valign="top" class="field">
                              Permiss&ocirc;es do Usu&aacute;rio:<br />
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