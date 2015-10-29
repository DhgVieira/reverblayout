<?php
include 'auth.php';
include 'lib.php';
?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Ponto</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Funcionários</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    <div id="Ver">

						<?php if ($SS_nivel >= 50) { ?>
                        <ul class="compras" style="padding: 0 0 0 10px;">
						<?php
                        $str = "select DS_FUNCIONARIO_FURC, NR_SEQ_FUNCIONARIO_FURC from funcionarios WHERE NR_SEQ_LOJA_FURC = $SS_loja";
                        $st = mysql_query($str);
                        ?>
                        <li>
                        <table class="textostabelas" width="700" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0" align="center">
                            <tr bgcolor='#FFFFFF'>
                                <td><b>Funcionário</b></td>
                                <td align="center" width="50">&nbsp;</td>
                            </tr>
                         </table>
                         </li>
                            <?php
                            if (mysql_num_rows($st) > 0) {
                            while($row = mysql_fetch_row($st)) {
                             $dsdec		   = $row[0];
                             $nrfun		   = $row[1];
                            ?>
                            <li>
                            <table class="textostabelas" width="1000" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td><?php echo $dsdec;?></td>
                                
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="12/2012" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=12&ano=2012');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <!--
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="03/2011" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=3&ano=2011');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="04/2011" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=4&ano=2011');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="05/2011" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=5&ano=2011');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="06/2011" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=6&ano=2011');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="07/2011" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=7&ano=2011');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="08/2011" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=8&ano=2011');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="09/2011" onClick="document.location.href=('ponto2.php?id=<?php echo $nrfun;?>&mes=9&ano=2011');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                -->
                                <?php for($f=1;$f<=date("n");$f++){?>
                                <td align="center" nowrap="nowrap" width="70">
                                    <input type="Button" value="<?php echo str_pad($f,2,"0",STR_PAD_LEFT);?>/<?php echo date("Y"); ?>" onClick="window.open('ponto2.php?id=<?php echo $nrfun;?>&mes=<?php echo $f; ?>&ano=<?php echo date("Y"); ?>');" class="form00" style="width:65px;height:25px;" />
                                </td>
                                <?php } ?>
                            </tr>
                            </table>
                            </li>
                            <?php
                                }
                            }
                            ?>

                    	</ul>
                        <?php
                            }
                        if ($SS_logadm == 1){
                        ?>
                        <br />
                        <form action="ponto_batida.php" method="post">
                            <input type="submit" value="REGISTRAR" style="width: 120px; height: 60px;" />
                        </form>
                        <?php } ?>
                   
                    </div> <!-- /ver -->
                    

                    <script>
                      defineAba("abaVer","Ver");
                     
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
              </td>
            </tr>
        </table>
<?php include 'rodape.php'; ?>