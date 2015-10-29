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
                      <li id="menuDepo" class="abaativa">Frete</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">PAC</li>
                      <li id="abaEsedex" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">E-SEDEX</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Criar">
						<?php
						 $idc = request("idc");

						$sql = "SELECT * FROM fretes order by NR_FAIXAPESO_FRRC";
						$st = mysql_query($sql);
						
						if (mysql_num_rows($st) > 0) {
						?>
									<?php
									$arraycampos = array('NR_SEQ_FRETE_FRRC','Peso','LDA','AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO');
                                    while($row = mysql_fetch_row($st)) {
										echo "<ul class=\"frete\">";
										if ($SS_nivel >= 50) echo " <form action=\"frete2.php\" method=\"post\" name=\"myform\">";
			                            if ($SS_nivel >= 50) echo " <input name=\"idf\" type=\"hidden\" value=\"".$row[0]."\" />";
										echo " <fieldset>";
										for ($f=1;$f<30;$f++){
									?>
                                   <li>
                                     <label for="nome">
                                        <?php echo $arraycampos[$f] ?>:<br />
                                        <?php if ($SS_nivel < 50) {?>
                                        <?php echo number_format($row[$f],3,",",""); ?>
                                        <?php }else{ ?>
                                        <input maxlength="10" class="form02" style="width:35px;" type="text" name="<?php echo $arraycampos[$f] ?>" value="<?php echo number_format($row[$f],3,",",""); ?>" />
                                        <?php }?>
                                     </label>
                                   </li>
                                   <?php }
								   		if ($SS_nivel >= 50) {
                                            echo "<li>";
    										echo " <input type=\"submit\" id=\"postar\" name=\"posta\" value=\"Alterar Dados\" />";
    									    echo "</li>";
    								   		echo "</fieldset></form></ul>";
                                        }else{
                                            echo "</fieldset></ul>";
                                        }
									}?>
                                    <ul class="frete">
                                   </ul>
                         <?php }?>
                    </div> <!-- /criar -->
                    <!-- <div id="Esedex">
                        <?php
                         $idc = request("idc");

                        $sql = "SELECT
                                idfaixa_esedex, 
                                cidade, 
                                cep_inicio, 
                                cep_fim, 
                                valor, 
                                faixa_peso
                            FROM
                                cidades_esedex
                                    inner join
                                faixas_has_esedex ON faixas_has_esedex.idcidade_esedex = cidades_esedex.idcidade_esedex
                                inner join
                              faixas_peso_esedex on faixas_peso_esedex.idfaixa_peso_esedex = faixas_has_esedex.idfaixa_peso_esedex
                            order by faixa_peso ASC";
                        $st = mysql_query($sql);
                        
                        if (mysql_num_rows($st) > 0) {
                        ?>
                                    <?php
                                    $arraycampos = array('cidade', 'cep_inicio','cep_inicio','cep_fim','valor', 'faixa_peso');
                                    while($row = mysql_fetch_row($st)) {
                                        echo "<ul class=\"esedex\">";
                                        if ($SS_nivel >= 50) echo " <form action=\"esedex_alt.php\" method=\"post\" name=\"myform\">";
                                        if ($SS_nivel >= 50) echo " <input name=\"idf\" type=\"hidden\" value=\"".$row[0]."\" />";
                                        echo " <fieldset>";
                                        for ($se=1;$se<7;$se++){
                                    ?>
                                   <li width="140px">
                                    <div class="div_frete">
                                       <label for="nome">
                                          <?php echo $arraycampos[$se] ?>:<br />
                                          <?php if ($SS_nivel < 50) {?>
                                          <?php echo number_format($row[$se],3,",",""); ?>
                                          <?php }else{ ?>
                                          <input class="form02" style="width:120px;" type="text" name="<?php echo $arraycampos[$se] ?>" value="<?php echo utf8_decode($row[$se]); ?>" />
                                          <?php }?>
                                       </label>
                                      </div>
                                   </li>
                                   <?php }
                                        if ($SS_nivel >= 50) {
                                            echo "<li>";
                                            echo " <input type=\"submit\" id=\"postar\" name=\"posta\" value=\"Alterar Dados\" />";
                                            echo "</li>";
                                            echo "</fieldset></form></ul>";
                                        }else{
                                            echo "</fieldset></ul>";
                                        }
                                    }?>
                                    <ul class="frete">
                                   </ul>
                         <?php }?>
                    </div> <!-- /criar --> -->

                    <script>
                      defineAba("abaCriar","Criar");
                      defineAba("abaEsedex","E-sedex");
					  defineAbaAtiva("abaCriar");
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
