<?php
include 'auth.php';
include 'lib.php';
$pagina = request("pagina"); 
?>
<?php include 'topo.php'; ?>

    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Blog</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='blog.php?aba=3';">Colunistas</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Colunista</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">
                    
                    <div id="Alterar">
						<?php
						 $idc = request("idc");

						$sql = "SELECT DS_COLUNISTA_CORC, DS_EMAIL_CORC, DS_DESCRICAO_CORC, DS_EXT_CORC 
								FROM colunistas
								WHERE NR_SEQ_COLUNISTA_CORC = $idc";
						$st = mysql_query($sql);
						
						if (mysql_num_rows($st) > 0) {
							$row = mysql_fetch_row($st);
							
							$nome		= $row[0];
							$email	   	= $row[1];
							$descricao	= $row[2];
							$ext		= $row[3];
							
							
							$imagperf = $idc.'.'.$ext;
							if (!file_exists("../images/colunistas/$imagperf")) $imagperf = "0.jpg";
						}
						
						?>
                         <form action="colunista_alt2.php" method="post" name="myform" enctype="multipart/form-data">
                         <input name="idc" type="hidden" value="<?php echo $idc; ?>" />
                             <fieldset>
                                 <ul class="formularios">
                                   <li>
                                     <label for="nome">
                                     <ul class="formularios">
                                   <li>
                                     <label for="nome_col">
                                       Nome:<br />
                                       <input class="form02" type="text" id="nome_col" name="nome_col"  value="<?php echo $nome;?>"/>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="email_col">
                                       E-Mail:<br />
                                       <input class="form02" type="text" id="email_col" name="email_col" value="<?PHP echo $email;?>" />
                                     </label>
                                   </li>
                                   <li>
                                   <?php 
								   		if($ext != "") {
											echo 'Foto Atual: <br /><img src="../images/colunistas/'.$imagperf.'" width="100px" height="100px" /><br />';
										}
								   ?>
                                      <label for="fot_col">
                                        Foto:<br />
                                        <input class="form02" type="file" class="select " name="FILE1" style="height:25px;" />
                                      </label>
                                    </li>
                                   <li>
                                      <label for="descricao_col">
                                        Descrição:<br />
                                        <textarea name="descricao_col" class="form02"style="height:100px;" ><?php echo $descricao;?></textarea>
                                      </label>
                                    </li>
                                  <li>
                                     <input type="submit" id="postar" name="postar" value="Alterar Colunista" />
                                   </li>
                                 </ul>
                                      
                                   
                             </fieldset>
                         </form>
                    </div> <!-- /criar -->

                    <script>
                      defineAba("abaCriar","Alterar"); 
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
<?php mysql_close($con);?>
