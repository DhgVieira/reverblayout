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
                      <li id="menuDepo" class="abaativa">Configurações de promoções</li>
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
                
                    <div id="BannerEspe" style="float: left; width: 400px;">
                    	<form action="promocoes_alt.php" method="post">
                         <fieldset>
                             <table width="300">
                                <tr>
                                    <td colspan="2">Altere uma ou mais promos, apos alterar clique em <strong>Alterar Promo</strong></br></td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Primeira compra</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?php
                                $sql = "SELECT
                                            st_primeira_compra,
                                            vl_primeira_compra, 
                                            msg_primeira_compra 
                                        FROM 
                                            promocoes";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $status_pc   = $row[0];
                                    $valor_pc    = $row[1];
                                    $msg_pc      = $row[2];
                                }
                                ?>
                                <tr>
                                    <td>
                                        <strong>Valor (Igual ou acima):</strong>
                                    </td>
                                    <td>
                                        <input class="form01" type="text" name="valor_pc" style="width:60px;" value="<?php echo number_format($valor_pc,2,",","") ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Promo Ativa?</strong></td>
                                    <td>
                                        <input name="status_pc" type="radio" value="1"<?php if ($status_pc == "1") echo " checked"?> />
                                            SIM 
                                        <input name="status_pc" type="radio" value="0"<?php if ($status_pc == "0") echo " checked"?> /> 
                                            Não
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Mensagem Carrinho:</strong>
                                    </td>
                                    <td>
                                        <textarea name="msg_pc" rows="8" cols="30">
                                            <?php echo utf8_encode($msg_pc) ?>
                                        </textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        </br>
                                            <hr width="400px" heigth="2px" bgcolor="black">
                                        </br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Aniversário</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?php
                                $sql = "SELECT
                                            st_promo_niver,
                                            msg_promo_niver 
                                        FROM 
                                            promocoes";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $status_ni   = $row[0];
                                    $msg_ni      = $row[1];
                                }
                                ?>
                                
                                <tr>
                                    <td><strong>Promo Ativa?</strong></td>
                                    <td>
                                        <input name="status_ni" type="radio" value="1"<?php if ($status_ni == "1") echo " checked"?> />
                                            SIM 
                                        <input name="status_ni" type="radio" value="0"<?php if ($status_ni == "0") echo " checked"?> /> 
                                            Não
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Mensagem Carrinho:</strong>
                                    </td>
                                    <td>
                                        <textarea name="msg_ni" rows="8" cols="30">
                                            <?php echo utf8_encode($msg_ni) ?>
                                        </textarea>
                                    </td>
                                </tr>

                                 <tr>
                                    <td colspan="2">
                                        </br>
                                            <hr width="400px" heigth="2px" bgcolor="black">
                                        </br>
                                    </td>

                                </tr>

                                <tr>
                                    <td colspan="2"><strong>Frete Gratis Londrina</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">&nbsp;</td>
                                </tr>
                                <?php
                                $sql = "SELECT
                                            st_frete_londrina,
                                            vl_frete_londrina
                                        FROM 
                                            promocoes";
                                $st = mysql_query($sql);
                                if (mysql_num_rows($st) > 0) {
                                    $row = mysql_fetch_row($st);
                                    $status_fl   = $row[0];
                                    $valor_ft    = $row[1];
                                   
                                }
                                ?>
                                <tr>
                                    <td>
                                        <strong>Valor (Igual ou acima):</strong>
                                    </td>
                                    <td>
                                        <input class="form01" type="text" name="valor_frete" style="width:60px;" value="<?php echo number_format($valor_ft,2,",","") ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Promo Ativa?</strong></td>
                                    <td>
                                        <input name="status_frete" type="radio" value="1"<?php if ($status_fl == "1") echo " checked"?> />
                                            SIM 
                                        <input name="status_frete" type="radio" value="0"<?php if ($status_fl == "0") echo " checked"?> /> 
                                            Não
                                    </td>
                                </tr>
                               
                                <tr>
                                    
                                    <td>
                                        </br>
                                        <input type="submit" id="postar" name="postar" value=" Alterar Promo " />
                                    </td>
                                </tr>
                             </table>
                         </fieldset>
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