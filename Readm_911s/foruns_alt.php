<?php
include 'auth.php';
include 'lib.php';
?>
<?php include 'topo.php'; ?>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Foruns</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='foruns.php'">Foruns Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Forum</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">
						 <?
						  $idf = request("idf");
                          $sql = "select DS_FORUM_FOSO, DT_CADASTRO_FOSO, DS_NOME_CASO from foruns, cadastros where NR_SEQ_CADASTRO_FOSO = NR_SEQ_CADASTRO_CASO and NR_SEQ_FORUM_FOSO = $idf";
						  $st = mysql_query($sql);
						  $mostrapag = false;
						  if (mysql_num_rows($st) > 0) {
						  	 $row = mysql_fetch_row($st);
					         $ds_forum	   = $row[0];
							 $dt_cad	   = $row[1];
							 $ds_nome	   = $row[2];
						 ?>
                         <form action="foruns_alt2.php" method="post">
                         <input name="idf" type="hidden" value="<?php echo $idf; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome_noticia">
                                       Autor:<br />
                                       <strong><?php echo $ds_nome; ?></strong>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="nome_noticia">
                                       Nome do Forum:<br />
                                       <input class="form02" type="text" name="nome" value="<?php echo $ds_forum; ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar forum" />
                                   </li>
                                 </ul>
                             </fieldset>
                         </form>
                         <?
                         }
						 mysql_close($con);
						 ?>
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaCriar","Criar");
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
