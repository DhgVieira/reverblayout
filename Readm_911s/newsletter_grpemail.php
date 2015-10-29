<?php
include 'auth.php';
include 'lib.php';
$PHP_SELF = "newsletter_grpemail.php";

$idg = request("idg");
$pagina_a = request("pagina_a");
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function confirma(idg) {
	var confirma = confirm("Confirma a Exclusao desse Grupo?")
	if ( confirma ){
		document.location.href='adminGrupos_del.php?&idg='+idg;
	} else {
		return false
	} 
}

function confirma_ass(ida) {
	var confirma = confirm("Confirma a Exclusao desse E-Mail?")
	if ( confirma ){
		document.location.href='adminAssina_del.php?&ida='+ida+'&pg=<?php echo $pagina_a; ?>&idg=<?php echo $idg; ?>';
	} else {
		return false
	} 
}

</script> 
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Newsletter</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='newsletter.php?aba=3';">Newsletter Grupos</li>
                      <li id="abaAssin" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Assinantes</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    <?php
                    $consulta_a = "select count(*) from Assinante a, AssinanteGrupo b WHERE a.IdAssinante = b.IdAssinante and b.IdGrupo = $idg";
                    list($total_usuarios_a) = mysql_fetch_array(mysql_query($consulta_a,$con));
					?>
                    <div id="Assin">
                    	<form action="adminAssin_inc.php" method="post" name="myform" id="myform">
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_ass">
                                       Nome:<br />
                                       <input class="form02" type="text" id="nome_ass" name="nome_ass" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="email_ass">
                                       E-Mail:<br />
                                       <input class="form02" type="text" id="email_ass" name="email_ass" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="idgrupo">
                                       Grupo:<br />
                                       <select name="idgrupo">
                                       <?
									  $sql = "select IdGrupo, Nome from Grupo order by Nome";
									  $st = mysql_query($sql);
			
									  if (mysql_num_rows($st) > 0) {
										while($row = mysql_fetch_row($st)) {
										 $id_grp	   = $row[0];
										 $nm_grp	   = $row[1];
										?>
										<option value="<?php echo $id_grp; ?>"><?php echo $nm_grp;?></option>
										<?
										}
									  }
									?>
                                    </select> Total de E-Mails cadastrados: <strong><?php echo $total_usuarios_a; ?></strong>
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Assinante" />
                                   </li>
                                 </ul>
                         </form>
                         <script language="JavaScript">
						   document.myform.idgrupo.value = "<?php echo $idg; ?>";
						 </script>
                          <ul class="noticias">
                            <?
							  $num_por_pagina_a = 20;
							  if (!$pagina_a) {
								 $pagina_a = 1;
							  }
							  $primeiro_registro_a = ($pagina_a*$num_por_pagina_a) - $num_por_pagina_a;
							  
                              $sql = "select a.IdAssinante, a.Nome, a.Email from Assinante a, AssinanteGrupo b WHERE a.IdAssinante = b.IdAssinante and b.IdGrupo = $idg order by a.IdAssinante desc LIMIT $primeiro_registro_a, $num_por_pagina_a";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_ass	   = $row[0];
                                 $nm_ass	   = $row[1];
								 $email		   = $row[2];
                                ?>
                                <li style="width:285px; float:left;">
                                <div>
                                <a href="#" title="deletar Assinante" onclick="confirma_ass(<?php echo $id_ass; ?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <div>
                                <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                </div>
                                </li>
                                <?
                                }
                              }
                            ?>
                          </ul>
                          
                          <ul class="paginacao" style="margin:30px 0 0 0; padding:5px; clear:both">
						<?
                        $total_paginas_a = $total_usuarios_a/$num_por_pagina_a;
                        $prev = $pagina_a - 1;
                        $next = $pagina_a + 1;
                        if ($pagina_a > 1) {
                        $prev_link = "<li><a href=\"$PHP_SELF?pagina_a=$prev&idg=$idg\">Anterior</a></li>";
                        } else { 
                        $prev_link = "<li>Anterior</li>";
                        }
                        if ($total_paginas_a > $pagina_a) {
                        $next_link = "<li><a href=\"$PHP_SELF?pagina_a=$next&idg=$idg\">Proxima</a></li>";
                        } else {
                        $next_link = "<li>Proxima</li>";
                        }
                        $total_paginas_a = ceil($total_paginas_a);
                        $painel = "";
                        for ($x=1; $x<=$total_paginas_a; $x++) {
                          if ($x==$pagina_a) { 
                            $painel .= "<li>[$x]</li>";
                          } else {
                            $painel .= "<li><a href=\"$PHP_SELF?pagina_a=$x&idg=$idg\">[$x]</a></li>";
                          }
                        }
                        echo "$prev_link";
                        //echo "$painel";
                        echo "$next_link";
						
                        ?>                
                    </ul> 
                    </div>

                    <script>
					  defineAba("abaAssin","Assin");
                      defineAbaAtiva("abaAssin");
                    </script>
                
                </div>	 <!-- /abas -->
				</td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table>
<? include 'rodape.php'; ?>
