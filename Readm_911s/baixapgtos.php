<?php
include 'auth.php';
include 'lib.php';
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Baixa de Pagamentos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaImport" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">BOLETOS</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Import">
                    <table>
                    	<tr>
                        	<td style="padding: 6px;">
                            	<strong>Para efetuar a baixa automática de boletos faça o upload do arquivo fornecido pelo banco</strong>
                            </td>
                        </tr>
                      <tr>
                        	<td >
                    	 <form action="baixapgtos2.php" method="post" enctype="multipart/form-data"  style="width:420px">
                         		<ul class="formularios">
                                   <li>
                                     <label for="link">
                                       Arquivo txt:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                     </label>
                                   </li>
                                    <li>
                                     <input type="submit" id="postar" name="postar" value="Enviar Arquivo" />
                                   </li>
                                 </ul>
                         </form>
                         </td>
                     </tr>
                 </table>
                    </div>

                    <script>
					  defineAba("abaImport","Import");
					  <?php
				  	  echo "defineAbaAtiva(\"abaImport\");";
					  ?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
              </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>