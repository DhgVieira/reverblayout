<?php
include 'auth.php';
include_once("fckeditor/fckeditor.php");
include 'lib.php';
?>
<?php include 'topo.php'; ?>
<script language="javascript">
function AtualizaImagem(){
   if (document.myform.FILE1.value == ""){
	   document.myform.FILE1.focus();
   }else{
		document.imagem_foto.src=document.myform.FILE1.value;
   }
}
</script>
    	<table class="textosjogos" cellpadding="0" cellspacing="0">
        	<tr>
            	<td height="20" align="center" class="textostabelas">
                	<ul id="titulos_abas">
                      <li id="menuDepo" class="abaativa">Produtos</li>
                    </ul>
                </td>
            </tr>
        </table>
        <table class="textostabelas" width="100%" bgcolor="#F7F7F7" cellpadding="0" cellspacing="0">
        	<tr>
            	<td align="left">
                	<ul id="titulos_abas">
                      <li id="abaVer" class="abainativa" onMouseOver="trataMouseAba(this);" onClick="javascript:document.location.href='grupos.php';">Produtos Cadastrados</li>
                      <li id="abaCriar" class="abaativa" onMouseOver="trataMouseAba(this);" onClick="trataCliqueAba(this.id);">Alterando Produto</li>
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
						  $idp = request("idp");
						  $pg = request("pg");
