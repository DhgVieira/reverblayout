<?php
include 'auth.php';
include 'lib.php';
$PHP_SELF = "pacotes.php";

$pagina = request("pagina");

?>
<script type="text/javascript">  

function deleta_pacote(id_pac) {
  var confirma = confirm("Confirma a Exclusao desse Pacote?")
  if ( confirma ){
    document.location.href='deleta_pacote.php?&id_pacote='+id_pac;
  } else {
    return false
  } 
}
</script>
<?php include 'topo.php'; ?>


      <table class="textosjogos" cellpadding="0" cellspacing="0">
          <tr>
              <td height="20" width="130" align="center" class="textostabelas">
                  <ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Pacotes</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
          <tr>
              <td align="left">
                  <ul id="titulos_abas">
                      <li id="abaVer" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Pacotes Cadastrados</li>
                      <!-- <li id="abaCriar" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Cadastrar Pacote</li> -->
                      <li id="abaItens" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Cadastrar Itens de Pacote</li>
                      <li id="abaTipos" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Cadastrar Tipos de Pacote</li>
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

                    <table border="0" cellpadding="0" cellspacing="0" height="30">
                      <tr>
                        <td align="center" width="38">&nbsp;</td>
                        <td align="center" width="160"><strong>Compra</strong></td>
                        <td align="center" width="280"><strong>Nome</strong></td>
                        <td align="center" width="300"><strong>Tipo Pacote</strong></td>
                        <td align="center" width="120"><strong>Remover</strong></td>
                      </tr>
                    </table>
                    <?php
                      $num_por_pagina = 180;
                      if (!$pagina) {
                         $pagina = 1;
                      }
                      $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                  
                      $sql = "SELECT 
                                  idpacote, NR_SEQ_COMPRA_COSO,  DS_NOME_CASO ,tipo_pacote
                              FROM
                                  reverbcity22.pacotes_has_itens
                                      INNER JOIN
                                  itens_pacote ON pacotes_has_itens.iditem_pacote = itens_pacote.iditem_pacote
                                      INNER JOIN
                                  tipos_pacote ON tipos_pacote.idtipo_pacote = pacotes_has_itens.iditem_pacote
                              INNER JOIN pacotes on tipos_pacote.idtipo_pacote = pacotes.idtipo_pacote
                              INNER JOIN compras on compras.NR_SEQ_COMPRA_COSO = pacotes.idcompra
                              INNER JOIN cestas on cestas.NR_SEQ_COMPRA_CESO = compras.NR_SEQ_COMPRA_COSO
                              INNER JOIN cadastros on cadastros.NR_SEQ_CADASTRO_CASO = cestas.NR_SEQ_CADASTRO_CESO
                              GROUP BY compras.NR_SEQ_COMPRA_COSO
                            ";


                      $st = mysql_query($sql);
                      $mostrapag = false;
                      if (mysql_num_rows($st) > 0) {
                        $mostrapag = true;
                      $localant = "";
                        while($row = mysql_fetch_row($st)) {
                       $id_pac      = $row[0];
                       $idcompra    = $row[1];
                       $nome        = $row[2];
                       $tipo_pac    = $row[3];
                      
                      ?>
                      <li>
                            <table border="0" cellpadding="0" cellspacing="0" height="30">
                              <tr>
                                <td align="center" width="38">&nbsp;</td>
                                <td align="center" width="160"><?php echo $idcompra ?></td>
                                <td align="center" width="280"><?php echo $nome ?></td>
                                <td align="center" width="300"><?php echo $tipo_pac ?></td>
                                <td align="center" width="120"><?php echo "<a href=\"#\" title=\"deletar pacote\" onclick=\"deleta_pacote($id_pac);\">"; ?>
                                    <img src="img/cancel.png" width="16" height="16" />
                                  <?php echo "</a>"; ?></td>
                              </tr>
                            </table>
                            </li>
              <?php
              }
              }
             
            ?>
                      </ul>
                        <?php if ($mostrapag) {?>
                        <ul class="paginacao">
                        <?php
                          $consulta = "SELECT COUNT(*) FROM banners, banners_locais WHERE NR_SEQ_BANNER_BARC = NR_SEQ_BANLOCAL_BLRC";
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

<style type="text/css">
  .adicionais{
    border: none;
    width: 600px;
    padding: 5px, 5px;
    display: block;

  }
  .adicionais label{
    width: 120px;
    display: block;

  }
</style>                  
<script type="text/javascript">  

function deleta_tipo(id_tipo) {
  var confirma = confirm("Confirma a Exclusao desse Tipo?")
  if ( confirma ){
    document.location.href='deleta_tipo.php?&id_tipo='+id_tipo;
  } else {
    return false
  } 
}

function deleta_item(id_item) {
  var confirma = confirm("Confirma a Exclusao desse Item?")
  if ( confirma ){
    document.location.href='deleta_item.php?&id_item='+id_item;
  } else {
    return false
  } 
}
  function digamePropriedades(){ 

     

      var indice = document.form1.itens.selectedIndex; 
      
      var produto = document.form1.itens.options[indice].value; 

      var produto_nome = document.form1.itens.options[indice].text;

      var quantidade = document.form1.qtde.value;
    

      var input_produto = '<input type="hidden" name="idproduto[]" id="idproduto[]" value="'+ produto +'"/></br>';  

      var input_produto_nome = '<label>Produto :</label><input type="text" name="produto[]" id="produto[]" value="'+ produto_nome +'" class="campos"/></br>';
   
      var input_qtde = '<label> Quantidade :</label><input type="text" name="quantidade[]" id="quantidade[]" value="'+ quantidade +'" class="campos"/></br>';  

     
      $('#inputs_adicionais').append( input_produto );
      $('#inputs_adicionais').append( input_produto_nome );      
      $('#inputs_adicionais').append( input_qtde );  
  
  
} 
</script>  


                  <!-- Form para cadastrar um pacote -->
                    <!-- <div id="Criar">

                         <form action="pacotes_inc.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
            
                                 <ul class="formularios">
                                   <li>
                                     <label for="tipo">
                                       Tipo do pacote:<br />
                                        <select name="tipo" id="tipo" >
                                          <option>Selecione.. </option>
                                          <?php
                                             $sql = "SELECT idtipo_pacote, tipo_pacote FROM tipos_pacote ORDER BY tipo_pacote ASC";
                                             $st = mysql_query($sql);
                  
                                             if (mysql_num_rows($st) > 0) {
                                              while($row = mysql_fetch_row($st)) {
                                               $id_loc     = $row[0];
                                               $nome_l     = $row[1];
                                              ?>
                                             <option value="<?php echo $id_loc;?>"><?php echo $nome_l;?></option>
                                             <?php
                                               }
                                             }
                                          ?>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                     <label for="item">
                                       Itens do pacote:<br />
                                        <select name="itens" id="itens" >
                                          <option>Selecione.. </option>
                                          <?php
                                             $sql = "SELECT iditem_pacote, descricao_item FROM itens_pacote ORDER BY descricao_item ASC";
                                             $st = mysql_query($sql);
                  
                                             if (mysql_num_rows($st) > 0) {
                                              while($row = mysql_fetch_row($st)) {
                                               $id_loc     = $row[0];
                                               $nome_l     = $row[1];
                                              ?>
                                             <option value="<?php echo $id_loc;?>"><?php echo $nome_l;?></option>
                                             <?php
                                               }
                                             }
                                          ?>
                                        </select>
                                     </label>
                                   </li>
                                   <li>
                                      <label for="quantidade">
                                        Quantidade de itens </br>
                                       </label>
                                        <input type="text" name="qtde" id="qtde" class="form02" /><input type="button" value="Adicionar Item" name="add" id="add" onclick="digamePropriedades()"/>
                                    </li>
                                  <fieldset id="inputs_adicionais" class="adicionais">  
                                  </fieldset>  </br>
                                   
                                   <li>
                                     <input type="submit" id="postar" name="postar" value="Cadastrar Pacote" /> 
                                   </li>
                                 </ul>
   
                         </form>
                    
                    </div>  -->
                    <!-- /criar -->

                    <div id="Itens">
                        <form action="pacotes_itens_inc.php" method="post">
                          <div>
                            <label for="descricao">Descrição:</label>
                            <input type="text" name="descricao" id="descricao" value="" tabindex="1" /></br>
                            <label for="quantidade">Quantidade:</label>
                            <input type="text" name="quantidade" id="quantidade" value="" tabindex="1" />
                          </div>
                         
                          <div>
                            <input type="submit" value="Salvar" />
                          </div>
                        </form>

                        <ul class="noticias">

                          <table border="0" cellpadding="0" cellspacing="0" height="30">
                            <tr>
                              <td align="center" width="38">&nbsp;</td>
                              <td align="center" width="160"><strong>Item</strong></td>
                              <td align="center" width="180"><strong>Quantidade Estoque Restante</strong></td>
                              <td align="center" width="120"><strong>Remover</strong></td>
                            </tr>
                          </table>
                          <?php
                            $num_por_pagina = 180;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                        
                            $sql = "SELECT 
                                        iditem_pacote, descricao_item,  quantidade_estoque
                                    FROM
                                        itens_pacote
                                  ";

                            $st = mysql_query($sql);
                            $mostrapag = false;
                            if (mysql_num_rows($st) > 0) {
                              $mostrapag = true;
                            $localant = "";
                              while($row = mysql_fetch_row($st)) {
                             $id_item      = $row[0];
                             $descricao    = $row[1];
                             $quantidade   = $row[2];
                            
                            ?>
                            <li>
                                  <table border="0" cellpadding="0" cellspacing="0" height="30">
                                    <tr>
                                      <td align="center" width="38">&nbsp;</td>
                                      <td align="center" width="180"><?php echo $descricao ?></td>
                                      <td align="center" width="120"><?php echo $quantidade ?></td>
                                      <td align="center" width="120"><?php echo "<a href=\"#\" title=\"Remover Item\" onclick=\"deleta_item($id_item);\">"; ?>
                                          <img src="img/cancel.png" width="16" height="16" />
                                        <?php echo "</a>"; ?></td>
                                    </tr>
                                  </table>
                                  </li>
                            <?php
                            }
                            }
                   
                         ?>
                      </ul>
        

                    </div> <!-- / Itens -->

                    <div id="Tipos">
                        <form action="pacotes_tipos_inc.php" method="post">
                          <div>
                            <label for="descricao">Descrição:</label>
                            <input type="text" name="descricao" id="descricao" value="" tabindex="1" /></br>
                            <label for="valor">Valor Pacote:</label>
                            <input type="text" name="valor" id="valor" value="" tabindex="1"  />
                          </div>
                         
                          <div>
                            <input type="submit" value="Salvar" />
                          </div>
                        </form>
  
                        <ul class="noticias">

                          <table border="0" cellpadding="0" cellspacing="0" height="30">
                            <tr>
                              <td align="center" width="38">&nbsp;</td>
                              <td align="center" width="300"><strong>Tipo</strong></td>
                              <td align="center" width="180"><strong>Valor Pacote</strong></td>
                              <td align="center" width="120"><strong>Remover</strong></td>
                            </tr>
                          </table>
                          <?php
                            $num_por_pagina = 180;
                            if (!$pagina) {
                               $pagina = 1;
                            }
                            $primeiro_registro = ($pagina*$num_por_pagina) - $num_por_pagina;
                        
                            $sql = "SELECT 
                                        idtipo_pacote, tipo_pacote,  valor_tipo
                                    FROM
                                        tipos_pacote
                                  ";

                            $st = mysql_query($sql);
                            $mostrapag = false;
                            if (mysql_num_rows($st) > 0) {
                              $mostrapag = true;
                            $localant = "";
                              while($row = mysql_fetch_row($st)) {
                             $id_tipo      = $row[0];
                             $tipo         = $row[1];
                             $valor        = $row[2];
                            
                            ?>
                            <li>
                                  <table border="0" cellpadding="0" cellspacing="0" height="30">
                                    <tr>
                                      <td align="center" width="38">&nbsp;</td>
                                      <td align="center" width="300"><?php echo utf8_encode($tipo) ?></td>
                                      <td align="center" width="120"><?php echo $valor ?></td>
                                      <td align="center" width="120"><?php echo "<a href=\"#\" title=\"Remover Item\" onclick=\"deleta_tipo($id_tipo);\">"; ?>
                                          <img src="img/cancel.png" width="16" height="16" />
                                        <?php echo "</a>"; ?></td>
                                    </tr>
                                  </table>
                                  </li>
                            <?php
                            }
                            }
                   
                         ?>
                      </ul>

                    </div> <!-- / tipos -->
          

         
                    <script>
                      defineAba("abaVer","Ver");
                      // defineAba("abaCriar","Criar");
                      defineAba("abaItens","Itens");
                      defineAba("abaTipos","Tipos");
                      defineAba("abaBannerEsp","BannerEspe");
                      <?php
                      if (!$mostrapag && !$aba) $aba = 1;
                      switch($aba){
                          // case 1:
                          //   echo "defineAbaAtiva(\"abaCriar\");";
                          // break;
                        case 2:
                            echo "defineAbaAtiva(\"abaVer\");";
                          break;
                        case 3:
                            echo "defineAbaAtiva(\"abaItens\");";
                          break;
                        case 4:
                            echo "defineAbaAtiva(\"abaTipos\");";
                          break;
                        case 5:
                            echo "defineAbaAtiva(\"abaBannerEsp\");";
                          break;
                        default:
                            echo "defineAbaAtiva(\"abaVer\");";
                          break;
                       }
                      ?>
                    </script>
                
                </div>   <!-- /abas -->
                </td></tr>
                </table>
                <br>
                </td>
            </tr>
        </table> 
<?php
mysql_close($con);
?>



</html>


<?php include 'rodape.php'; ?>