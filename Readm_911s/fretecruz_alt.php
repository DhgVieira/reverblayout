<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina"); 
?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Compras</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='compras.php?st=F';">Informações de Frete</li>
                      <li id="abaAlterar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Frete</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Alterar">
						<?php
						 $idf = request("idf");

						$sql = "SELECT DT_COMPRA_FCRC, NR_COMPRA_FCRC, VL_FRETE_FCRC, VL_CORREIO_FCRC, VL_CORREIOEXT_FCRC 
								FROM fretescruzados
								WHERE NR_SEQ_FRETE_FCRC = $idf";
						$st = mysql_query($sql);
						
						if (mysql_num_rows($st) > 0) {
							$row = mysql_fetch_row($st);
							
							$dt_compra		= $row[0];
							$ds_compra		= $row[1];
							$vl_fret		= $row[2];
							$vl_corr		= $row[3];
							$vl_corr2		= $row[4];
							
						}
						
						?>
                         <form action="fretecruz_alt2.php" method="post" name="myform" enctype="multipart/form-data">
                         <input name="idf" type="hidden" value="<?php echo $idf; ?>" />
                         
                               <label for="datafret">
                                 Data:<br />
                                 <input class="form01" type="text" id="datafret" name="datafret" value="<?php echo $dt_compra;?>"/>
                               </label><br />
                          
                               <label for="comprafret">
                                 Compra:<br />
                                 <input class="form01" type="text" id="comprafret" name="comprafret" value="<?php echo $ds_compra;?>"/>
                               </label><br />
                               
                               <label for="frete">
                                 Frete:<br />
                                 <input class="form01" type="text" id="frete" name="frete" value="<?php echo $vl_fret;?>" />
                               </label><br />
                               
                               <label for="correio">
                                 Correio:<br />
                                 <input class="form01" type="text" id="correio" name="correio" value="<?php echo $vl_corr;?>" />
                               </label><br />
                           
                                 <label for="correio2">
                                 Correio2:<br />
                                 <input class="form01" type="text" id="correio2" name="correio2" value="<?php echo $vl_corr2;?>" />
                               </label><br /><br />
                            
                               <input type="submit" id="postar" name="postar" value="Alterar Frete" />
           
                         </form>
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaAlterar","Alterar"); 
					  defineAbaAtiva("abaAlterar");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
<?php mysql_close($con);?>
