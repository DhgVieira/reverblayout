<?php
include 'auth.php';
include 'lib.php';
$PHP_SELF = "gruposcliente_ver.php";

$idg = request("idg");
$pagina_a = request("pagina_a");
?>
<?php include 'topo.php'; ?>
<script language="javascript">

function confirma_ass(idcli,idg) {
	var confirma = confirm("Confirma a Remoção do email deste grupo?")
	if ( confirma ){
		document.location.href='gruposcliente_del2.php?&idg='+idg+'&idcli='+idcli;
	} else {
		return false
	} 
}

</script> 

<?php 
	$sql = "select DS_GRUPO_GPCAD from grupocad where NR_SEQ_GRUPO_GPCAD = '$idg'";
	$st = mysql_query($sql);
	if (mysql_num_rows($st)> 0){
		$row = mysql_fetch_row($st);
		$mgp = $row[0];
	}
	
?>
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
                      <li id="abaGrupo" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='clientes.php?aba=2';">Clientes Grupos</li>
                      <li id="abaAssin" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Grupo <?php echo $mgp;?></li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    <?php
                    $consulta_a = "select count(*) from cadastros, cadastros_grupocad WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_CADGP and NR_SEQ_GRUPO_CADGP = $idg";
                    list($total_usuarios_a) = mysql_fetch_array(mysql_query($consulta_a,$con));
					?>
                    <div id="Assin">
                    	<!--<form action="adminAssin_inc.php" method="post" name="myform" id="myform">
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
                         </form>-->
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
							  
                              $sql = "select NR_SEQ_CADASTRO_CASO, DS_NOME_CASO, DS_EMAIL_CASO
							  			from cadastros , cadastros_grupocad  
										WHERE NR_SEQ_CADASTRO_CASO = NR_SEQ_CADASTRO_CADGP and NR_SEQ_GRUPO_CADGP = $idg 
										order by NR_SEQ_CADASTRO_CASO desc LIMIT $primeiro_registro_a, $num_por_pagina_a";
                              $st = mysql_query($sql);
    
                              if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                 $id_ass	   = $row[0];
                                 $nm_ass	   = $row[1];
								 $email		   = $row[2];
                                ?>
                                <li style="width:285px; float:left;">
                                <div>
                                <a href="#" title="deletar Assinante" onclick="confirma_ass(<?php echo $id_ass; ?>,<?php echo $idg?>);"><img src="img/cancel.png" width="16" height="16" /></a>
                                </div>
                                <div>
                                <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                                </div>
                                 <div>
                                <?php echo $nm_ass; ?>
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
