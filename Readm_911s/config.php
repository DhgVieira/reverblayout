<?php
include 'auth.php';
include 'lib.php';
$aba = request("aba");
?>
<?php include 'topo.php'; ?>
<script type="text/javascript" src="scripts/jquery.min.js"></script>
<script type="text/javascript" src="scripts/preenche.js"></script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Configura&ccedil;&otilde;es Gerais</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaBannerEsp" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Configura&ccedil;&otilde;es</li>
                      <?php if ($SS_nivel == 100) { ?>
                      <li id="abaComissoes" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Comiss&otilde;es</li>
                      <?php } ?>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="aba1">
                
                    <div id="BannerEspe" style="float: left; width: 300px;">
                    	<form action="config2.php" method="post">
                         <fieldset>
                             <table width="300">
                                <tr>
                                    <td colspan="2"><strong>Frete Grátis (todo site)</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?php
                                $sql = "select ST_FRETEGRATIS_GESA, VL_FRETEGRATIS_GESA from config_gerais WHERE NR_SEQ_CONFIG_GESA = 1";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $stfrete   = $row[0];
                                    $vlrfrete  = $row[1];
                                }
                                ?>
                                <tr>
                                    <td><strong>Valor (acima de):</strong></td>
                                    <td><input class="form01" type="text" name="valorfrete" style="width:60px;" value="<?php echo number_format($vlrfrete,2,",","") ?>" /></td>
                                </tr>
                                <tr>
                                    <td><strong>Habilitado:</strong></td>
                                    <td><input name="fretehab" type="radio" value="A"<?php if ($stfrete == "A") echo " checked"?> /> SIM <input name="fretehab" type="radio" value="I"<?php if ($stfrete == "I") echo " checked"?> /> N&Atilde;O</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" id="postar" name="postar" value=" Alterar Frete " /></td>
                                </tr>
                             </table>
                         </fieldset>
                     </form>
                    </div>
                    
                    <div id="FreteEstado">
                    	<form action="config_frete.php" method="post">
                         <fieldset>
                             <table width="300">
                                <tr>
                                    <td colspan="2"><strong>Frete especial para Estados:</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        <select name="estado" id="estado">
                                        <option value="0">Escolha o Estado</option>
                                        <?php
                                        $sql = "select DS_SIGLA_EFRC, DS_ESTADO_EFRC from estados_frete";
                                        $st = mysql_query($sql);
                                        if (mysql_num_rows($st) > 0) {
                                            while($row = mysql_fetch_row($st)){
                                            $ufestado   = $row[0];
                                            $dsestado   = $row[1];
                                        ?>
                                            <option value="<?php echo $ufestado; ?>"><?php echo utf8_encode($dsestado); ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Valor Fixo:</strong></td>
                                    <td><input class="form01" type="text" name="valorfreteuf" id="valorfreteuf" style="width:60px;" value="" /></td>
                                </tr>
                                <tr>
                                    <td><strong>Habilitado:</strong></td>
                                    <td><input name="fretehabuf" type="radio" value="A" id="fretehabufs" /> SIM <input name="fretehabuf" id="fretehabufn" type="radio" value="I" /> N&Atilde;O</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" id="postar" name="postar" value=" Alterar Frete " /></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Estados Habilitados:</strong></td>
                                </tr>
                                <?php
                                $sql = "select DS_SIGLA_EFRC, DS_ESTADO_EFRC, ST_FRETEGRATIS_EFRC, VL_VALOR_EFRC from estados_frete WHERE ST_FRETEGRATIS_EFRC = 'A'";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    while($row = mysql_fetch_row($st)){
                                    $ufestado   = $row[0];
                                    $dsestado   = $row[1];
                                    $stfrete    = $row[2];
                                    $vlfrete    = $row[3];
                                    
                                    if ($vlfrete == 0){
                                        $vlfrete = "FRETE GRÁTIS";
                                    }else{
                                        $vlfrete = "R$ ".number_format($vlfrete,2,",","");
                                    }
                                ?>
                                <tr>
                                    <td><strong><?php echo utf8_encode($dsestado); ?> - <?php echo $ufestado; ?>:</strong></td>
                                    <td><?php echo $vlfrete ?></td>
                                </tr>
                                <?php
                                    }
                                }
                                ?>
                             </table>
                         </fieldset>
                     </form>
                    </div>
                    
                    </div>
                                       
                    <div id="Comiss">
                        

                        <form action="config_rastream1.php" method="post">
                        <div style="float: left; width: 300px;">
                         <fieldset>
                             <table width="300">
                                <tr>
                                    <td colspan="2"><strong>Captura códigos de Reastreamento:</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php
                                        $mes = date("m");
                                        ?>
                                        <select name="dia" id="dia" style="width:45px">
                                           <?php for ($f=1;$f<=31;$f++){?>
                                            	<option value="<?php echo str_pad($f,2,"0",STR_PAD_LEFT); ?>" <?php if (date("d") == $f){ echo 'selected="selected"';}?> ><?php echo str_pad($f,2,"0",STR_PAD_LEFT); ?></option>
                                           <?php }?>     
                                          </select>
                                          <select name="mes" id="mes" style="width:100px">
                                            	<option value="01" <?php if ($mes == 1){ echo 'selected="selected"';}?> >Janeiro</option>
                                                <option value="02" <?php if ($mes == 2){ echo 'selected="selected"';}?> >Fevereiro</option>
                                                <option value="03" <?php if ($mes == 3){ echo 'selected="selected"';}?> >Março</option>
                                                <option value="04" <?php if ($mes == 4){ echo 'selected="selected"';}?> >Abril</option>
                                                <option value="05" <?php if ($mes == 5){ echo 'selected="selected"';}?> >Maio</option>
                                                <option value="06" <?php if ($mes == 6){ echo 'selected="selected"';}?>>Junho</option>
                                                <option value="07" <?php if ($mes == 7){ echo 'selected="selected"';}?> >Julho</option>
                                                <option value="08" <?php if ($mes == 8){ echo 'selected="selected"';}?> >Agosto</option>
                                                <option value="09" <?php if ($mes == 9){ echo 'selected="selected"';}?> >Setembro</option>
                                                <option value="10" <?php if ($mes == 10){ echo 'selected="selected"';}?> >Outubro</option>
                                                <option value="11" <?php if ($mes == 11){ echo 'selected="selected"';}?> >Novembro</option>
                                                <option value="12" <?php if ($mes == 12){ echo 'selected="selected"';}?> >Dezembro</option>
                                          </select>
                                          <select name="ano" id="ano" style="width:60px">
                                           <?php for ($f=date("Y")-1;$f<=date("Y")+1;$f++){?>
                                            	<option value="<?php echo $f; ?>" <?php if (date("Y") == $f){ echo 'selected="selected"';}?> ><?php echo $f; ?></option>
                                           <?php }?>
                                          </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td><input type="submit" id="postar" name="postar" value="   CAPTURAR   " /></td>
                                </tr>
                             </table>
                         </fieldset>
                        </div>
                        </form>   
                    </div>

                    
                    <script>
					  defineAba("abaBannerEsp","aba1");
                      <?php if ($SS_nivel == 100) { ?>
                      defineAba("abaComissoes","Comiss");
                      <?php } ?>
					  <?php
					  if (!$mostrapag && !$aba) $aba = 1;
					  switch($aba){
					  	  case 1:
						  	  echo "defineAbaAtiva(\"abaBannerEsp\");";
							  break;
                          case 2:
						  	  echo "defineAbaAtiva(\"abaComissoes\");";
							  break;
						  default:
						  	  echo "defineAbaAtiva(\"abaBannerEsp\");";
							  break;
					   }
					  ?>
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br />
                </td>
            </tr>
        </table>
<?php
mysql_close($con);
include 'rodape.php'; ?>