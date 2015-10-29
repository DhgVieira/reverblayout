<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
?>
<?php include 'topo.php'; ?>
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
                      <li id="abaCriar" class="abaativa">Alterando Newsletter</li>
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='newsletter.php'">Newsletters Cadastrados</li>
                    </ul>
                </td>
            </tr>
            <tr>
            	<td align="left">
                <table width="99%" align="center" cellpadding="0" cellspacing="0">
                <tr><td bgcolor="#FFFFFF">
                <div id="abas">

                    <div id="Criar">
                    	 <fieldset>
                         <?
						$idspam = request("id");
						$sql = "select ds_descricao, ds_conteudo from spam WHERE id_spam = $idspam";
						$st = mysql_query($sql);
			
						  if (mysql_num_rows($st) > 0) {
							 $row = mysql_fetch_row($st);
							 $dsspam   = $row[0];
							 $dscont   = $row[1];
						  }
						?>
                        <form action="adminSpam_alt2.php" method="post">
						<input type="hidden" name="idspam" value="<?php echo $idspam;?>" />
                         <ul class="formularios">
                           <li>
                             <label for="nome_noticia">
                               Descricao:<br />
                               <input class="form02" type="text" id="titulo" name="titulo" value="<?php echo $dsspam; ?>" />
                             </label>
                           </li>
                           <li>
                             <label for="conteudo">
                               Conteudo:<br />
                               <?php
                                $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                $oFCKeditor->ToolbarSet = 'MyToolbar';
                                $oFCKeditor->BasePath = 'fckeditor/' ;
                                $oFCKeditor->Height = 400 ;
                                $oFCKeditor->ForceSimpleAmpersand = false ;
                                $oFCKeditor->Value = $dscont ;
                                $oFCKeditor->Create('conteudo');
                                ?>
                             </label>
                           </li>
                           <li>
                             <input type="submit" id="postar" name="postar" value="Alterar Newsletter" />
                           </li>
                         </ul>
                     </fieldset>
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
<? include 'rodape.php'; ?>
