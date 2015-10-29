<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "party.php";
?>
<? include 'topo.php'; ?>
<script language="javascript">
function confirma(idp,ext) {
	var confirma = confirm("Confirma a Exclusao dessa Party e seus comentarios?")
	if ( confirma ){
		document.location.href='party_del.php?pg=<?php echo $pagina; ?>&idp='+idp+'&ext='+ext;
	} else {
		return false
	} 
}

</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Party</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Partys Cadastradss</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Cadastrar Party</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                
                    <div id="Ver">
                    
                	<ul class="noticias">
                    	<li>
							<table border="0" width="875" cellpadding="0" cellspacing="0">
                                <tr>
                                	<td align="center" width="60"><strong>Flyer</strong></td>
                                    <td align="center" width="120"><strong>Dt.Cadastro</strong></td>
                                    <td align="left" width="170"><strong>Autor</strong></td>
                                    <td align="left"><strong>Party</strong></td>
                                    <td align="center" width="70"><strong>Party Data</strong></td>
                                    <td align="center" width="120"><strong>Cidade/UF</strong></td>
                                    <td align="center" width="25"><strong>ST</strong></td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                    <td align="center" width="20">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
						<?
						  $num_por_pagina = 20;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select NR_SEQ_PARTY_PARC, DT_PARTY_PARC, DS_PARTY_PARC, DS_CIDADE_PARC, DS_UF_PARC, DT_CADASTRO_PARC, ST_PARTY_PARC, DS_NOME_CASO, DS_EXT_PARC from partys, cadastros WHERE NR_SEQ_AUTOR_PARC = NR_SEQ_CADASTRO_CASO order by DT_CADASTRO_PARC desc LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	$mostrapag = true;
						  	while($row = mysql_fetch_row($st)) {
							 $id_part	   = $row[0];
					         $dt_party	   = $row[1];
							 $ds_party	   = $row[2];
							 $ds_cidade	   = $row[3];
							 $ds_uf	   	   = $row[4];
							 $dt_cad	   = $row[5];
							 $status	   = $row[6];
							 $ds_autor	   = $row[7];
							 $ds_ext	   = $row[8];
							?>
                            <li>
							<table border="0" width="875" cellpadding="0" cellspacing="0">
                                <tr>
                                	<td align="center" width="60"><a href="../images/partys/<?php echo $id_part; ?>.<?php echo $ds_ext; ?>" class="lightview"><img src="../images/partys/<?php echo $id_part; ?>p.<?php echo $ds_ext; ?>" border="0" width="50" height="50" /></a></td>
                                    <td align="center" width="120"><strong><?php echo date("d/m/Y G:i", strtotime($dt_cad)); ?></strong></td>
                                    <td align="left" width="170"><?php echo $ds_autor; ?></td>
                                    <td align="left"><?php echo $ds_party; ?></td>
                                    <td align="center" width="70"><?php echo date("d/m/Y", strtotime($dt_party)); ?></td>
                                    <td align="center" width="120"><?php echo $ds_cidade; ?>/<?php echo $ds_uf; ?></td>
                                    <td align="center" width="25"><strong><?php echo $status; ?></strong></td>
                                    <td align="center" width="20"><a href="party_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $status; ?>&idp=<? echo $id_part;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="party_coments.php?idp=<?php echo $id_part;?>&pg=<?php echo $pagina;?>" title="Comentarios"><img src="img/ico_coment.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="party_alt.php?idp=<?php echo $id_part;?>" title="Alterar Party"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="20"><a href="#" title="Deletar Party" onclick="confirma(<?php echo $id_part;?>,'<?php echo $ds_ext; ?>');"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?
							}
						  }
						 
						?>
                      </ul>
                      <?php if ($mostrapag) {?>
                      <ul class="paginacao">
						<?
                        $consulta = "SELECT COUNT(*) FROM partys, cadastros WHERE NR_SEQ_AUTOR_PARC = NR_SEQ_CADASTRO_CASO";
                        list($total_usuarios) = mysql_fetch_array(mysql_query($consulta,$con));
                        
                        $total_paginas = $total_usuarios/$num_por_pagina;
                        $prev = $pagina - 1;
                        $next = $pagina + 1;
                        if ($pagina > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina=$prev\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas > $pagina) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina=$next\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas = ceil($total_paginas);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas; $x++) {
                          if ($x==$pagina) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina=$x\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul> <!-- /paginacao -->
                    <?php } ?>
                      </div> <!-- /ver -->
                    
                    <div id="Criar">

                         <form action="party_inc.php" method="post" enctype="multipart/form-data">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="party">
                                       Party:<br />
                                       <input class="form01" type="text" id="party" name="party" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="data">
                                       Party Data:<br />
                                       <select name="dia" class="input" id="dia" style="width:40px">
									   <?php for ($f=1;$f<=31;$f++){?>
                                            <option value="<?php echo $f; ?>"><?php echo $f; ?></option>
                                       <?php }?>     
                                      </select>
                                      <select name="mes" class="input" id="mes" style="width:100px">
                                            <option value="1">Janeiro</option>
                                            <option value="2">Fevereiro</option>
                                            <option value="3">Março</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Maio</option>
                                            <option value="6">Junho</option>
                                            <option value="7">Julho</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Setembro</option>
                                            <option value="10">Outubro</option>
                                            <option value="11">Novembro</option>
                                            <option value="12">Dezembro</option>
                                      </select>
                                      <select name="ano" class="input" id="ano" style="width:55px">
                                       <?php for ($f=2008;$f<=2010;$f++){?>
                                            <option value="<?php echo $f; ?>"><?php echo $f; ?></option>
                                       <?php }?>
                                      </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="cidade">
                                       Cidade:<br />
                                       <input class="form01" type="text" id="cidade" name="cidade" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="estado">
                                       Estado:<br />
                                       <select name="estado" class="form01" id="estado" style="height:25px;" />
                                        <option value="AC">Acre</option> 
                                        <option value="AL">Alagoas</option> 
                                        <option value="AP">Amapá</option> 
                                        <option value="AM">Amazonas</option> 
                                        <option value="BA">Bahia</option> 
                                        <option value="CE">Ceará</option> 
                                        <option value="DF">Distrito Federal</option> 
                                        <option value="ES">Espírito Santo</option> 
                                        <option value="GO">Goiás</option> 
                                        <option value="MA">Maranhão</option> 
                                        <option value="MT">Mato Grosso</option> 
                                        <option value="MS">Mato Grosso do Sul</option> 
                                        <option value="MG">Minas Gerais</option> 
                                        <option value="PA">Pará</option> 
                                        <option value="PB">Paraíba</option> 
                                        <option value="PR">Paraná</option> 
                                        <option value="PE">Pernambuco</option> 
                                        <option value="PI">Piauí</option> 
                                        <option value="RJ">Rio de Janeiro</option> 
                                        <option value="RN">Rio Grande do Norte</option> 
                                        <option value="RS">Rio Grande do Sul</option> 
                                        <option value="RO">Rondônia</option> 
                                        <option value="RR">Roraima</option> 
                                        <option value="SC">Santa Catarina</option> 
                                        <option value="SP">São Paulo</option> 
                                        <option value="SE">Sergipe</option> 
                                        <option value="TO">Tocantins</option> 
                                    </select>        
                                     </label>
                                   </li>
                                   <li>
                                      <label for="flyer">
                                        Flyer:<br />
                                        <input class="form02" type="file" name="FILE1" size="60" style="height:25px;" />
                                      </label>
                                    </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Party" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    
                    </div> <!-- /criar -->
					

                    <script>
					  defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
					  defineAbaAtiva("abaVer");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?
mysql_close($con);
include 'rodape.php'; ?>