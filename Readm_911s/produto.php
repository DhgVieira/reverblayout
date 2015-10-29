<?php
include 'auth.php';
$url = "http://". $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
include 'lib.php';

$SS_posicao = session_id();
$SS_nomepg = "shop";

$frete = @$HTTP_COOKIE_VARS["jh72iu2fhd"];
if (!$frete) {
	$vlrfrete = "0,00";
}else{
	$vlrfrete = $frete;
}
$_SESSION["SS_posicao"] = $SS_nomepg;

include '../includes/menu_shop.php';

$idp = request("idp");

$blabla = "";

$pgret = request("r");
$ver = 0 ;

$musicprod = "";

$sql = "select NR_SEQ_PRODUTO_PRRC, DS_EXTTAM_PRRC, DS_PRODUTO2_PRRC, DS_INFORMACOES_PRRC, VL_PRODUTO_PRRC, 
        NR_SEQ_TIPO_PRRC, VL_PROMO_PRRC, NR_SEQ_CATEGORIA_PRRC, NR_SEQ_MUSICA_PRRC, DS_IMMEM_PRRC, DS_CATEGORIA_PTRC,
        NR_LINKPROD_PRRC, TP_DESTAQUE_PRRC
		from produtos, produtos_tipo WHERE NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC AND
		NR_SEQ_PRODUTO_PRRC = $idp";            
$st = mysql_query($sql);
if (mysql_num_rows($st) > 0) {
	$row = mysql_fetch_row($st);
	$id_prod	   = $row[0];
	$ex_tama	   = $row[1];
	$ds_desc	   = $row[2];
	$ds_info	   = $row[3];
	$vl_prod	   = Valor_Produto($row[0],$SS_logado);
	$tipo		   = $row[5];
	$vlrpromo	   = $row[6];
	$nr_cate	   = $row[7];
	$nr_musi 	   = $row[8];
	$musicprod	   = $row[9];
	$categprod	   = $row[10];
    $idplink       = $row[11];
    $tpdestaq      = $row[12];
}else{
	Header("Location: /shop/shop.php");
	exit();
}
if (!$pgret) $pgret = "shop.php";

$imgtamanho = "";

$vlordesc = "";
if ($vlrpromo > 0) {
	$vlordesc = " por apenas R$ ".number_format($vlrpromo,2,",","");
}else{
	$vlordesc = "";
}

$urlface = "www.facebook.com/sharer.php?u=$url&t=$ds_desc na reverbcity.com";
$urltwit = "twitter.com/home?status=$categprod $ds_desc".$vlordesc." na @reverbcity ".str_replace("http://www.","http://",$url);
if (file_exists("../images/tamanhos/$id_prod.$ex_tama")) $imgtamanho = "<img src=\"/images/tamanhos/$id_prod.$ex_tama\" style=\"float:left;\"/>";

