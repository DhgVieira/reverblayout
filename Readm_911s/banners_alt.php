<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
?>
<? include 'topo.php'; ?>
<script type="text/javascript" src="scripts/AC_RunActiveContent.js"></script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" width="130" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Banners</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="document.location.href='banners.php';">Banners Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Banner</li>
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
                        $idb = request("idb");
						$sql = "select NR_SEQ_LOCAL_BARC, DS_DESCRICAO_BARC, DS_LINK_BARC, DS_TEXT_BARC, DS_EXT_BARC, ST_AGENDAMENTO_BARC, DT_INICIO_BARC, DT_FIM_BARC from banners WHERE NR_SEQ_BANNER_BARC = $idb";
						$st = mysql_query($sql);
						
						if (mysql_num_rows($st) > 0) {
						  	$row = mysql_fetch_row($st);
							$local		= $row[0];
					    $desc	   	= $row[1];
							$link		  = $row[2];
							$text		  = $row[3];
							$exte		  = $row[4];
              $agendado = $row[5];
              $inicio   = $row[6];
              $fim      = $row[6];

              $dia_inicio = explode(" ", $inicio);
              $dia_fim = explode(" ", $fim);
						}
						?>

                         <form action="banners_alt2.php" method="post" enctype="multipart/form-data" name="myform" id="myform">
            					<input name="idb" type="hidden" value="<?php echo $idb ?>" />
                                 <ul class="formularios">
                                   <li>
                                     <label for="descricao">
                                       Descrição do Banner:<br />
                                       <input class="form02" type="text" id="descricao" name="descricao" value="<?php echo $desc ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="link">
                                       Link:<br />
                                       <input class="form02" type="text" id="link" name="link" value="<?php echo $link ?>" />
                                     </label>
                                   </li>
                                   <li>
                                     <label for="embed">
                                       Embed:<br />
                                       <?php
										$oFCKeditor = new FCKeditor('FCKeditor1') ;
										$oFCKeditor->ToolbarSet = 'MyToolbar';
										$oFCKeditor->BasePath = 'fckeditor/' ;
										$oFCKeditor->Height = 310 ;
										$oFCKeditor->Width = 600 ;
										$oFCKeditor->ForceSimpleAmpersand = false ;
										$oFCKeditor->Value = $text ;
										$oFCKeditor->Create('embed');
										?>
                                     </label>
                                   </li>
                                   <li>
                                      <label for="foto">
                                        Imagem/swf:<br />
                                        <input class="form02" type="file" name="FILE1" style="height:25px;" />
                                      </label>
                                    </li>
                                    <?php if ($exte != "swf" && $exte) {
									?>
                                    <li>
										<img src="../arquivos/uploads/banners/<?php echo $idb; ?>.<?php echo $exte; ?>" border="0" alt="<?php echo $ds_tit; ?>"/>							
                                    </li>
									<?php }else if ($exte == "swf"){ ?>
                                    <li>
                                   		<script type="text/javascript">AC_FL_RunContent( 'type','application/x-shockwave-flash','width','300','height','170','movie','../images/banners/<?php echo $idb ?>','scale','yes','wmode','transparent' );</script>
                
                                        <noscript>
                                          <object type="application/x-shockwave-flash" width="400" height="370">
                                            <param name="scale" value="noscale" />
                                            <param name="wmode" value="transparent" />
                                          </object>
                                        </noscript>
                                    </li>
                                    <?php } ?>
                                    <li>
                                       <label for="local">
                                       Local:<br />
                                       <select name="local">
                                       <?
                                       $sql = "select NR_SEQ_BANLOCAL_BLRC, DS_LOCAL_BLRC from banners_locais order by DS_LOCAL_BLRC";
                                       $st = mysql_query($sql);
            
                                       if (mysql_num_rows($st) > 0) {
                                        while($row = mysql_fetch_row($st)) {
                                         $id_loc	   = $row[0];
                                         $nome_l	   = $row[1];
                                        ?>
                                       <option value="<?php echo $id_loc;?>"><?php echo $nome_l;?></option>
                                       <?
                                         }
                                       }
                                       ?>
                                       </select>
                                       </label>
                                   </li>
                                    <li>
                                      <label for="banner_agendado"> Banner Agendado?</br>
                                        <input type="radio" name="banner_agendado" id="banner_agendado" value="0"
                                         <?php if ($agendado == 0 or $agendado == ""){?>
                                           checked 
                                          <?php } ?> 
                                        > Não
                                         <input type="radio" name="banner_agendado" id="banner_agendado" value="1"
                                         <?php if ($agendado == 1){?>
                                          checked
                                          <?php } ?>
                                         > Sim
                                      </label>
                                    </li>
                                    <li>
                                      <label for="data_inicio"> Data Inicio </br>
                                        <input type="date" name="data_inicio" value="<?php echo $dia_inicio[0]; ?>"></br>
                                      </label>
                                      <label for="hora_inicio"> Hora inicio </br>
                                        <input type="time" name="hora_inicio" value="<?php echo $dia_inicio[1]; ?>">
                                      </label>
                                    </li>
                                     <li>
                                      <label for="data_fim"> Data Fim </br>
                                        <input type="date" name="data_fim" value="<?php echo $dia_fim[0]; ?>"></br>
                                      </label>
                                      <label for="hora_fim"> Hora Fim </br>
                                        <input type="time" name="hora_fim" value="<?php echo $dia_fim[1]; ?>">
                                      </label>
                                    </li>
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Banner" />
                                   </li>
                                 </ul>
   								<script language="javascript">
                                	document.myform.local.value = "<?php echo $local;?>";
                                </script>
                         </form>
                    
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
<?
mysql_close($con);
include 'rodape.php'; ?>