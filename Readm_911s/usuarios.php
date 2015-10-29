<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina");
$PHP_SELF = "usuarios.php";
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idu) {
	var confirma = confirm("Confirma a Exclusao desse Usuario?")
	if ( confirma ){
		document.location.href='usuarios_del.php?pg=<?php echo $pagina; ?>&idu='+idu;
	} else {
		return false
	} 
}

</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
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
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Usu&aacute;rios Cadastrados</li>
                      <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Cadastrar Usu&aacute;rio</li>
                      <li id="abaInativo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Usu&aacute;rios Inativos</li>
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
							<table border="0" width="575" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" width="150"><strong>Dt.Cadastro</strong></td>
                                    <td align="left" width="150"><strong>Loja</strong></td>
                                    <td align="left" width="150"><strong>Login</strong></td>
                                    <td align="center" width="25"><strong>ST</strong></td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
						<?php
						  $num_por_pagina = 40;
						  if (!$pagina) {
						  	 $pagina = 1;
						  }
						  $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
					
						  $sql = "select DT_CADASTRO_USRC, DS_LOGIN_USRC, ST_STATUS_USRC, NR_SEQ_USUARIO_USRC, DS_LOJA_LJRC
                                  from usuarios, lojas WHERE NR_SEQ_LOJA_USRC = NR_SEQ_LOJA_LJRC AND 
                                  NR_SEQ_USUARIO_USRC NOT IN (8,9,10) and NR_SEQ_LOJA_USRC = $SS_loja 
                                  AND ST_STATUS_USRC = 'A' order by DT_CADASTRO_USRC
                                  LIMIT $primeiro_registro, $num_por_pagina";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $datacad	   = $row[0];
					         $dslogin	   = $row[1];
							 $dsstatus	   = $row[2];
							 $nrsequs	   = $row[3];
                             $dsloja	   = $row[4];
							?>
                            <li>
							<table border="0" width="575" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" width="150"><strong><?php echo date("d/m/Y G:i", strtotime($datacad)); ?></strong></td>
                                    <td align="left" width="150"><?php echo $dsloja; ?></td>
                                    <td align="left" width="150"><?php echo $dslogin; ?></td>
                                    <td align="center" width="25"><strong><?php echo $dsstatus; ?></strong></td>
                                    <td align="center" width="25"><a href="usuario_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $dsstatus; ?>&idu=<?php echo $nrsequs;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="usuario_permis.php?idu=<?php echo $nrsequs;?>&pg=<?php echo $pagina;?>" title="Permissoes"><img src="img/ico_alerta.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="usuario_alt.php?idu=<?php echo $nrsequs;?>" title="Alterar usuario"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" title="Deletar usuario" onclick="confirma(<?php echo $nrsequs;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>

                      <ul class="paginacao">
						<?php
                        $consulta = "SELECT COUNT(*) FROM usuarios where NR_SEQ_USUARIO_USRC NOT IN (8,9,10) 
                        AND ST_STATUS_USRC = 'I' and NR_SEQ_LOJA_USRC = $SS_loja";
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
                        if ($total_paginas > 1) echo "$prev_link";
                        if ($total_paginas > 1) echo "$painel";
                        if ($total_paginas > 1) echo "$next_link";
						
                        ?>                
                    </ul> <!-- /paginacao -->

                      </div> <!-- /ver -->
                    
                    <div id="Criar">

                         <form action="usuario_inc.php" method="post">
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="login">
                                       Login:<br />
                                       <input class="form00" type="text" id="login" name="login" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="senha">
                                       Senha:<br />
                                       <input class="form00" type="text" id="senha" name="senha" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="email">
                                       E-Mail:<br />
                                       <input class="form00" type="text" id="email" name="email" maxlength="20" />@reverbcity.com
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Usuario" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                    
                    </div> <!-- /criar -->
					
                    <div id="Inativo">
                    
                	<ul class="noticias">
                    	<li>
							<table border="0" width="575" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" width="150"><strong>Dt.Cadastro</strong></td>
                                    <td align="left" width="150"><strong>Loja</strong></td>
                                    <td align="left" width="150"><strong>Login</strong></td>
                                    <td align="center" width="25"><strong>ST</strong></td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                    <td align="center" width="25">&nbsp;</td>
                                </tr>
                            </table>
                            </li>
						<?php
						  $sql = "select DT_CADASTRO_USRC, DS_LOGIN_USRC, ST_STATUS_USRC, NR_SEQ_USUARIO_USRC, DS_LOJA_LJRC
                                  from usuarios, lojas WHERE NR_SEQ_LOJA_USRC = NR_SEQ_LOJA_LJRC AND 
                                  NR_SEQ_USUARIO_USRC NOT IN (8,9,10) and NR_SEQ_LOJA_USRC = $SS_loja 
                                  AND ST_STATUS_USRC = 'I' order by DT_CADASTRO_USRC
                                  ";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $datacad	   = $row[0];
					         $dslogin	   = $row[1];
							 $dsstatus	   = $row[2];
							 $nrsequs	   = $row[3];
                             $dsloja	   = $row[4];
							?>
                            <li>
							<table border="0" width="575" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" width="150"><strong><?php echo date("d/m/Y G:i", strtotime($datacad)); ?></strong></td>
                                    <td align="left" width="150"><?php echo $dsloja; ?></td>
                                    <td align="left" width="150"><?php echo $dslogin; ?></td>
                                    <td align="center" width="25"><strong><?php echo $dsstatus; ?></strong></td>
                                    <td align="center" width="25"><a href="usuario_sta.php?pg=<?php echo $pagina; ?>&st=<?php echo $dsstatus; ?>&idu=<?php echo $nrsequs;?>" title="Alterar Status"><img src="img/ico_cancel.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="usuario_permis.php?idu=<?php echo $nrsequs;?>&pg=<?php echo $pagina;?>" title="Permissoes"><img src="img/ico_alerta.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="usuario_alt.php?idu=<?php echo $nrsequs;?>" title="Alterar usuario"><img src="img/ico-det.gif" width="16" height="16" border="0" /></a></td>
                                    <td align="center" width="25"><a href="#" title="Deletar usuario" onclick="confirma(<?php echo $nrsequs;?>);"><img src="img/cancel.png" width="16" height="16" border="0" /></a></td>
                                </tr>
                            </table>
                            </li>
							<?php
							}
						  }
						 
						?>
                      </ul>

                     

                      </div>

                    <script>
					  defineAba("abaVer","Ver");
                      defineAba("abaCriar","Criar");
                      defineAba("abaInativo","Inativo");
					  defineAbaAtiva("abaVer");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<?php
mysql_close($con);
include 'rodape.php'; ?>