$sql = "SELECT NR_SEQ_FOTO_FORC, DS_EXT_FORC, DS_LEGENDA_FORC, ZOOM_FORC FROM fotos WHERE NR_SEQ_PRODUTO_FORC = $idp order by NR_ORDEM_FORC, NR_SEQ_FOTO_FORC";
$st = mysql_query($sql);
$fot1 = "";
$str_fotos = "";
$xx = 0;
$fotorku = "";
if (mysql_num_rows($st) > 0) {
	while($row = mysql_fetch_row($st)) {
		$idfoto = $row[0];
		$extens = $row[1];
		$dslege = $row[2];
		$zoom = $row[3];
		
		if (!$fot1 && $fotorku == "") {
			$fot1 = $idfoto . "." . $extens;
			$fotorku = $idfoto . "." . $extens;
			if ($zoom == 1) {
				$fot2 = $idfoto . "." . $extens;
				$ver = 1;
			}
			$legenda_ini = $dslege;
		}
		if (!$dslege) $dslege = " ";
		$str_fotos .= "<a href=\"#\" onclick=\"AtualizaImagem($idfoto,'$extens','$dslege'); return false;\"><img src=\"/arquivos/uploads/produtos/".$idfoto.".$extens\" border=\"0\" hspace=\"10\" /></a>";
		$xx++;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Reverbcity Shop - <?php echo $categprod ?> <?php echo $ds_desc ?>"/>
<meta property="og:type" content="product"/>
<meta property="og:url" content="<?php echo $url ?>"/>
<meta property="og:image" content="http://www.reverbcity.com/arquivos/uploads/produtos/<?php echo $fotorku ?>"/>
<meta property="og:site_name" content="Reverbcity"/>
<meta property="fb:admins" content="reverbcity"/>
<meta name="description" content="<?php echo $categprod ?> <?php echo $ds_desc ?><?php echo $vlordesc ?> na reverbcity.com" />
<title>Reverbcity Shop - <?php echo $categprod ?> <?php echo $ds_desc ?></title>
<link href="/css/geral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/scripts/jquery.js"></script>

<!-- //***** PARA O ZOOM FUNCIONAR 
<script type="text/JavaScript" charset="ISO-8859-1" src="/shop/library.js"></script>
<link href="/shop/Vertico.css" type="text/css" rel="stylesheet">
<link href="/shop/vertismagnify.css" type="text/css" rel="stylesheet">
 //***** PARA O ZOOM FUNCIONAR FIM -->

<script language="javascript">
	function AtualizaImagem(idfot, ext, txt){
	document.fotoprod.src= '../arquivos/uploads/produtos/'+idfot+'.'+ext;
	document.getElementById('textleg').innerHTML = txt;
	}
</script>

<script type="text/javascript" src="/scripts/qTip.js"></script>
<link href="/css/shopmenu.css" rel="stylesheet" type="text/css" />
<link href="/css/shop_new.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body>
<?php
$urlorkut = "promote.orkut.com/preview?nt=orkut.com&tt=".urlencode($categprod)."+'".urlencode($ds_desc)."'&tn=".urlencode("http://www.reverbcity.com/arquivos/uploads/produtos/").urlencode($fotorku)."&du=".urlencode($url)."&cn=".urlencode($categprod).urlencode(" na reverbcity.com");

$alt_menu = 480;
if ($xx >= 6) $alt_menu = 580;
?>
    <table align="center" cellpadding="0" cellspacing="0">
    	<tr>
            <td>
      			<?php include '../includes/topo.html'; ?>
            </td>
        </tr>
        <tr><td bgcolor="#f0e7dc">&nbsp;</td></tr>
        <tr>
        	<td bgcolor="#f0e7dc">
            	
                <table>
                	<tr>
                    	<td valign="top">
                        
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="200" align="center" valign="top">
                                    <?php if ($tpdestaq == 4){ 
                                    
                                    $sql2 = "select sum(NR_QTDE_CESO) from cestas, compras where
                                             NR_SEQ_COMPRA_CESO = NR_SEQ_COMPRA_COSO and ST_COMPRA_COSO <> 'C' and
                                             NR_SEQ_PRODUTO_CESO = $id_prod and DT_COMPRA_COSO > '2013-05-20 00:00:00'";
                                    $st2 = mysql_query($sql2); 
                                    if (mysql_num_rows($st2) > 0) {
                                        $row2 = mysql_fetch_row($st2);
                                        $total = $row2[0];
                                    }
                                    if ($total > 50){
                                        $corpre = "67ff87";
                                    }else{
                                        $corpre = "EF4A03";
                                    }
                                    ?>
                                    <div style="width: 183px;">
                                        <p style="color: #7a6347;"><strong>Compras Realizadas:</strong></p>
                                        <p style="font-size: 40px; color: #<?php echo $corpre; ?>"><strong><?php echo str_pad($total,2,"0",STR_PAD_LEFT);?></strong></p>
                                        <p style="color: #7a6347;"><strong>Qtde.M&iacute;nima: 50 unidades</strong></p>
                                    </div>
                                    <?php } ?>
                                    <div id="index-menu">
                                    <table width="183" cellpadding="0" cellspacing="0" align="center">
                                        <tr><td><?php include '../includes/emcimamenu.php'; ?></td></tr>
                                        <tr>
                                            <td><a href="/shop/shop.php"><img src="/images/sp_mn_topo.gif" width="183" height="37" border="0" /></a></td>
                                        </tr>
                                        <tr>
                                            <td height="<?php echo $altura ?>" valign="top" bgcolor="#5a4d3d">
                                            <div id="menu">
                                                <ul id="toplevel">
                                                    <?php echo $str_menu ?>
                                                </ul>
                                            </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><img src="/images/sp_mn_rodape2.gif" width="183" height="36" /></td>
                                        </tr>
                                        <tr>
                                            <td background="/images/sp_mn_fundo_cabos.gif" height="<?php echo $alt_menu ?>">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td><img src="/images/sp_mn_rodape_cabos.gif" width="183" height="94" /></td>
                                        </tr>
                                    </table>
                                    </div>
                                </td>
                                <td valign="top" align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center">
                                                <div style="position: relative;">
                                                    <?php if ($tpdestaq==5){ ?>
                                                    <div style="z-index:2;position: absolute; top: 0; left:7px; width:197px; height:114px;">
                                                        <img src="/images/50offg.png" border="0" width="197" height="114" />
                                                    </div>
                                                    <?php } ?>
                                                    <?php if ($tpdestaq==4){ ?>
                                                    <div style="z-index:2;position: absolute; top: 0; left:7px;  width:74px; height:75px;">
                                                        <img src="/images/tagprevenda.png" border="0" width="74" height="75" />
                                                    </div>
                                                    <?php } ?>
                                                    <?php //if ($id_prod==5167){ ?>
                                                    <!--
                                                    <div style="z-index:2;position: absolute; top: 0; left:7px; width:197px; height:114px;">
                                                        <img src="/images/tag_poster.png" border="0" width="197" height="114" />
                                                    </div>
                                                    -->
                                                    <?php //} ?>
                                                    <div style="z-index: 1;"><img id="fotoprod" name="fotoprod" src="/arquivos/uploads/produtos/<?php echo $fot1;?>" class="imagePane" alt=""  style="padding:4px; border:1px #6b4922 solid; background:#FFFFFF" /></div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div id="foto-thumbs2" >
                                                    <?php echo $str_fotos ?>
                                                </div>
                                                <div id="textleg" style="font-family:Arial, Helvetica, sans-serif;color:#6b4922; font-size:11px; margin:10px 0 0 10px;">
                                                    <?php echo $legenda_ini;?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table width="99%">
                                                    <tr><td align="left">
                                                      <div style="width:100%; float:left; margin: 5px 0 0 3px">
                                                        <h3 class="barra_marrom" style="width:383px; margin:0; float:left"><?php echo $ds_desc; ?></h3>
                                                            <button class="btmarrom" style="margin: 0 0 0 5px; float:left;" onclick="document.location.href='/shop/add_wish.php?idp=<?php echo $idp; ?>&ret=<?php echo urlencode("shop_produto.php?idp=$idp"); ?>';">Inserir Wishlist</button>
                                                      </div>
                                                    </td></tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center">
                                                <table width="475">
                                                    <tr>
                                                        <td width="60%" align="left">
                                                            <?php echo str_replace("<p>&nbsp;</p>","<br />",$ds_info); ?>
                                                        </td>
                                                        <td width="40%" valign="top">
                                                            <form action="/shop/indfriend.php" method="post" name="amigo">                   
                                                                <div>
                                                                    <h3 align="center" class="barra_ocre" style="width:190px; margin:0; float:left; text-align:left;font-size:12px;">Indique este produto</h3>
                                                                    <input type="hidden" name="idp" value="<?php echo $idp;?>"  />                        
                                                                    <br />
                                                                    <input name="emailind" type="text" style="width:97px; height:18px; margin:4px 0 0 0" value="Email" onClick="document.amigo.emailind.value=''"/><button  class="btbege" style="margin: 4px 0 0 5px; float:right;" >Indicar</button>	
                                                                </div>
                                                                <div>
                                                                    <h3 align="center" class="barra_ocre" style="width:190px; margin:10px 0 0 0; float:left; text-align:left;font-size:12px;">Compartilhe: 
                                                                    <span style="float:right; margin-right:10px;"><a href="http://<?php echo $urlface ?>" target="_blank"><img src="/images/facebook.gif" border="0" alt="Compartilhe no Facebook" title="Compartilhe no Facebook" /></a></span>
                                                            		<span style="float:right; margin-right:5px;"><a href="http://<?php echo $urlorkut ?>" target="_blank"><img src="/images/orkut.gif" border="0" alt="Compartilhe no Orkut" title="Compartilhe no Orkut" /></a></span>
                                                                    <span style="float:right; margin-right:5px;"><a href="http://<?php echo $urltwit ?>" target="_blank"><img src="/images/twitter.gif" border="0" alt="Compartilhe no Twitter" title="Compartilhe no Twitter" /></a></span>
                                                                    </h3>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left"><h3 class="barra_vermelha" style="width:480px; margin:10px 0 0 7px;">Comprar</h3></td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                            <div id="shop" style="width:480px; margin:10px 0 0 10px">
                                            <?php 
                                            $semestoque = "";
                                            if ($vlrpromo > 0) { ?>
                                                <p><strong>Promoção de <span class="preco">R$ <?php echo number_format($vl_prod,2,",",""); ?></span> por:</strong></p>
                                                <?php } else { ?>
                                                <p>&nbsp;</p>
                                                <?php } ?>
                                              
                                              <div id="shop-sizes" style="width:450px;">
                                              <?php if ($tipo != "4") { ?>
                                                <ul style="width:440px;">
                                                <?php
                                                $mostra = true;
                                                for ($f=1;$f<=5;$f++){
                                                    $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                                WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idp
                                                                AND NR_SEQ_TAMANHO_ESRC = $f";
                                                    $st = mysql_query($sql);
                                                    if (mysql_num_rows($st) > 0) {
                                                        if ($mostra) {
                                                        ?>
                                                        <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                        <li style="width:170px">
                                                            <?php if ($vlrpromo > 0) { ?>
                                                            R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                            <?php } else { ?>
                                                            R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                            <?php } ?>
                                                            <span class="shop-preco">- Masculino</span>
                                                        </li>
                                                        <?php
                                                        $mostra = false;
                                                        }
                                                        $row = mysql_fetch_row($st);
                                                        $idprod = $row[0];
                                                        $idesto = $row[1];
                                                        $dstama = $row[2];
                                                        $qtesto = $row[3];
                                                        if ($qtesto > 0) {
                                                        ?>
                                                        <li class="btverde" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF;"><?php echo $dstama; ?></li>
                                                        <?php
                                                        }else if ($qtesto <= 0){
                                                        $semestoque .= "Masculino ".$dstama."|".$f.";";
                                                        echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                        }
                                                    //}else{
                                                    //echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                    }
                                                }
                                                
                                                //XGL masculino
                                                $f = 33;
                                                $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                            WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idp
                                                            AND NR_SEQ_TAMANHO_ESRC = $f";
                                                $st = mysql_query($sql);
                                                if (mysql_num_rows($st) > 0) {
                                                    if ($mostra) {
                                                    ?>
                                                    <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                    <li style="width:170px">
                                                        <?php if ($vlrpromo > 0) { ?>
                                                        R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                        <?php } else { ?>
                                                        R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                        <?php } ?>
                                                        <span class="shop-preco">- Masculino</span>
                                                    </li>
                                                    <?php
                                                    $mostra = false;
                                                    }
                                                    $row = mysql_fetch_row($st);
                                                    $idprod = $row[0];
                                                    $idesto = $row[1];
                                                    $dstama = $row[2];
                                                    $qtesto = $row[3];
                                                    if ($qtesto > 0) {
                                                    ?>
                                                    <li class="btverde" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF;"><?php echo $dstama; ?></li>
                                                    <?php
                                                    }else if ($qtesto <= 0){
                                                    $semestoque .= "Masculino ".$dstama."|".$f.";";
                                                    echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                    }
                                                //}else{
                                                //echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                }
                                                ?>
                                                </ul>
                                                <ul style="width:440px;">
                                                              
                                                <?php
                                                $mostra = true;
                                                for ($f=6;$f<=10;$f++){
                                                    $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                                WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idp
                                                                AND NR_SEQ_TAMANHO_ESRC = $f";
                                                    $st = mysql_query($sql);
                                                    if (mysql_num_rows($st) > 0) {
                                                        if ($mostra) {
                                                        ?>
                                                        <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                        <li style="width:170px">
                                                            <?php if ($vlrpromo > 0) { ?>
                                                            R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                            <?php } else { ?>
                                                            R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                            <?php } ?>
                                                            <span class="shop-preco">- Feminino</span>
                                                        </li>       
                                                        <?php
                                                        $mostra = false;
                                                        }
                                                        $row = mysql_fetch_row($st);
                                                        $idprod = $row[0];
                                                        $idesto = $row[1];
                                                        $dstama = $row[2];
                                                        $qtesto = $row[3];
                                                        if ($qtesto > 0) {
                                                        ?>
                                                        <li class="btrosa" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF;"><?php echo $dstama; ?></li>
                                                        <?php
                                                            }else if ($qtesto <= 0){
                                                            $semestoque .= "Feminino ".$dstama."|".$f.";";
                                                            echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                            }
                                                       // }else{
                                                       // echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                        }
                                                }
                                                ?>                       
                                                </ul>
                                                
                                                
                                                <ul style="width:540px;">
                                                              
                                                <?php
                                                $mostra = true;
                                                for ($f=13;$f<=26;$f++){
                                                    $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                                WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idp
                                                                AND NR_SEQ_TAMANHO_ESRC = $f";
                                                    $st = mysql_query($sql);
                                                    if (mysql_num_rows($st) > 0) {
                                                        if ($mostra) {
                                                        ?>
                                                        <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                        <li style="width:120px">
                                                            <?php if ($vlrpromo > 0) { ?>
                                                            R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                            <?php } else { ?>
                                                            R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                            <?php } ?>
                                                        </li>       
                                                        <?php
                                                        $mostra = false;
                                                        }
                                                        $row = mysql_fetch_row($st);
                                                        $idprod = $row[0];
                                                        $idesto = $row[1];
                                                        $dstama = $row[2];
                                                        $qtesto = $row[3];
                                                        if ($qtesto > 0) {
                                                        ?>
                                                        <li class="btrosa" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF;"><?php echo $dstama; ?></li>
                                                        <?php
                                                            }else if ($qtesto <= 0){
                                                            $semestoque .= "Tamanho ".$dstama."|".$f.";";
                                                            echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                            }
                                                       // }else{
                                                       // echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                        }
                                                }
                                                ?>                       
                                                </ul>
                                                
                                                <ul style="width:540px;">
                                                              
                                                <?php
                                                //novos tamanhos por faixa
                                                $mostra = true;
                                                $xx = 1;
                                                for ($f=27;$f<=32;$f++){
                                                    $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                                WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idp
                                                                AND NR_SEQ_TAMANHO_ESRC = $f";
                                                    $st = mysql_query($sql);
                                                    
                                                    if (mysql_num_rows($st) > 0) {
                                                        if ($mostra) {
                                                        ?>
                                                        <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                        <li style="width:120px">
                                                            <?php if ($vlrpromo > 0) { ?>
                                                            R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                            <?php } else { ?>
                                                            R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                            <?php } ?>
                                                        </li>       
                                                        <?php
                                                        $mostra = false;
                                                        }
                                                        $row = mysql_fetch_row($st);
                                                        $idprod = $row[0];
                                                        $idesto = $row[1];
                                                        $dstama = $row[2];
                                                        $qtesto = $row[3];
                                                        if ($qtesto > 0) {
                                                            if ($xx == 4) echo '</ul><ul style="width:540px; margin: 0 0 0 165px;">';
                                                        ?>
                                                        <li class="btrosa" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF; width: 55px;"><?php echo $dstama; ?></li>
                                                        <?php
                                                        }else if ($qtesto <= 0){
                                                            $semestoque .= "Tamanho ".$dstama."|".$f.";";
                                                            echo "<li style=\"padding:0; width: 56px;\"><img src=\"/images/soldout2.gif\" align=\"absmiddle\"></li>";
                                                        }
                                                       // }else{
                                                       // echo "<li style=\"padding:0; margin: 0 14px 0 0; width: 55px;"\"><img src=\"/images/soldout.gif\" align=\"absmiddle\" ></li>";
                                                        $xx++;
                                                    }
                                                }
                                                ?>                       
                                                </ul>
                                                
                                                <?php 
                                                } ?>
                                                <!--
                                                <ul>
                                                  <li style="width:95px; font-size:11px; font-weight:normal; margin:0; padding:0;"><img src="/images/img_carrinho_unisex.jpg" alt="Unissex" /></li>
                                                  <li class="btverde"><a href="#">M</a></li>
                                                  <li class="btverde"><a href="#">G</a></li>
                                                </ul>
                                                -->
                                                
                                                <ul style="width:440px;">
                                                <?php
                                                $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC FROM estoque, tamanhos
                                                            WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_QTDE_ESRC > 0 AND NR_SEQ_PRODUTO_ESRC = $idp
                                                            AND NR_SEQ_TAMANHO_ESRC = 11";
                                                $st = mysql_query($sql);
                                                if (mysql_num_rows($st) > 0) {
                                                    ?>
                                                    <li style="width:40px; font-size:11px; font-weight:normal; margin:10px 0 0 0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                    <li style="width:170px; margin:10px 0 0 0;">
                                                        <?php if ($vlrpromo > 0) { ?>
                                                        R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                        <?php } else { ?>
                                                        R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                        <?php } ?>
                                                    </li>
                                                    <?php
                                                    while($row = mysql_fetch_row($st)) {
                                                        $idprod = $row[0];
                                                        $idesto = $row[1];
                                                        $dstama = $row[2];
                                                    ?>
                                                    <li class="btverde" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="width:120px; color:#FFFFFF; margin:10px 0 0 0;"><?php echo $dstama; ?></li>
                                                    <?php
                                                    }
                                                }
                                                ?>                       
                                                </ul>
                                                
                                                
                                                
                                                <?php 
                                                //############## ESPECIAL PARA LINKAR 2 PRODUTOS #################### COLOCAR ST_PRO = A NO FINAL
                                                if ($idplink > 0) { 
                                                $sql3 = "SELECT VL_PRODUTO_PRRC, VL_PROMO_PRRC FROM produtos
                                                                WHERE NR_SEQ_PRODUTO_PRRC = $idplink";
                                                $st3 = mysql_query($sql3);
                                                if (mysql_num_rows($st3) > 0) {
                                                    $row3 = mysql_fetch_row($st3);
                                                    $vl_prod = $row3[0];
                                                    $vlrpromo = $row3[1];
                                              
                                                if ($vlrpromo > 0) { ?>
                                                <p><strong>Promoção de <span class="preco">R$ <?php echo number_format($vl_prod,2,",",""); ?></span> por:</strong></p>
                                                <?php } else { ?>
                                                <p>&nbsp;</p>
                                                <?php } ?>
                                                <ul style="width:440px;">
                                                <?php
                                                $mostra = true;
                                                for ($f=1;$f<=5;$f++){
                                                    $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                                WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idplink
                                                                AND NR_SEQ_TAMANHO_ESRC = $f";
                                                    $st = mysql_query($sql);
                                                    if (mysql_num_rows($st) > 0) {
                                                        if ($mostra) {
                                                        ?>
                                                        <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                        <li style="width:170px">
                                                            <?php if ($vlrpromo > 0) { ?>
                                                            R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                            <?php } else { ?>
                                                            R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                            <?php } ?>
                                                            <span class="shop-preco">- Masculino</span>
                                                        </li>
                                                        <?php
                                                        $mostra = false;
                                                        }
                                                        $row = mysql_fetch_row($st);
                                                        $idprod = $row[0];
                                                        $idesto = $row[1];
                                                        $dstama = $row[2];
                                                        $qtesto = $row[3];
                                                        if ($qtesto > 0) {
                                                        ?>
                                                        <li class="btverde" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF;"><?php echo $dstama; ?></li>
                                                        <?php
                                                        }else if ($qtesto <= 0){
                                                        $semestoque .= "Masculino ".$dstama."|".$f.";";
                                                        echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                        }
                                                    //}else{
                                                    //echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                    }
                                                }
                                                
                                                //XGL masculino
                                                $f = 33;
                                                $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                            WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idplink
                                                            AND NR_SEQ_TAMANHO_ESRC = $f";
                                                $st = mysql_query($sql);
                                                if (mysql_num_rows($st) > 0) {
                                                    if ($mostra) {
                                                    ?>
                                                    <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                    <li style="width:170px">
                                                        <?php if ($vlrpromo > 0) { ?>
                                                        R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                        <?php } else { ?>
                                                        R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                        <?php } ?>
                                                        <span class="shop-preco">- Masculino</span>
                                                    </li>
                                                    <?php
                                                    $mostra = false;
                                                    }
                                                    $row = mysql_fetch_row($st);
                                                    $idprod = $row[0];
                                                    $idesto = $row[1];
                                                    $dstama = $row[2];
                                                    $qtesto = $row[3];
                                                    if ($qtesto > 0) {
                                                    ?>
                                                    <li class="btverde" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF;"><?php echo $dstama; ?></li>
                                                    <?php
                                                    }else if ($qtesto <= 0){
                                                    $semestoque .= "Masculino ".$dstama."|".$f.";";
                                                    echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                    }
                                                //}else{
                                                //echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                }
                                                ?>
                                                </ul>
                                                <ul style="width:440px;">
                                                              
                                                <?php
                                                $mostra = true;
                                                for ($f=6;$f<=10;$f++){
                                                    $sql = "SELECT NR_SEQ_PRODUTO_ESRC, NR_SEQ_ESTOQUE_ESRC, DS_SIGLA_TARC, NR_QTDE_ESRC FROM estoque, tamanhos
                                                                WHERE NR_SEQ_TAMANHO_ESRC = NR_SEQ_TAMANHO_TARC AND NR_SEQ_LOJA_ESRC = 1 AND NR_SEQ_PRODUTO_ESRC = $idplink
                                                                AND NR_SEQ_TAMANHO_ESRC = $f";
                                                    $st = mysql_query($sql);
                                                    if (mysql_num_rows($st) > 0) {
                                                        if ($mostra) {
                                                        ?>
                                                        <li style="width:40px; font-size:11px; font-weight:normal; margin:0; padding:0"><img src="/images/img_carrocompras.jpg" width="30" height="27" /></li>
                                                        <li style="width:170px">
                                                            <?php if ($vlrpromo > 0) { ?>
                                                            R$ <?php echo number_format($vlrpromo,2,",",""); ?>
                                                            <?php } else { ?>
                                                            R$ <?php echo number_format($vl_prod,2,",",""); ?>
                                                            <?php } ?>
                                                            <span class="shop-preco">- Feminino</span>
                                                        </li>       
                                                        <?php
                                                        $mostra = false;
                                                        }
                                                        $row = mysql_fetch_row($st);
                                                        $idprod = $row[0];
                                                        $idesto = $row[1];
                                                        $dstama = $row[2];
                                                        $qtesto = $row[3];
                                                        if ($qtesto > 0) {
                                                        ?>
                                                        <li class="btrosa" onclick="document.location.href='/shop/addcar.php?idp=<?php echo $idprod; ?>&ide=<?php echo $idesto; ?>'" style="color:#FFFFFF;"><?php echo $dstama; ?></li>
                                                        <?php
                                                            }else if ($qtesto <= 0){
                                                            $semestoque .= "Feminino ".$dstama."|".$f.";";
                                                            echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                            }
                                                       // }else{
                                                       // echo "<li style=\"padding:0; margin: 0 14px 0 0\"><img src=\"/images/soldout.gif\" align=\"absmiddle\"></li>";
                                                        }
                                                }
                                                ?>                       
                                                </ul>
                                                <?php 
                                                    }
                                                } ?>
                                                
                                                
                                                
                                                
                                                <p><img src="/images/img_vale_presente.jpg" width="32" height="24" align="absmiddle" style="margin:0;" />   
                                                    <input name="" type="submit" class="btbege" value="Vale-Presente" onclick="document.location.href='/valepresente/valepresente_1.php';" style="width:90px; float:none; margin:7px 0 0 0; padding:0"/>
                                                </p>
                                              
                                              </div>
         
                                            </div>
                                            </td>
                                        </tr>
                                        <?php if ($semestoque) {
										$dstexto = "";
										$splittam = array();
										$splittam = explode(";", $semestoque);
										foreach($splittam as $values){
											$splittam2 = explode("\|", $values);
											if ($splittam2[0]) $dstexto .= "<option value=\"".$splittam2[1]."\">".$splittam2[0]."</option>";
										}
										?>
                                        <tr>
                                            <td align="left"><h3 class="barra_vermelha" style="width:480px; margin:20px 0 0 7px;">Avise-me</h3></td>
                                        </tr>
                                        <tr>
                                            <td align="left">
                                            <div id="shop" style="width:480px; margin:10px 0 0 10px">
                                            <p>Caso você queira ser avisado da volta ao estoque de algum tamanho deste produto, preencha o seus dados abaixo escolhendo o mesmo:</p>
                                            <form action="/shop/aviseme.php" method="post" name="frmAvise" id="frmAvise">
                                            	<input type="hidden" name="idp" value="<?php echo $idp;?>" />
                                                <input name="nomeavise" type="text" style="width:250px; height:18px; margin:4px 0 0 0" value="Nome" onClick="document.frmAvise.nomeavise.value=''"/>
                                                <input name="foneavise" type="text" style="width:210px; height:18px; margin:4px 0 0 0" value="Telefone" onClick="document.frmAvise.foneavise.value=''"/>
                                                <p>
                                            	<input name="emailavise" type="text" style="width:250px; height:18px; margin:4px 0 0 0;" value="Email" onClick="document.frmAvise.emailavise.value=''"/>
                                                Tamanho: <select name="tamanho" style="margin:4px 0 0 0; width:156px;"><?php echo $dstexto ?></select>
                                                </p>
                                                <p>Observação/Sugestão:</p>
                                                <textarea name="obsavise" style="width:360px; height:50px; margin:4px 0 0 0"></textarea>
                                                <button  class="btbege" style="margin: 38px 0 0 5px; float:right;">Avise-me</button>	
                                            </form>
                                            </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td align="left">
                                            <p>
                                                <button class="btmarrom" style="width:160px; margin: 30px 0 20px 5px; float:left;" onclick="document.location.href='<?php echo $pgret; ?>';">Voltar ao Shop / Back to Shop</button>
                                              </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        
                        <div style="width: 700px; float:right;">
                        <h3 class="barra_marrom" style="width:615px; float:right; text-align:left">Sugestões da Reverbcity</h3>
                        <table cellspacing="10" align="right">
                        <tr>
                        <?php
                        $ids = "";
                        $sql = "SELECT distinct DS_PRODUTO2_PRRC, VL_PRODUTO_PRRC, DS_EXT_PRRC, NR_SEQ_PRODUTO_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PTRC
                                from produtos, estoque, produtos_tipo 
                                WHERE NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC and NR_QTDE_ESRC > 0 and 
                                NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and 
                                ST_PRODUTOS_PRRC = 'A' and 
                                DS_CLASSIC_PRRC = 'N' and
                                NR_SEQ_MUSICA_PRRC = $nr_musi and 					
                                NR_SEQ_PRODUTO_PRRC != $idp AND NR_SEQ_LOJAS_PRRC = 1									
                                order by rand() limit 3";
                        $st = mysql_query($sql); 
                        $x = 0;
                        if (mysql_num_rows($st) > 0) {
                            while($row = mysql_fetch_row($st)) {
                            $ds_prod	   = $row[0];
                            $vl_prod	   = Valor_Produto($row[3],$SS_logado);
                            $ex_prod	   = $row[2];
                            $id_prod	   = $row[3];
                            $vlrpromo	   = $row[4];
                            $ds_categoria  = $row[5];
                            $ids .= $id_prod.",";
                            
                            $ds_categoria = str_replace("&","e;",$ds_categoria);
                            $ds_prod_url = str_replace("&","e;",$ds_prod);
                        ?>
                        <!-- //**** Mostra os produtos iguais a musica.  -->
                        <td style="border:thin #630; border-style:solid;" >
                        <div class="produto" style="margin: 0 7px;width:180px;height:265px;">
                                    <?php if ($ex_prod == "swf") {?>
                                      <object data="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                        <param name="quality" value="high" />
                                        <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                        <param name="movie" value="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" />
                                        <param name="wmode" value="opaque" />
                                      </object>
                                    <?php }else{ ?>
                                    <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" border="0" /></a>
                                    <?php } ?>
                                    <div class="preco-produto">
                                        <?php if ($vlrpromo > 0) { ?>
                                        <p class="promocao"><span class="preco" style="text-decoration:line-through">R$ <?php echo number_format($vl_prod,2,",",""); ?></span><br />
                                        <span class="promocao" style="text-decoration:none">R$ <?php echo number_format($vlrpromo,2,",",""); ?></span></p>
                                        <?php } else { ?>
                                        <p class="promocao">R$ <?php echo number_format($vl_prod,2,",",""); ?></p>
                                        <?php } ?>
                                        </div>
                                    <div class="desc-produto">
                                        <p><?php echo $ds_prod; ?><br />
                                        </p>
                                    </div>
                        </div>
           				</td>           
                        <?php
                            $x++;
                            }
                        }
                        
                        if (substr($ids,strlen($ids)-1,1) == ",") $ids = substr($ids,0,strlen($ids)-1);
                        
                        if ($x < 3) {
                            $totreg = 3 - $x;
                            $sql = "SELECT distinct DS_PRODUTO2_PRRC, VL_PRODUTO_PRRC, DS_EXT_PRRC, NR_SEQ_PRODUTO_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PTRC
                                    from produtos, estoque, produtos_tipo 
                                    WHERE
                                     (NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC and 
                                     NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and 
                                     NR_QTDE_ESRC > 0 and 
                                     ST_PRODUTOS_PRRC = 'A' and 
                                     DS_CLASSIC_PRRC = 'N' and
                                     NR_SEQ_CATEGORIA_PRRC = $nr_cate and
                                     NR_SEQ_PRODUTO_PRRC != $idp and
                                     NR_SEQ_LOJAS_PRRC = 1) AND
                                     NR_SEQ_PRODUTO_PRRC not in ($ids)
                                     order by rand() limit $totreg";
                            $st = mysql_query($sql); 
            
                            if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                $ds_prod	   = $row[0];
                                $vl_prod	   = Valor_Produto($row[3],$SS_logado);
                                $ex_prod	   = $row[2];
                                $id_prod	   = $row[3];
                                $vlrpromo	   = $row[4];
                                $ds_categoria  = $row[5];
                                $ids .= $id_prod.",";
                                
                                $ds_categoria = str_replace("&","e;",$ds_categoria);
                                $ds_prod_url = str_replace("&","e;",$ds_prod);
                            ?>
                            <!-- //***** mostra os produtos iguais a categoria	-->
                            <td style="border:thin #630; border-style:solid;">
                            <div class="produto" style="margin: 0 7px;width:180px;height:265px;">
                                        <?php if ($ex_prod == "swf") {?>
                                          <object data="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                            <param name="quality" value="high" />
                                            <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                            <param name="movie" value="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" />
                                            <param name="wmode" value="opaque" />
                                          </object>
                                        <?php }else{ ?>
                                        <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" border="0" /></a>
                                        <?php } ?>
                                         <div class="preco-produto">
                                        <?php if ($vlrpromo > 0) { ?>
                                       <p class="promocao"><span class="preco" style="text-decoration:line-through">R$ <?php echo number_format($vl_prod,2,",",""); ?></span><br />
                                        <span class="promocao" style="text-decoration:none">R$ <?php echo number_format($vlrpromo,2,",",""); ?></span></p>
                                        <?php } else { ?>
                                        <p class="promocao">R$ <?php echo number_format($vl_prod,2,",",""); ?></p>
                                        <?php } ?>
                                        </div>
                                        <div class="desc-produto">
                                            <p><?php echo $ds_prod; ?><br />
                                            </p>
                                        </div>
                            </div>
           					 </td>				
                            <?php
                                $x++;
                                }
                            }
                        }
                        
                        if (substr($ids,strlen($ids)-1,1) == ",") $ids = substr($ids,0,strlen($ids)-1);
                        
                        if ($x < 3) {
                            $totreg = 3 - $x;
                            $sql = "SELECT distinct DS_PRODUTO2_PRRC, VL_PRODUTO_PRRC, DS_EXT_PRRC, NR_SEQ_PRODUTO_PRRC, VL_PROMO_PRRC, DS_CATEGORIA_PTRC 
                                    from produtos, estoque, produtos_tipo 
                                    WHERE
                                     (NR_SEQ_PRODUTO_PRRC = NR_SEQ_PRODUTO_ESRC and 
                                     NR_SEQ_TIPO_PRRC = NR_SEQ_CATEGPRO_PTRC and 
                                     NR_QTDE_ESRC > 0 and 
                                     ST_PRODUTOS_PRRC = 'A' and 
                                     DS_CLASSIC_PRRC = 'N' and
                                     NR_SEQ_PRODUTO_PRRC != $idp and
                                     NR_SEQ_LOJAS_PRRC = 1) AND
                                     NR_SEQ_PRODUTO_PRRC not in ($ids)  
                                     order by rand() limit $totreg";
                            $st = mysql_query($sql); 
            
                            if (mysql_num_rows($st) > 0) {
                                while($row = mysql_fetch_row($st)) {
                                $ds_prod	   = $row[0];
                                $vl_prod	   = Valor_Produto($row[3],$SS_logado);
                                $ex_prod	   = $row[2];
                                $id_prod	   = $row[3];
                                $vlrpromo	   = $row[4];
                                $ds_categoria  = $row[5];
                                
                                $ds_categoria = str_replace("&","e;",$ds_categoria);
                                $ds_prod_url = str_replace("&","e;",$ds_prod);
                            ?>
                             <!-- //***** Completa a mostra dos produtos -->
                                           
                            <td style="border:thin #630; border-style:solid;" >				
                            <div class="produto" style="margin: 0 7px;width:180px;height:265px;">
                                        <?php if ($ex_prod == "swf") {?>
                                          <object data="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" type="application/x-shockwave-flash" width="180" height="210">
                                            <param name="quality" value="high" />
                                            <param name="flashvars" value="URLname=<?php echo $id_prod; ?>" />
                                            <param name="movie" value="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" />
                                            <param name="wmode" value="opaque" />
                                          </object>
                                        <?php }else{ ?>
                                        <a href="/produto/<?php echo $ds_categoria ?>/<?php echo urlencode($ds_prod_url); ?>"><img src="/images/produtos/<?php echo $id_prod; ?>.<?php echo $ex_prod; ?>" border="0" /></a>
                                        <?php } ?>
                                         <div class="preco-produto">
                                        <?php if ($vlrpromo > 0) { ?>
                                        <p class="promocao"><span class="preco" style="text-decoration:line-through">R$ <?php echo number_format($vl_prod,2,",",""); ?></span><br />
                                        <span class="promocao" style="text-decoration:none">R$ <?php echo number_format($vlrpromo,2,",",""); ?></span></p>
                                        <?php } else { ?>
                                        <p class="promocao">R$ <?php echo number_format($vl_prod,2,",",""); ?></p>
                                        <?php } ?>
                                        </div>
                                        <div class="desc-produto">
                                            <p><?php echo $ds_prod; ?><br />
                                            </p>
                                        </div>
                            </div>
           					 </td>				
                            <?php
                                $x++;
                                }
                            }
                        }
                        ?>
                      </div>
                      </tr>
                      </table>
                      
                      <a name="comprod" id="comprod"></a>
                      
                      <div style="width: 700px; float:right;">
                        <h3 class="barra_marrom" style="width:615px; float:right; text-align:left">Comentários sobre este produto <span style="float:right; margin: 0 6px 0 0;">Nota atual: <img src="<?php echo $rater_stars ?>" width="89" height="15" alt="<?php echo $rater_stars_txt ?>" title="<?php echo $rater_stars_txt ?>" /></span></h3>
                         <?php
							$sql3 = "select DT_COMENT_PCRC, DS_NOME_CASO, DS_COMENTARIO_PCRC, DS_AUTOR_PCRC, NR_SEQ_CADASTRO_PCRC, DS_EXT_CACH from produtos_coments, cadastros
										 WHERE NR_SEQ_CADASTRO_PCRC = NR_SEQ_CADASTRO_CASO and DS_STATUS_PCRC = 'A' and NR_SEQ_PRODUTO_PCRC = $idp ";
							$sql3 .= "order by DT_COMENT_PCRC";
							$st3 = mysql_query($sql3);
							if (mysql_num_rows($st3) > 0) {
								?>
								<div id="comentarios" style="float:right;">
							<?php
								while($row3 = mysql_fetch_row($st3)) {
									$cm_data	= $row3[0];
									$cm_nome	= $row3[1];
									$cm_text	= $row3[2];
									$tp_nome	= $row3[3];
									$id_cad		= $row3[4];
		//***** Imagem											
									$ext 		= $row3[5];
		
									$imagperf = $id_cad.'.'.$ext;

									if (!file_exists($_SERVER{'DOCUMENT_ROOT'} . "/images/me/$imagperf")) $imagperf = "0.jpg";
		//*****							
									if ($id_cad == 3) $cm_nome = $tp_nome;
									
									if (strpos($cm_nome," ") > 0){
										$cm_nome = substr($cm_nome,0,strpos($cm_nome," "));
									}
						?>
									<div class="comments" style="float:right;width:589px;">
		<!-- Mostra a imagem -->                            
										<table>
											<tr>
												<td width="60px" align="center">
													<img src="/images/me/<?php echo $imagperf; ?>" width="50px" height="50px" />    
                                                                          
												</td>
		<!-- fim Mostra a imagem -->                            
												<td >
												 <p class="autor"> em <?php echo date("d/m/Y", strtotime($cm_data));?> ás <?php echo date("G:i", strtotime($cm_data));?>h<br />por:
											  <?php if ($id_cad != 3) echo "<a href=\"/me/me_perfil.php?idme=$id_cad\">"; ?>
											  <?php echo $cm_nome; ?>
											  <?php if ($id_cad != 3) echo "</a>"; ?>
											  </p>
											  <p style="font-size:11px;"><?php echo $cm_text; ?></p>
												</td>
											</tr>
										</table>                                      
									</div>
						<?php
								} 
								echo "</div>";
							}?>
                        <form id="form2" name="form2" method="post" action="/shop/envia_coment.php" style="width:99%;">
                        <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                        <table cellspacing="10" align="left" width="600" style="margin:0 0 0 63px;">
                        <tr><td>
						<?php if (!$SS_logado) {?>
                        <!--
                        <table>
                        <tr><td align="left" width="50"><p><strong>Nome: </strong></p></td><td align="left"><input name="nome" type="text" class="input" id="nome" style="width:200px" /></td></tr>
						<tr><td align="left" width="50"><p><strong>E-Mail:</strong></p></td><td align="left"><input name="email" type="text" class="input" id="email" style="width:200px" /></td></tr>
                        </table>
                        -->
                        <?php } ?>
                        </td>
                        <td><p><strong>Dê sua nota:</strong> 
                        <?php
						echo '<label for="rate1_'.$idp.'"><input type="radio" value="1" name="rating" id="rating" />1</label>';
						echo '<label for="rate2_'.$idp.'"><input type="radio" value="2" name="rating" id="rating" />2</label>';
						echo '<label for="rate3_'.$idp.'"><input type="radio" value="3" name="rating" id="rating" checked />3</label>';
						echo '<label for="rate4_'.$idp.'"><input type="radio" value="4" name="rating" id="rating" />4</label>';
						echo '<label for="rate5_'.$idp.'"><input type="radio" value="5" name="rating" id="rating" />5</label>';
						?>
                        </p>
                        </td>
                        </tr>
                        <tr><td colspan="2">
                        <textarea name="dscoment" cols="45" rows="5" class="input" id="dscoment" style="width:100%"></textarea>
                        <p><button class="btbege" type="submit" style="width: 100px; margin: 15px 0 10px 0; float:left;">Enviar / Send</button></form></p>
                        </td></tr>
	                    </table>
                        </form>
                      </div>
            
                    </div>
                        
                        
                        </td>
                        <td width="260" valign="top">
                        
                        <table width="260">
                          	<tr>
                            	<td align="left"><h3 class="barra_marrom" style="margin: 0; width:260px;">Sizes</h3></td>
                            </tr>
                            <tr>
                            	<td align="left">
                                	<?php
									  if ($imgtamanho) echo $imgtamanho;
									  if ($tipo == "4") echo "<p>Tamanho padrão do button = 4,5 cm.<br><br>Standard pin size = 1” ¾ inches</p>";
									  ?>
                                </td>
                            </tr>
                            <tr>
                            	<td align="left"><h3 class="barra_marrom" style="margin:0;padding:4px;width:260px;">Formas de Pagamento</h3></td>
                            </tr>
                            <tr>
                            	<td align="left">
                                <p><img src="/images/img_formasdepagamento2.jpg" width="230" height="49" /><br />
                                  Parcelamentos sem juros no cartão</p>
                                  
                                  <p>A partir de  	  50,00	 - 2x sem juros<br />
                                    A partir de 	100,00  - 3x sem juros<br />
                                    A partir de 	150,00  - 4x sem juros<br />
                                    A partir de 	200,00  - 5x sem juros<br />
                                    A partir de	250,00  - 6x sem juros</p>
                                </td>
                            </tr>
                            <tr>
                            	<td align="left"><h3 class="barra_marrom" style="margin:0; width:260px;">Calcular frete / Shipping Cost</h3></td>
                            </tr>
                            <tr>
                            	<td align="left">
                                <form action="/shop/frete2.php" method="post">
                                  <input name="idp" type="hidden" value="<?php echo $idp; ?>" />
                                    <p>CEP 
                                      <label>
                                      <input name="cep" type="text" class="input" id="textfield" style="width:90px"/>
                                      </label>
                                      <label>
                                      <input name="button" type="submit" class="btbege" id="button" value="Calcular" style="float:none; width:65px; margin: 0 10px 0 10px"/>
                                      </label>
                                    <br />Valor  R$ <?php echo $vlrfrete; ?></p>
                                  </form>
                                </td>
                            </tr>
                            <tr>
                            	<td align="left"><h3 class="barra_marrom" style="margin:0; width:260px;">Trocas / Returns</h3></td>
                            </tr>
                            <tr>
                            	<td align="left">
                                	<p>
                                  <a href="#" style="color:#6b4922;text-decoration:none;font-size:11px;" class="tooltip_w" title="Reverbcity will accept returns and cover shipping costs in case of damaged products. If the client wishes to return an item (not used) for whatever other reason, he/she must pay for shipping or go to one of the showrooms in São Paulo or Londrina.">
                                  A Reverbcity garante a troca de qualquer um de seus produtos, sem ônus para o cliente, caso seja constatado defeito na peça. Se o cliente quiser trocar uma peça (sem uso) por qualquer outro motivo, ele deverá cobrir despesas de frete ou passar em um dos showrooms de São Paulo ou Londrina.
                                  </a></p>
                                </td>
                            </tr>
                            <tr>
                            	<td align="left"><h3 class="barra_marrom" style="margin:0; width:260px;">Prazo de entrega / Delivery Time</h3></td>
                            </tr>
                            <tr>
                            	<td align="left">
                                <p>
                                1 a 2 dias úteis para as Capitais PR SC SP RJ MG<br />
                                3 a 7 dias úteis para demais cidades do interior e todo o estado RS DF ES GO MS AL BA MT SE TO<br />
                                7 a 12 dias úteis para todo o estado e capital do AM AC AP CE MA PA PB PE PI RN RO RR<br />
                                </p>
                                </td>
                            </tr>
                            <?php if (strlen($musicprod)>10) {
                            $musicprod = str_replace("/watch?v=","/v/",$musicprod);
                            $musicprod = str_replace("/watch?gl=BR&v=","/v/",$musicprod);
                            $youpart1 = "<object height=\"198\" width=\"266\"><param value=\"";
                            $youpart2 = "?fs=1&amp;hl=pt_BR\" name=\"movie\" /><param value=\"true\" name=\"allowFullScreen\" /><param value=\"always\" name=\"allowscriptaccess\" /><embed height=\"198\" width=\"266\" allowfullscreen=\"true\" allowscriptaccess=\"always\" type=\"application/x-shockwave-flash\" src=\"";
                            $youpart3 = "?fs=1&amp;hl=pt_BR\"></embed></object>";  
                            ?>
                            <tr>
                            	<td align="left"><h3 class="barra_marrom" style="margin: 10px 0 10px 0; width:260px;">Música do produto</h3></td>
                            </tr>
                            <tr>
                            	<td><?php echo $youpart1.$musicprod.$youpart2.$musicprod.$youpart3 ?></td>
                            </tr>
                            <?php } ?> 
                          </table>
                        
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
        	<td><?php include '../includes/rodape.html'; ?></td>
        </tr>
	</table>        
    
</body>
</html>
<?php mysql_close($con); ?>