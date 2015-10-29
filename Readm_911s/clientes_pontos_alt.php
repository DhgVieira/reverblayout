<?php
include 'auth.php';
include 'lib.php';
$idp = request("idp");
$idc = request("idc");
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Clientes</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='clientes.php';">Clientes Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='clientes_pontos.php?idc=<?php echo $idc ?>';">Pontos</li>
                      <li id="abaAdic" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Pontos</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    <div id="Adicionar">
                    	<div style="margin:0 0 0 40px; min-height:300px">
                            <h2 style="margin:0 0 20px 0; padding:5px;float:left;clear:both;"><?php echo PegaNome($idc) ?></h2>
                            <?php
                            $sql = "SELECT NR_SEQ_PONTOS_PORC, NR_SEQ_REFERENCIA_PORC, NR_SEQ_COMPRA_PORC, NR_QTDE_PORC, ST_PONTOS_PORC,
									NR_SEQ_COMPRAUTIL_PORC FROM pontos WHERE NR_SEQ_PONTOS_PORC = $idp";
							$st = mysql_query($sql);
							if (mysql_num_rows($st) > 0) {
								$row = mysql_fetch_row($st);
								$idponto	= $row[0];
								$nrrefer	= $row[1];
								$nrseqcom	= $row[2];
								$nrpontos	= $row[3];
								$stpontos	= $row[4];
								$comprauti	= $row[5];
							}
							?>
                            <form action="clientes_pontos_alt2.php" method="post" name="myform">
                         	<input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                            <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="Pontos">
                                       Quantidade de Pontos:<br />
                                       <input class="form02" style="width:80px;" type="text" name="pontos" value="<?php echo $nrpontos ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="refere">
                                       Referente:<br />
                                       <select name="refere">
                                       		<option value="1"<?php if ($nrrefer == 1) echo " selected"; ?>>Compra Realizada</option>
                                            <option value="2"<?php if ($nrrefer == 2) echo " selected"; ?>>Foto liberada no People</option>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="compra">
                                       Compra (ID - não obrigatório):<br />
                                       <input class="form02" style="width:80px;" type="text" name="compra" value="<?php echo $nrseqcom ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="compruti">
                                       Compra Utilizado (ID - não obrigatório):<br />
                                       <input class="form02" style="width:80px;" type="text" name="compruti" value="<?php echo $comprauti ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="status">
                                       Status dos Pontos:<br />
                                       <select name="status">
                                       		<option value="E"<?php if ($stpontos == "E") echo " selected"; ?>>Disponível</option>
                                            <option value="U"<?php if ($stpontos == "U") echo " selected"; ?>>Utilizado</option>
                                            <option value="C"<?php if ($stpontos == "C") echo " selected"; ?>>Cancelado</option>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Pontos" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                        </div>
                    </div>

                    <script>
					  defineAba("abaAdic","Adicionar");
					  defineAbaAtiva("abaAdic");
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