//***** INSERI O DT_CRIACAO_PRRC PARA TRAZER O ANO DA CRIACAO
						  $sql = "SELECT NR_SEQ_LOJAS_PRRC,
    							NR_SEQ_TIPO_PRRC,
    							NR_SEQ_CATEGORIA_PRRC,
    							NR_SEQ_MUSICA_PRRC,
    							DS_REFERENCIA_PRRC,
    							DS_PRODUTO2_PRRC,
    							VL_PRODUTO_PRRC,
    							NR_PESOGRAMAS_PRRC,
    							DS_GARANTIA_PRRC,
    							DS_INFORMACOES_PRRC,
    							TP_DESTAQUE_PRRC,
    							DS_FRETEGRATIS_PRRC,
    							VL_PROMO_PRRC,
    							ST_PRODUTOS_PRRC,
    							DT_CRIACAO_PRRC,
    							DS_IMMEM_PRRC, 
                  VL_PRODUTO2_PRRC, 
                  DS_CATEGORIA_PTRC,
                  NR_CODIGOLOJA_PRRC,
                  DS_TEXTO_PRRC,
                  ST_DESCONTO_LOJA_PRRC,
                  ST_PART_PROMO_PRRC, 
                  DS_NCM_PRRC,
                  DS_GENERO_PRRC,
                  DS_CORES_PRRC,
                  NR_SEQ_MODELO_PRRC,
                  NR_SEQ_COR_PRRC,
                  cor,
                  DS_PRODUTO_PRRC,
                  VL_PROMO_XGL_PRRC,
                  VL_PROMO_M_PRRC
              FROM 
                produtos
              LEFT JOIN 
                produtos_tipo ON NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC
              LEFT JOIN 
                cores ON cores.idcor = produtos.NR_SEQ_COR_PRRC
              WHERE
                NR_SEQ_PRODUTO_PRRC = $idp";
						  $st = mysql_query($sql);

						  if (mysql_num_rows($st) > 0) {
						  	while($row = mysql_fetch_row($st)) {
							 $id_loja	   = $row[0];
							 $id_tipo	   = $row[1];
							 $id_cate	   = $row[2];
							 $id_musi	   = $row[3];
							 $ds_refe	   = $row[4];
							 $ds_prod	   = $row[5];
							 $vl_prod	   = number_format($row[6],2,",","");
							 $nr_peso	   = $row[7];
							 $ds_gara	   = $row[8];
							 $ds_info	   = $row[9];
							 $destaque	   = $row[10];
							 $frete		   = $row[11];
							 $vlrpromo	   = $row[12];
							 $status	   = $row[13];
							 $ano_cria	   = $row[14];
							 $mus_prod	   = $row[15];
							 $vl_prod2	   = number_format($row[16],2,",","");
               $ds_categoria = $row[17];
               $codloc       = $row[18];
               $textodest    = $row[19];
               $descloj      = $row[20]; 
               $partpromo    = $row[21];
               $dsncmprod    = $row[22];
               $genero       = $row[23];
               $cor          = $row[24];
               $modelo       = $row[25];
               $idcor        = $row[26];
               $cor          = $row[27];
               $ds_prod2     = $row[28];
               $vlrpromo_xgl = $row[29];
               $vlrpromo_m   = $row[30];
                             
                             $ds_categoria = str_replace("&","e;",$ds_categoria);
                             $ds_prod_url = str_replace("&","e;",$ds_prod);
                             $linkprod = "/produto/".$ds_categoria."/".urlencode($ds_prod_url);
							}
						  }
						 ?>
                         <form action="grupos_alt2.php" method="post" name="myform" enctype="multipart/form-data">
                         <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                         <input name="pg" type="hidden" value="<?php echo $pg; ?>" />
                         <input name="loja2" type="hidden" value="<?php echo $id_loja; ?>" />
                         <table width="980">
                        	<tr>
                            	<td valign="top">
                                <table cellpadding="3" cellspacing="3">
                                    <tr>
                                        <td>
                                            <label for="loja">
                                            <strong>Loja:</strong><br />
                                            <select name="loja" disabled="disabled">
                                                <option value="0">Todas</option>
                                                <?php
                                                $sql = "select NR_SEQ_LOJA_LJRC, DS_LOJA_LJRC from lojas order by NR_SEQ_LOJA_LJRC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_loj	   = $row[0];
                                                   $ds_loj	   = utf8_encode($row[1]);
                                                ?>
                                                <option value="<?php echo $id_loj; ?>"><?php echo $ds_loj; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                            </select>
                                            </label>
                                        </td>
                                        <td>
                                           <label for="tipo">
                                           <strong>Tipo:</strong><br />
                                           <select name="tipo">
                                                <?php
                                                $sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo order by DS_CATEGORIA_PTRC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_tip	   = $row[0];
                                                   $ds_tip	   = $row[1];
                                                ?>
                                                <option value="<?php echo $id_tip; ?>"><?php echo $ds_tip; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                           </select>
                                           </label>
                                        </td>
                                        <td>
                                           <label for="tipo">
                                           <strong>Categoria:</strong><br />
                                           <select name="categoria">
                                                <?php
                                                $sql = "select NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from produtos_categoria order by DS_CATEGORIA_PCRC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_cat	   = $row[0];
                                                   $ds_cat	   = $row[1];
                                                ?>
                                                <option value="<?php echo $id_cat; ?>"><?php echo $ds_cat; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                           </select>
                                           </label>
                                        </td>
                                        <td>
                                           <label for="tipo">
                                           <strong>M&uacute;sica:</strong><br />
                                           <select name="musica">
                                                <?php
                                                $sql = "select NR_SEQ_MUSICA_MURC, DS_MUSICA_MURC from produtos_musica order by DS_MUSICA_MURC";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_mus	   = $row[0];
                                                   $ds_mus     = $row[1];
                                                ?>
                                                <option value="<?php echo $id_mus; ?>"><?php echo $ds_mus; ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                           </select>
                                           </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <label for="nome">
                                               <strong>Descri&ccedil;&atilde;o Site:</strong><br />
                                               <input class="form02" type="text" name="descricao" style="width:435px;" value="<?php echo utf8_encode($ds_prod2); ?>" />
                                             </label>
                                        </td>
                                        <td>
                                             <label for="valor">
                                               <strong>Valor (R$):</strong><br />
                                                <input class="form00" type="text" name="valor" value="<?php echo $vl_prod; ?>" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td colspan="4">
                                            <label for="nome">
                                               <strong>Descri&ccedil;&atilde;o Admin:</strong><br />
                                               <input class="form02" type="text" name="descricao2" style="width:435px;" value="<?php echo utf8_encode($ds_prod); ?>" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label for="ref">
                                               <strong>Refer&ecirc;ncia:</strong><br />
                                                <input class="form00" type="text" name="ref" style="width:110px;" value="<?php echo $ds_refe; ?>" />
                                             </label>
                                        </td>
                                        <td>
                                             <label for="valor2">
                                               <strong>Valor Custo(R$):</strong><br />
                                                <input class="form00" type="text" name="valor2" value="<?php echo $vl_prod2; ?>" />
                                             </label>
                                        </td>
                                        <td>
                                             <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <label for="Peso">
                                                            <strong>Peso (g):</strong><br />
                                                            <input class="form00" type="text" name="peso" value="<?php echo $nr_peso; ?>" style="width:60px;" />
                                                        </label>
                                                    </td>
                                                    <td>
                                                    <td colspan="2">
                                                        <label for="codloc">
                                                           <strong>C&oacute;digo Sist. Local:</strong><br />
                                                            <input class="form00" type="text" name="codloc" style="width:100px;" value="<?php echo $codloc; ?>" />
                                                        </label>
                                                    </td>
                                                </tr>
                                             </table>
                                        </td>
                                        <td>
                                             <label for="garantia">
                                               <strong>Garantia (meses):</strong><br />
                                               <input class="form00" type="text" name="garantia" value="<?php echo $ds_gara; ?>" />
                                             </label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <label for="img">
                                               <strong>Imagem Inicial:</strong><br />
                                               <input class="form02" type="file" name="FILE1" style="width:435px;height:26px;" onChange="AtualizaImagem();" />
                                             </label>
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td colspan="4">
                                             <label for="img">
                                               <strong>Imagem Medidas:</strong><br />
                                               <input class="form02" type="file" name="FILE2" style="width:435px;height:26px;" />
                                             </label>
                                        </td>
                                    </tr> -->
                                    <tr>
                                        <td height="30">

                                            <strong>Tabela de medidas :</strong> 

                                             <select name="modelo">
                                              <?php
                                                $sql = "SELECT idmodelo, descricao from modelos where idmodelo = $modelo";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_modelo     = $row[0];
                                                   $ds_modelo     = $row[1];
                                                ?>
                                                <option value="<?php echo $id_modelo; ?>"><?php echo utf8_decode($ds_modelo); ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>

                                                <?php
                                                $sql = "SELECT idmodelo, descricao from modelos order by descricao";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $id_modelo     = $row[0];
                                                   $ds_modelo     = $row[1];
                                                ?>
                                                <option value="<?php echo $id_modelo; ?>"><?php echo utf8_decode($ds_modelo); ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                             </select>
                                            <br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" height="300">
                                            <label for="descricao">
                                               Informa&ccedil;&otilde;es:<br />
                                               <?php
                                                $oFCKeditor = new FCKeditor('FCKeditor1') ;
                                                $oFCKeditor->ToolbarSet = 'MyToolbar';
                                                $oFCKeditor->BasePath = 'fckeditor/' ;
                                                $oFCKeditor->Width = 500 ;
                                                $oFCKeditor->Height = 300 ;
                                                $oFCKeditor->ForceSimpleAmpersand = false ;
                                                $oFCKeditor->Value = $ds_info ;
                                                $oFCKeditor->Create('informacoes');
                                                ?>
                                             </label>
                                        </td>
                                    </tr>
                                    <?php $str_tags = "SELECT produto_tag from produtos_tags where idproduto = $idp"; 
                                       $st_tags = mysql_query($str_tags);
                                    ?>

                                    <tr>
                                      <td colspan="5" height="150">
                                        <label for="tags"> <strong>Tags - Separe as tags com  ";"</strong>
                                        <textarea name="tags" width="500px" height="150" rows="5" cols="80">
                                          <?php 

                                           if (mysql_num_rows($st_tags) > 0) {
                                              while($row_tag = mysql_fetch_row($st_tags)) {
                                               $tag    = $row_tag[0];

                                               echo $tag ."; ";
                                              }
                                            }

                                          ?>

                                        </textarea></label>
                                      </td>
                                    </tr>
                                </table>
                        	</td>
                            <td valign="top">
                                <table width="460">
                                    <tr>
                                        <td>
                                            <strong>Tamanhos Quantidade:</strong>
                                        </td>
                                    </tr>
                                    
                                        	<?php
                                            $sql = "select NR_SEQ_TAMANHO_ESRC, NR_QTDE_ESRC from estoque WHERE NR_SEQ_PRODUTO_ESRC = $idp";
											  $st = mysql_query($sql);

											  $chec = false;
                                              $mostratam = false;
                                              $mostranum = false;
                                              $mostranumf = false;
                                              $mostrauni = false;
											  if (mysql_num_rows($st) > 0) {
												while($row = mysql_fetch_row($st)) {
												 switch($row[0]){
												 case 1:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam1 = $row[1];
                                                        $qtdeabert1o = ComprasEmAberto($idp,1);
														break;
													case 2:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam2 = $row[1];
                                                        $qtdeaberto2 = ComprasEmAberto($idp,2);
														break;
													case 3:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam3 = $row[1];
                                                        $qtdeaberto3 = ComprasEmAberto($idp,3);
														break;
													case 4:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam4 = $row[1];
                                                        $qtdeaberto4 = ComprasEmAberto($idp,4);
														break;
													case 5:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam5 = $row[1];
                                                        $qtdeaberto5 = ComprasEmAberto($idp,5);
														break;
													case 6:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam6 = $row[1];
                                                        $qtdeaberto6 = ComprasEmAberto($idp,6);
														break;
													case 7:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam7 = $row[1];
                                                        $qtdeaberto7 = ComprasEmAberto($idp,7);
														break;
													case 8:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam8 = $row[1];
                                                        $qtdeaberto8 = ComprasEmAberto($idp,8);
														break;
													case 9:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam9 = $row[1];
                                                        $qtdeaberto9 = ComprasEmAberto($idp,9);
														break;
													case 10:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam10 = $row[1];
                                                        $qtdeaberto10 = ComprasEmAberto($idp,10);
														break;
                                                    case 33:
                                                        $mostratam = true;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam33 = $row[1];
                                                        $qtdeaberto33 = ComprasEmAberto($idp,33);
														break;
                                                        
													case 11:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = true;
                                                        $mostranumf = false;
														$tam11 = $row[1];
                                                        $qtdeaberto11 = ComprasEmAberto($idp,11);
														$chec = true;
														break;
														
													case 13:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam13 = $row[1];
                                                        $qtdeaberto13 = ComprasEmAberto($idp,13);
														break;
													case 14:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam14 = $row[1];
                                                        $qtdeaberto14 = ComprasEmAberto($idp,14);
														break;
													case 15:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam15 = $row[1];
                                                        $qtdeaberto15 = ComprasEmAberto($idp,15);
														break;
													case 16:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam16 = $row[1];
                                                        $qtdeaberto16 = ComprasEmAberto($idp,16);
														break;
													case 17:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam17 = $row[1];
                                                        $qtdeaberto17 = ComprasEmAberto($idp,17);
														break;
													case 18:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam18 = $row[1];
                                                        $qtdeaberto18 = ComprasEmAberto($idp,18);
														break;
													case 19:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam19 = $row[1];
                                                        $qtdeaberto19 = ComprasEmAberto($idp,19);
														break;
													case 20:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam20 = $row[1];
                                                        $qtdeaberto20 = ComprasEmAberto($idp,20);
														break;
													case 21:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam21 = $row[1];
                                                        $qtdeaberto21 = ComprasEmAberto($idp,21);
														break;
													case 22:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam22 = $row[1];
                                                        $qtdeaberto22 = ComprasEmAberto($idp,22);
														break;
													case 23:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam23 = $row[1];
                                                        $qtdeaberto23 = ComprasEmAberto($idp,23);
														break;
													case 24:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam24 = $row[1];
                                                        $qtdeaberto24 = ComprasEmAberto($idp,24);
														break;
													case 25:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam25 = $row[1];
                                                        $qtdeaberto25 = ComprasEmAberto($idp,25);
														break;
													case 26:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam26 = $row[1];
                                                        $qtdeaberto26 = ComprasEmAberto($idp,26);
														break;
                                                        
                                                    case 27:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam27 = $row[1];
                                                        $qtdeaberto27 = ComprasEmAberto($idp,27);
														break;
                                                    case 28:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam28 = $row[1];
                                                        $qtdeaberto28 = ComprasEmAberto($idp,28);
														break;
                                                    case 29:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam29 = $row[1];
                                                        $qtdeaberto29 = ComprasEmAberto($idp,29);
														break;
                                                    case 30:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam30 = $row[1];
                                                        $qtdeaberto30 = ComprasEmAberto($idp,30);
														break;
                                                    case 31:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam31 = $row[1];
                                                        $qtdeaberto31 = ComprasEmAberto($idp,31);
														break;
                                                    case 32:
                                                        $mostratam = false;
                                                        $mostranum = false;
                                                        $mostrauni = false;
                                                        $mostranumf = true;
														$tam32 = $row[1];
                                                        $qtdeaberto32 = ComprasEmAberto($idp,32);
														break;
                                                    case 34:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam34 = $row[1];
                                                        $qtdeaberto34 = ComprasEmAberto($idp,34);
														break;
                                                    case 35:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam35 = $row[1];
                                                        $qtdeaberto35 = ComprasEmAberto($idp,35);
														break;
                                                    case 36:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam36 = $row[1];
                                                        $qtdeaberto36 = ComprasEmAberto($idp,36);
														break;
                                                    case 37:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam37 = $row[1];
                                                        $qtdeaberto37 = ComprasEmAberto($idp,37);
														break;
                                                    case 38:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam38 = $row[1];
                                                        $qtdeaberto38 = ComprasEmAberto($idp,38);
														break;
                                                    case 39:
                                                       $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam39 = $row[1];
                                                        $qtdeaberto39 = ComprasEmAberto($idp,39);
														break;
                                                    case 40:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam40 = $row[1];
                                                        $qtdeaberto40 = ComprasEmAberto($idp,40);
														break;
                                                    case 41:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam41 = $row[1];
                                                        $qtdeaberto41 = ComprasEmAberto($idp,41);
														break;
                                                    case 42:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam42 = $row[1];
                                                        $qtdeaberto42 = ComprasEmAberto($idp,42);
														break;
                                                    case 43:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam43 = $row[1];
                                                        $qtdeaberto43 = ComprasEmAberto($idp,43);
														break;
                                                    case 44:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam44 = $row[1];
                                                        $qtdeaberto44 = ComprasEmAberto($idp,44);
														break;
                                                    case 45:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam45 = $row[1];
                                                        $qtdeaberto45 = ComprasEmAberto($idp,45);
														break;
                                                    case 46:
                                                        $mostratam = false;
                                                        $mostranum = true;
                                                        $mostrauni = false;
                                                        $mostranumf = false;
														$tam46 = $row[1];
                                                        $qtdeaberto46 = ComprasEmAberto($idp,46);
														break;
													
												 }
												}
											  }
                                    if ($mostratam) {
											?>
                                        <tr>
                                            <td>
                                                <strong>Masculina:</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="PP">
                                                           <strong>PP:</strong><?php if ($qtdeaberto1) echo " (".$qtdeaberto1.")"; ?><br />
                                                           <input class="form00" type="text" name="m_tamPP" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam1; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="P">
                                                           <strong>P:</strong><?php if ($qtdeaberto2) echo " (".$qtdeaberto2.")"; ?><br />
                                                           <input class="form00" type="text" name="m_tamP" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam2; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="M">
                                                           <strong>M:</strong><?php if ($qtdeaberto3) echo " (".$qtdeaberto3.")"; ?><br />
                                                           <input class="form00" type="text" name="m_tamM" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam3; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="G">
                                                           <strong>G:</strong><?php if ($qtdeaberto4) echo " (".$qtdeaberto4.")"; ?><br />
                                                           <input class="form00" type="text" name="m_tamG" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam4; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="GG">
                                                           <strong>GG:</strong><?php if ($qtdeaberto5) echo " (".$qtdeaberto5.")"; ?><br />
                                                           <input class="form00" type="text" name="m_tamGG" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam5; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="XGL">
                                                           <strong>XGL:</strong><?php if ($qtdeaberto33) echo " (".$qtdeaberto33.")"; ?><br />
                                                           <input class="form00" readonly="readonly" type="text" name="m_tamXGL" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam33; ?>" />
                                                         </label>
                                                    </td>   
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Feminina:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="fPP">
                                                           <strong>PP:</strong><?php if ($qtdeaberto6) echo " (".$qtdeaberto6.")"; ?><br />
                                                           <input class="form00" type="text" name="f_tamPP" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam6; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fP">
                                                           <strong>P:</strong><?php if ($qtdeaberto7) echo " (".$qtdeaberto7.")"; ?><br />
                                                           <input class="form00" type="text" name="f_tamP" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam7; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fM">
                                                           <strong>M:</strong><?php if ($qtdeaberto8) echo " (".$qtdeaberto8.")"; ?><br />
                                                           <input class="form00" type="text" name="f_tamM" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam8; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fG">
                                                           <strong>G:</strong><?php if ($qtdeaberto9) echo " (".$qtdeaberto9.")"; ?><br />
                                                           <input class="form00" type="text" name="f_tamG" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam9; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="fGG">
                                                           <strong>GG:</strong><?php if ($qtdeaberto10) echo " (".$qtdeaberto10.")"; ?><br />
                                                           <input class="form00" type="text" name="f_tamGG" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam10; ?>" /> 
                                                         </label>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    if ($mostranum) {
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>Numera&ccedil;&atilde;o:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="15">
                                                           <strong>15:</strong><?php if ($qtdeaberto34) echo " (".$qtdeaberto34.")"; ?><br />
                                                           <input class="form00" type="text" name="tam15" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam34; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="16">
                                                           <strong>16:</strong><?php if ($qtdeaberto35) echo " (".$qtdeaberto35.")"; ?><br />
                                                           <input class="form00" type="text" name="tam16" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam35; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="17">
                                                           <strong>17:</strong><?php if ($qtdeaberto36) echo " (".$qtdeaberto36.")"; ?><br />
                                                           <input class="form00" type="text" name="tam17" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam36; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="18">
                                                           <strong>18:</strong><?php if ($qtdeaberto37) echo " (".$qtdeaberto37.")"; ?><br />
                                                           <input class="form00" type="text" name="tam18" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam37; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="19">
                                                           <strong>19:</strong><?php if ($qtdeaberto38) echo " (".$qtdeaberto38.")"; ?><br />
                                                           <input class="form00" type="text" name="tam19" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam38; ?>" /> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="25">
                                                           <strong>25:</strong><?php if ($qtdeaberto39) echo " (".$qtdeaberto39.")"; ?><br />
                                                           <input class="form00" type="text" name="tam25" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam39; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="26">
                                                           <strong>26:</strong><?php if ($qtdeaberto40) echo " (".$qtdeaberto40.")"; ?><br />
                                                           <input class="form00" type="text" name="tam26" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam40; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="27">
                                                           <strong>27:</strong><?php if ($qtdeaberto41) echo " (".$qtdeaberto41.")"; ?><br />
                                                           <input class="form00" type="text" name="tam27" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam41; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="28">
                                                           <strong>28:</strong><?php if ($qtdeaberto42) echo " (".$qtdeaberto42.")"; ?><br />
                                                           <input class="form00" type="text" name="tam28" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam42; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="29">
                                                           <strong>29:</strong><?php if ($qtdeaberto43) echo " (".$qtdeaberto43.")"; ?><br />
                                                           <input class="form00" type="text" name="tam29" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam43; ?>" /> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="30">
                                                           <strong>30:</strong><?php if ($qtdeaberto44) echo " (".$qtdeaberto44.")"; ?><br />
                                                           <input class="form00" type="text" name="tam30" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam44; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="31">
                                                           <strong>31:</strong><?php if ($qtdeaberto45) echo " (".$qtdeaberto45.")"; ?><br />
                                                           <input class="form00" type="text" name="tam31" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam45; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="32">
                                                           <strong>32:</strong><?php if ($qtdeaberto46) echo " (".$qtdeaberto46.")"; ?><br />
                                                           <input class="form00" type="text" name="tam32" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam46; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="33">
                                                           <strong>33:</strong><?php if ($qtdeaberto13) echo " (".$qtdeaberto13.")"; ?><br />
                                                           <input class="form00" type="text" name="tam33" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam13; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                        <label for="34">
                                                           <strong>34:</strong><?php if ($qtdeaberto14) echo " (".$qtdeaberto14.")"; ?><br />
                                                           <input class="form00" type="text" name="tam34" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam14; ?>" /> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="35">
                                                           <strong>35:</strong><?php if ($qtdeaberto15) echo " (".$qtdeaberto15.")"; ?><br />
                                                           <input class="form00" type="text" name="tam35" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam15; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="36">
                                                           <strong>36:</strong><?php if ($qtdeaberto16) echo " (".$qtdeaberto16.")"; ?><br />
                                                           <input class="form00" type="text" name="tam36" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam16; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="37">
                                                           <strong>37:</strong><?php if ($qtdeaberto17) echo " (".$qtdeaberto17.")"; ?><br />
                                                           <input class="form00" type="text" name="tam37" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam17; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="38">
                                                           <strong>38:</strong><?php if ($qtdeaberto18) echo " (".$qtdeaberto18.")"; ?><br />
                                                           <input class="form00" type="text" name="tam38" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam18; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="39">
                                                           <strong>39:</strong><?php if ($qtdeaberto19) echo " (".$qtdeaberto19.")"; ?><br />
                                                           <input class="form00" type="text" name="tam39" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam19; ?>" /> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="40">
                                                           <strong>40:</strong><?php if ($qtdeaberto20) echo " (".$qtdeaberto20.")"; ?><br />
                                                           <input class="form00" type="text" name="tam40" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam20; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="41">
                                                           <strong>41:</strong><?php if ($qtdeaberto21) echo " (".$qtdeaberto21.")"; ?><br />
                                                           <input class="form00" type="text" name="tam41" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam21; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="42">
                                                           <strong>42:</strong><?php if ($qtdeaberto22) echo " (".$qtdeaberto22.")"; ?><br />
                                                           <input class="form00" type="text" name="tam42" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam22; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="43">
                                                           <strong>43:</strong><?php if ($qtdeaberto23) echo " (".$qtdeaberto23.")"; ?><br />
                                                           <input class="form00" type="text" name="tam43" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam23; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="44">
                                                           <strong>44:</strong><?php if ($qtdeaberto24) echo " (".$qtdeaberto24.")"; ?><br />
                                                           <input class="form00" type="text" name="tam44" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam24; ?>" /> 
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="45">
                                                           <strong>45:</strong><?php if ($qtdeaberto25) echo " (".$qtdeaberto25.")"; ?><br />
                                                           <input class="form00" type="text" name="tam45" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam25; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="46">
                                                           <strong>46:</strong><?php if ($qtdeaberto26) echo " (".$qtdeaberto26.")"; ?><br />
                                                           <input class="form00" type="text" name="tam46" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam26; ?>" /> 
                                                         </label>
                                                    </td>
                                                    <td>
                                                          &nbsp;
                                                    </td>
                                                    <td>
                                                          &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    if ($mostranumf) {
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>Numeração Extendida:</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                         <label for="33-34">
                                                           <strong>33-34:</strong><?php if ($qtdeaberto27) echo " (".$qtdeaberto27.")"; ?><br />
                                                           <input class="form00" readonly="readonly" type="text" name="tam27" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam27; ?>" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="35-36">
                                                           <strong>35-36:</strong><?php if ($qtdeaberto28) echo " (".$qtdeaberto28.")"; ?><br />
                                                           <input class="form00" readonly="readonly" type="text" name="tam28" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam28; ?>" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="37-38">
                                                           <strong>37-38:</strong><?php if ($qtdeaberto29) echo " (".$qtdeaberto29.")"; ?><br />
                                                           <input class="form00" readonly="readonly" type="text" name="tam29" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam29; ?>" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="39-40">
                                                           <strong>39-40:</strong><?php if ($qtdeaberto30) echo " (".$qtdeaberto30.")"; ?><br />
                                                           <input class="form00" readonly="readonly" type="text" name="tam30" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam30; ?>" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         <label for="41-42">
                                                           <strong>41-42:</strong><?php if ($qtdeaberto31) echo " (".$qtdeaberto31.")"; ?><br />
                                                           <input class="form00" readonly="readonly" type="text" name="tam31" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam31; ?>" />
                                                         </label>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                         <label for="43-44">
                                                           <strong>43-44:</strong><?php if ($qtdeaberto32) echo " (".$qtdeaberto32.")"; ?><br />
                                                           <input class="form00" readonly="readonly" type="text" name="tam32" style="width:30px;height:25px;text-align:center;vertical-align:middle;" value="<?php echo $tam32; ?>" />
                                                         </label>
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                    <td>
                                                         &nbsp;
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    if ($mostrauni) {
                                    ?>
                                    <tr>
                                        <td>
                                            <strong>Tamanho &Uacute;nico:</strong><br />
											<input class="form00" type="text" name="tam_unqt" readonly="readonly" style="width:30px;height:20px;text-align:center;vertical-align:middle;" value="<?php echo $tam11; ?>" /> <?php if ($qtdeaberto11) echo "(".$qtdeaberto11.")"; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td>
											<input type="button" id="postar" name="postar" value="Alterar Estoque" onclick="document.location.href='estoque.php?idp=<?php echo $idp ?>'" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Colocar Destaque:</strong> 
                                            <input name="destaque" type="radio" value="0"<?php if ($destaque == 0) echo " checked"; ?> /> N&atilde;o 
                                            <input name="destaque" type="radio" value="1"<?php if ($destaque == 1) echo " checked"; ?> /> New 
                                            <input name="destaque" type="radio" value="2"<?php if ($destaque == 2) echo " checked"; ?> /> Sale 
                                            <input name="destaque" type="radio" value="3"<?php if ($destaque == 3) echo " checked"; ?> /> Reprint
                                            <input name="destaque" type="radio" value="4"<?php if ($destaque == 4) echo " checked"; ?> /> Pr&eacute;-Venda
                                            <input name="destaque" type="radio" value="5"<?php if ($destaque == 5) echo " checked"; ?> /> 50%off
                                            <input name="destaque" type="radio" value="6"<?php if ($destaque == 6) echo " checked"; ?> /> Topo loja
                                            <br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Frete Gr&aacute;tis:</strong> <input name="frete" type="radio" value="N"<?php if ($frete == "N") echo " checked"; ?> /> N&atilde;o <input name="frete" type="radio" value="S"<?php if ($frete == "S") echo " checked"; ?> /> Sim<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Valor Promocional (R$):</strong> <input class="form00" type="text" name="vlrpromo" style="width:60px;" value="<?php echo number_format($vlrpromo,2,",",""); ?>" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="30">
                                            <strong>Valor Promocional para XGL (R$):</strong> <input class="form00" type="text" name="vlrpromo_xgl" style="width:60px;" value="<?php echo number_format($vlrpromo_xgl,2,",",""); ?>" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="30">
                                            <strong>Valor Promocional para M (R$):</strong> <input class="form00" type="text" name="vlrpromo_m" style="width:60px;" value="<?php echo number_format($vlrpromo_m,2,",",""); ?>" />
                                        </td>
                                    </tr>

                                    <tr>
                                        <td height="30">
                                            <strong>Status do Produto:</strong> 
                                            <select name="status" class="form00" style="width:80px;height:23px;">
                                            	<option value="A"<?php if ($status == "A") echo " selected";?>>Ativo</option>
                                                <option value="I"<?php if ($status == "I") echo " selected";?>>Inativo</option>
                                                <option value="P"<?php if ($status == "P") echo " selected";?>>Pre-Venda</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td height="30">
                                        	<strong> Ano da CriaÃ§Ã£o:</strong>
                                            <input type="text" name="anocriacao" class="form00" value="<?php echo $ano_cria; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td >
                                        	<strong> MÃºsica do Produto (youtube):</strong><br />&nbsp;&nbsp;&nbsp;Ex: http://www.youtube.com/watch?v=XXUCFk8VJFY
                                            <input type="text" name="musicprod" class="form00" style="width:280px" value="<?php echo $mus_prod; ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                    	<td height="30">
                                        	<strong> Texto de Destaque:</strong>
                                            <input type="text" name="textodestaq" class="form00" style="width:150px" maxlength="50" value="<?php echo $textodest; ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Aplicar Desconto p/ Lojistas?</strong> <input name="descloj" type="radio" value="S"<?php if ($descloj=="S") echo " checked=\"checked\"";?> /> Sim <input name="descloj" type="radio" value="N"<?php if ($descloj=="N") echo " checked=\"checked\"";?> /> N&atilde;o<br />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">
                                            <strong>Participante das Promo&ccedil;&otilde;es?</strong> <input name="partpromo" type="radio" value="S"<?php if ($partpromo=="S") echo " checked=\"checked\"";?> /> Sim <input name="partpromo" type="radio" value="N"<?php if ($partpromo=="N") echo " checked=\"checked\"";?> /> N&atilde;o
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Caso seja especificado <strong>N&atilde;o</strong>, este produto n&atilde;o entra como free nas promos.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="40">
                                        	<strong>NCM Espec&iacute;fico do Produto:</strong> 
                                            <input type="text" name="ncmprod" style="width:150px" class="form00" value="<?php echo $dsncmprod; ?>" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30">

                                            <strong>Genero :</strong> 
                                            <input name="genero" type="radio" value="M"<?php if ($genero == 'M') echo " checked"; ?> /> Masculino 
                                            <input name="genero" type="radio" value="F"<?php if ($genero == 'F') echo " checked"; ?> /> Feminino 
                                           
                                            <br />
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <td height="30">

                                            <strong>Cor :</strong> 
                                            <input name="cores_old" type="radio" value="1"<?php if ($cor == 1) echo " checked"; ?> /> Preto 
                                            <input name="cores_old" type="radio" value="2"<?php if ($cor == 2) echo " checked"; ?> /> Cinza
                                            <input name="cores_old" type="radio" value="3"<?php if ($cor == 3) echo " checked"; ?> /> Branco 
                                            <input name="cores_old" type="radio" value="4"<?php if ($cor == 4) echo " checked"; ?> /> Vermelho 
                                            <input name="cores_old" type="radio" value="5"<?php if ($cor == 5) echo " checked"; ?> /> Amarelo 
                                            <input name="cores_old" type="radio" value="6"<?php if ($cor == 6) echo " checked"; ?> /> Verde
                                            <input name="cores_old" type="radio" value="7"<?php if ($cor == 7) echo " checked"; ?> /> Azul 
                                            <input name="cores_old" type="radio" value="8"<?php if ($cor == 8) echo " checked"; ?> /> Marrom
                                            <input name="cores_old" type="radio" value="9"<?php if ($cor == 9) echo " checked"; ?> /> Roxo 
                                            <input name="cores_old" type="radio" value="10"<?php if ($cor == 10) echo " checked"; ?> /> Laranja
                                            <input name="cores_old" type="radio" value="11"<?php if ($cor == 11) echo " checked"; ?> /> Creme 
                                            <input name="cores_old" type="radio" value="12"<?php if ($cor == 12) echo " checked"; ?> /> Rosa 
                                           
                                           
                                            <br />
                                        </td>
                                    </tr> -->

                                    <tr>
                                        <td height="30">

                                           <strong>Cor:</strong> 
                                          <select name="cores" class="form00" style="width:80px;height:23px;">
                                      
                                          <option value="<?php echo $idcor?>"><?php echo $cor?></option>
                                          <?php
                                            $sql = "SELECT idcor, cor from cores order by cor";
                                                $st = mysql_query($sql);
                    
                                                if (mysql_num_rows($st) > 0) {
                                                  while($row = mysql_fetch_row($st)) {
                                                   $idcor     = $row[0];
                                                   $cor     = $row[1];
                                                ?>
                                                <option value="<?php echo $idcor; ?>"><?php echo utf8_decode($cor); ?></option>
                                                <?php
                                                  }
                                                }
                                                ?>
                                             </select>
                                           
                                           
                                            <br />
                                        </td>
                                    </tr>
                                    
                                    <tr><td height="55"><input type="submit" id="postar" name="postar" value="Alterar Produto" /></td></tr>
                                    <tr><td>http://www.reverbcity.com<?php echo $linkprod ?></td></tr>
                                </table>
								<img src="img/x.gif" name="imagem_foto" border="0">
                            </td>
                            </tr>
                        </table>
                         </form>
                    	<script language="JavaScript">
						   document.myform.tipo.value = "<?php echo $id_tipo; ?>";
						   document.myform.loja.value = "<?php echo $id_loja; ?>";
						   document.myform.categoria.value = "<?php echo $id_cate; ?>";
						   document.myform.musica.value = "<?php echo $id_musi; ?>";
						</script>
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
<?php include 'rodape.php'; ?>
<?php
function ComprasEmAberto($prod, $taman){
	$sqlmin = "SELECT sum(NR_QTDE_CESO) FROM compras, cestas WHERE NR_SEQ_COMPRA_COSO = NR_SEQ_COMPRA_CESO and
               NR_SEQ_PRODUTO_CESO = $prod and NR_SEQ_TAMANHO_CESO = $taman and ST_COMPRA_COSO = 'A'";
	$stmin = mysql_query($sqlmin);
	$retqtde = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retqtde = $rowmin[0];
	}
	return $retqtde;
}
mysql_close($con);?>