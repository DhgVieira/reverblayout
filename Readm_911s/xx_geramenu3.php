<?php
include 'lib.php';

if (file_exists('../includes/menu_shop_bla.php')) unlink('../includes/menu_shop_bla.php');

$fp = fopen('../includes/menu_shop_bla.php', 'w');
fwrite($fp, '<?php ');
fwrite($fp, '$altura = 600; ');
fwrite($fp, '$str_menu = ""; ');

fwrite($fp, '$tipocad = (isset($_SESSION["huvcbw892b"])) ? $_SESSION["huvcbw892b"] : ""; ');
fwrite($fp, 'if ($tipocad == 1){ ');
fwrite($fp, '    $str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/lojista.php\">Atacado</a></li>\n"; ');
fwrite($fp, '    $str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');
fwrite($fp, '}else{ ');
fwrite($fp, '    $str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/login_atacado.php\">Atacado</a></li>\n"; ');
fwrite($fp, '    $str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');
fwrite($fp, '} ');

fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2.php?tip=6&cat=179\" style=\"color: #EF5726;\">Cole&ccedil;&atilde;o Basic Ver&atilde;o</a></li>\n"; ');
fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');
fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2.php?cat=178\">Cole&ccedil;&atilde;o de S&eacute;ries</a></li>\n"; ');
fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');
fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/collection.php\">Cole&ccedil;&atilde;o Podrinhas</a></li>\n"; ');
fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');
fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/classics/classics_avise.php\">Avise-me</a></li>\n"; ');
fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');

$sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo where NR_SEQ_CATEGPRO_PTRC <> 9 AND NR_SEQ_CATEGPRO_PTRC IN
		(select NR_SEQ_TIPO_PRRC from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_LOJAS_PRRC = 1 
		 AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A' and TP_DESTAQUE_PRRC = 1)";

$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
    
    fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2_new.php\" style=\"color: #fbcbc4;\">Novas Cole&ccedil;&otilde;es</a>\n"; ');
    fwrite($fp, '$str_menu .= "		<ul>\n"; ');

  while($row = mysql_fetch_row($st)) {
   $id_tipo	   = $row[0];
   $ds_tipo	   = $row[1];
   
   $sql2 = "select distinct NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from produtos, produtos_categoria, estoque
			WHERE NR_SEQ_CATEGORIA_PRRC =  NR_SEQ_CATEGPRO_PCRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TIPO_PRRC = $id_tipo and TP_DESTAQUE_PRRC = 1
			AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A' AND NR_SEQ_LOJAS_PRRC = 1 GROUP BY NR_SEQ_CATEGPRO_PCRC";
   $st2 = mysql_query($sql2);
   if (mysql_num_rows($st2) > 0) {
	    if ($id_tipo == $tip){
			fwrite($fp, '$str_menu .= "<li><a href=\"http://www.reverbcity.com/shop/produtos2_new.php?tip='.$id_tipo.'\" style=\"background:#ebeca8;\">'.$ds_tipo.'</a>\n"; ');
		}else{
		    fwrite($fp, '$str_menu .= "<li><a href=\"http://www.reverbcity.com/shop/produtos2_new.php?tip='.$id_tipo.'\">'.$ds_tipo.'</a>\n"; ');
		}
		fwrite($fp, '$str_menu .= "		<ul>\n"; ');
		while($row2 = mysql_fetch_row($st2)) {
			$id_tipo2	   = $row2[0];
   			$ds_tipo2	   = $row2[1];
			
			$sql3 = "select distinct NR_SEQ_TAMANHO_TARC, DS_TAMANHO_TARC from produtos, estoque, tamanhos
			WHERE NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_ESRC and NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
			and NR_SEQ_TIPO_PRRC = $id_tipo and NR_SEQ_CATEGORIA_PRRC = $id_tipo2 and NR_SEQ_TAMANHO_TARC <> 11
			and NR_QTDE_ESRC > 0 AND NR_SEQ_LOJAS_PRRC = 1 AND DS_CLASSIC_PRRC = 'N' AND ST_PRODUTOS_PRRC = 'A' AND TP_DESTAQUE_PRRC = 1 GROUP BY NR_SEQ_TAMANHO_TARC";
            
			$st3 = mysql_query($sql3);
			if (mysql_num_rows($st3) > 0) {
				fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2_new.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'\">'.$ds_tipo2.'</a>\n"; ');
				fwrite($fp, '$str_menu .= "		<ul>\n"; ');
				while($row3 = mysql_fetch_row($st3)) {
					$id_tipo3	   = $row3[0];
					$ds_tipo3	   = $row3[1];
					fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2_new.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'&amp;tam='.$id_tipo3.'\" class=\"fonte\">'.$ds_tipo3.'</a></li>\n"; ');
				}
				
				fwrite($fp, '$str_menu .= "		</ul>\n"; ');
				fwrite($fp, '$str_menu .= "</li>\n"; ');
			}else{
				fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2_new.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'\" class=\"fonte\">'.$ds_tipo2.'</a></li>\n"; ');
			}
		}
		fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2_new.php?tip='.$id_tipo.'\" class=\"fonte\">ALL</a></li>\n"; ');
		fwrite($fp, '$str_menu .= "		</ul>\n"; ');
        fwrite($fp, '$str_menu .= "</li>\n"; ');
   }else{
	    fwrite($fp, '$str_menu .= "<li><a href=\"http://www.reverbcity.com/shop/produtos2_new.php?tip='.$id_tipo.'\">'.$ds_tipo.'</a></li>\n"; ');
   }
   //$str_menu .= "<li><img src="/images/sp_mn_divisor.gif" width="179" height="4" /></li>\n";
      
  }
     fwrite($fp, '$str_menu .= "		</ul>\n"; ');
  fwrite($fp, '$str_menu .= "</li>\n"; ');
  fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');

  
}


fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2_sale.php\" style=\"color: #EF5726;\">Liquida&ccedil;&atilde;o/SALE</a>\n"; ');
fwrite($fp, '$str_menu .= "		<ul>\n"; ');

$sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo where NR_SEQ_CATEGPRO_PTRC <> 9 AND NR_SEQ_CATEGPRO_PTRC IN
		(select NR_SEQ_TIPO_PRRC from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_LOJAS_PRRC = 1 
		 AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A' and TP_DESTAQUE_PRRC = 2 ";
         
//tirando as pecas em sale diferentes de camisetas se nao for lojista:
//if ($tipocad <> 1) $sql .= "and NR_SEQ_TIPO_PRRC > if(TP_DESTAQUE_PRRC = 2, if(NR_SEQ_TIPO_PRRC = 6, 0, 200), 0) ";
         
$sql .= ")";

$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_tipo	   = $row[0];
   $ds_tipo	   = $row[1];
   
   $sql2 = "select distinct NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from produtos, produtos_categoria, estoque 
			WHERE NR_SEQ_CATEGORIA_PRRC =  NR_SEQ_CATEGPRO_PCRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_TIPO_PRRC = $id_tipo and TP_DESTAQUE_PRRC = 2
			AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A' AND NR_SEQ_LOJAS_PRRC = 1 ";
   //tirando as pecas em sale diferentes de camisetas se nao for lojista:
   //if ($tipocad <> 1) $sql2 .= "and NR_SEQ_TIPO_PRRC > if(TP_DESTAQUE_PRRC = 2, if(NR_SEQ_TIPO_PRRC = 6, 0, 200), 0) ";

   $sql2 .= "GROUP BY NR_SEQ_CATEGPRO_PCRC";
   
   $st2 = mysql_query($sql2);
   if (mysql_num_rows($st2) > 0) {
	    if ($id_tipo == $tip){
			fwrite($fp, '$str_menu .= "<li><a href=\"http://www.reverbcity.com/shop/produtos2_sale.php?tip='.$id_tipo.'\" style=\"background:#ebeca8;\">'.$ds_tipo.'</a>\n"; ');
		}else{
		    fwrite($fp, '$str_menu .= "<li><a href=\"http://www.reverbcity.com/shop/produtos2_sale.php?tip='.$id_tipo.'\">'.$ds_tipo.'</a>\n"; ');
		}
		fwrite($fp, '$str_menu .= "		<ul>\n"; ');
		while($row2 = mysql_fetch_row($st2)) {
			$id_tipo2	   = $row2[0];
   			$ds_tipo2	   = $row2[1];
			
			$sql3 = "select distinct NR_SEQ_TAMANHO_TARC, DS_TAMANHO_TARC from produtos, estoque, tamanhos
			WHERE NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_ESRC and NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
			and NR_SEQ_TIPO_PRRC = $id_tipo and NR_SEQ_CATEGORIA_PRRC = $id_tipo2 and NR_SEQ_TAMANHO_TARC <> 11
			and NR_QTDE_ESRC > 0 and  TP_DESTAQUE_PRRC = 2 AND DS_CLASSIC_PRRC = 'N' AND NR_SEQ_LOJAS_PRRC = 1 AND ST_PRODUTOS_PRRC = 'A' "; 
            
            //tirando as pecas em sale diferentes de camisetas se nao for lojista:
            //if ($tipocad <> 1) $sql3 .= "and NR_SEQ_TIPO_PRRC > if(TP_DESTAQUE_PRRC = 2, if(NR_SEQ_TIPO_PRRC = 6, 0, 200), 0) ";
            
            $sql3 .= "GROUP BY NR_SEQ_TAMANHO_TARC";
            
			$st3 = mysql_query($sql3);
			if (mysql_num_rows($st3) > 0) {
				fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2_sale.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'\">'.$ds_tipo2.'</a>\n"; ');
				fwrite($fp, '$str_menu .= "		<ul>\n"; ');
				while($row3 = mysql_fetch_row($st3)) {
					$id_tipo3	   = $row3[0];
					$ds_tipo3	   = $row3[1];
					fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2_sale.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'&amp;tam='.$id_tipo3.'\" class=\"fonte\">'.$ds_tipo3.'</a></li>\n"; ');
				}
				
				fwrite($fp, '$str_menu .= "		</ul>\n"; ');
				fwrite($fp, '$str_menu .= "</li>\n"; ');
			}else{
				fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2_sale.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'\" class=\"fonte\">'.$ds_tipo2.'</a></li>\n"; ');
			}
		}
		fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2_sale.php?tip='.$id_tipo.'\" class=\"fonte\">ALL</a></li>\n"; ');
		fwrite($fp, '$str_menu .= "		</ul>\n"; ');
        fwrite($fp, '$str_menu .= "</li>\n"; ');
   }else{
	    fwrite($fp, '$str_menu .= "<li><a href=\"http://www.reverbcity.com/shop/produtos2_sale.php?tip='.$id_tipo.'\">'.$ds_tipo.'</a></li>\n"; ');
   }
  // $str_menu .= "<li><img src="/images/sp_mn_divisor.gif" width="179" height="4" /></li>\n";
  }
  fwrite($fp, '$str_menu .= "		</ul>\n"; ');
  fwrite($fp, '$str_menu .= "</li>\n"; ');
  fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');
}

//fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2_busca.php?ch=reprint\" style=\"color: #66c19d;\">Estampas Re-editadas</a></li>\n"; ');
//fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');

//$str_menu .= "<li><a class="fly" href="http://www.reverbcity.com/shop/produtos_bside.php">B-Side</a>\n";
//$str_menu .= "<li><img src="/images/sp_mn_divisor.gif" width="179" height="4" /></li>\n";

$sql = "select NR_SEQ_CATEGPRO_PTRC, DS_CATEGORIA_PTRC from produtos_tipo where NR_SEQ_CATEGPRO_PTRC <> 9 AND NR_SEQ_CATEGPRO_PTRC IN
		(select NR_SEQ_TIPO_PRRC from produtos, estoque WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC AND NR_SEQ_LOJAS_PRRC = 1 
		 AND DS_CLASSIC_PRRC = 'N' AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A'";

//tirando as pecas em sale diferentes de camisetas se nao for lojista:
//if ($tipocad <> 1) $sql .= "and NR_SEQ_TIPO_PRRC > if(TP_DESTAQUE_PRRC = 2, if(NR_SEQ_TIPO_PRRC = 6, 0, 200), 0) ";
$sql .= ") ORDER BY DS_CATEGORIA_PTRC";

$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
  while($row = mysql_fetch_row($st)) {
   $id_tipo	   = $row[0];
   $ds_tipo	   = $row[1];
   
   $sql2 = "select distinct NR_SEQ_CATEGPRO_PCRC, DS_CATEGORIA_PCRC from produtos, produtos_categoria, estoque
			WHERE NR_SEQ_CATEGORIA_PRRC =  NR_SEQ_CATEGPRO_PCRC and NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC 
            and NR_SEQ_TIPO_PRRC = $id_tipo AND NR_QTDE_ESRC > 0 AND ST_PRODUTOS_PRRC = 'A' and NR_SEQ_LOJAS_PRRC = 1 
            AND DS_CLASSIC_PRRC = 'N' ";
   
   //tirando as pecas em sale diferentes de camisetas se nao for lojista:
   //if ($tipocad <> 1) $sql2 .= "and NR_SEQ_TIPO_PRRC > if(TP_DESTAQUE_PRRC = 2, if(NR_SEQ_TIPO_PRRC = 6, 0, 200), 0) ";

   $sql2 .= "GROUP BY NR_SEQ_CATEGPRO_PCRC";
   
   $st2 = mysql_query($sql2);
   if (mysql_num_rows($st2) > 0) {
	    if ($id_tipo == $tip){
			fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2.php?tip='.$id_tipo.'\" style=\"background:#ebeca8;\">'.$ds_tipo.'</a>\n"; ');
		}else{
		    fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2.php?tip='.$id_tipo.'\">'.$ds_tipo.'</a>\n"; ');
		}
		fwrite($fp, '$str_menu .= "		<ul>\n"; ');
		while($row2 = mysql_fetch_row($st2)) {
			$id_tipo2	   = $row2[0];
   			$ds_tipo2	   = $row2[1];
			
			$sql3 = "select distinct NR_SEQ_TAMANHO_TARC, DS_TAMANHO_TARC from produtos, estoque, tamanhos
			WHERE NR_SEQ_PRODUTO_PRRC =  NR_SEQ_PRODUTO_ESRC and NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC
			and NR_SEQ_TIPO_PRRC = $id_tipo and NR_SEQ_CATEGORIA_PRRC = $id_tipo2 and NR_SEQ_TAMANHO_TARC <> 11
			and NR_QTDE_ESRC > 0 AND DS_CLASSIC_PRRC = 'N' and ST_PRODUTOS_PRRC = 'A' and NR_SEQ_LOJAS_PRRC = 1 "; 
            
            //tirando as pecas em sale diferentes de camisetas se nao for lojista:
            //if ($tipocad <> 1) $sql3 .= "and NR_SEQ_TIPO_PRRC > if(TP_DESTAQUE_PRRC = 2, if(NR_SEQ_TIPO_PRRC = 6, 0, 200), 0) ";
   
            $sql3 .= "GROUP BY NR_SEQ_TAMANHO_TARC";
            
			$st3 = mysql_query($sql3);
			if (mysql_num_rows($st3) > 0) {
				fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'\">'.$ds_tipo2.'</a>\n"; ');
				fwrite($fp, '$str_menu .= "		<ul>\n"; ');
				while($row3 = mysql_fetch_row($st3)) {
					$id_tipo3	   = $row3[0];
					$ds_tipo3	   = $row3[1];
					fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'&amp;tam='.$id_tipo3.'\" class=\"fonte\">'.$ds_tipo3.'</a></li>\n"; ');
				}
				
				fwrite($fp, '$str_menu .= "		</ul>\n"; ');
				fwrite($fp, '$str_menu .= "</li>\n"; ');
			}else{
				fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2.php?tip='.$id_tipo.'&amp;cat='.$id_tipo2.'\" class=\"fonte\">'.$ds_tipo2.'</a></li>\n"; ');
			}
		}
		fwrite($fp, '$str_menu .= "			<li><a href=\"http://www.reverbcity.com/shop/produtos2.php?tip='.$id_tipo.'\" class=\"fonte\">ALL</a></li>\n"; ');
		fwrite($fp, '$str_menu .= "		</ul>\n"; ');
        fwrite($fp, '$str_menu .= "</li>\n"; ');
   }else{
	    fwrite($fp, '$str_menu .= "<li><a href=\"http://www.reverbcity.com/shop/produtos2.php?tip='.$id_tipo.'\">'.$ds_tipo.'</a></li>\n"; ');
   }
   fwrite($fp, '$str_menu .= "<li><img src=\"/images/sp_mn_divisor.gif\" width=\"179\" height=\"4\" /></li>\n"; ');
  }
}

fwrite($fp, '$str_menu .= "<li><a class=\"fly\" href=\"http://www.reverbcity.com/shop/produtos2_all.php\">Tudo/ALL</a>\n"; ');
fwrite($fp, '?> ');
fclose($fp);

mysql_close($con);
?>