<?php
include 'auth.php';
include 'lib.php';
$idc = request("idc");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Detalhamento Pedido</title>
<style type="text/css">
.style1 {
	color: #FF0000;
	font-weight: bold;
}
</style>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
  $sql2 = "SELECT DS_DESTINATARIO_ENRC, DS_ENDERECO_ENRC, DS_NUMERO_ENRC, DS_COMPLEMENTO_ENRC, DS_BAIRRO_ENRC, DS_CEP_ENRC, DS_CIDADE_ENRC,
  			 DS_UF_ENRC, DS_PAIS_ENRC, DS_FONE_ENRC FROM enderecos WHERE NR_SEQ_COMPRA_ENRC = $idc";
  $st2 = mysql_query($sql2);
  if (mysql_num_rows($st2) > 0) {
  $row2 = mysql_fetch_assoc($st2);
  ?>
  <form action="compras_endentrega_alt.php" method="post">
  <input type="hidden" name="idc" value="<?php echo $idc ?>" />
    <table width="100%" border="0" cellspacing="1" cellpadding="2" class="textosver">
      <tr>
        <td height="20" bgcolor="#EBEBEB"><strong>Nome:</strong></td>
        <td colspan="3" bgcolor="#EBEBEB"><span class="style1"><input value="<?php echo $row2["DS_DESTINATARIO_ENRC"]; ?>" type="text" name="nome" id="nome" class="frm_pesq" style="width: 350px;" /></span></td>
        </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Endereço:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" value="<?php echo $row2["DS_ENDERECO_ENRC"]; ?>" name="endereco" id="endereco" class="frm_pesq" style="width: 180px;" /> N&deg; <input value="<?php echo $row2["DS_NUMERO_ENRC"]; ?>" type="text" name="numero" id="numero" class="frm_pesq" style="width: 30px;" /></td>
        <td bgcolor="#EBEBEB"><strong>Bairro:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" value="<?php echo $row2["DS_BAIRRO_ENRC"]; ?>" name="bairro" id="bairro" class="frm_pesq" style="width: 150px;" /></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Cidade/UF:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" value="<?php echo $row2["DS_CIDADE_ENRC"]; ?>" name="cidade" id="cidade" class="frm_pesq" style="width: 180px;" />/<input value="<?php echo $row2["DS_UF_ENRC"]; ?>" type="text" name="uf" id="uf" class="frm_pesq" style="width: 30px;" /></td>
        <td bgcolor="#EBEBEB"><strong>CEP:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" value="<?php echo $row2["DS_CEP_ENRC"]; ?>" name="cep" id="cep" class="frm_pesq" style="width: 100px;" /></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Complemento:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" value="<?php echo $row2["DS_COMPLEMENTO_ENRC"]; ?>" name="complem" id="complem" class="frm_pesq" style="width: 190px;" /></td>
        <td bgcolor="#EBEBEB"><strong>País:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" value="<?php echo $row2["DS_PAIS_ENRC"]; ?>" name="pais" id="pais" class="frm_pesq" style="width: 100px;" /></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Fone:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" value="<?php echo $row2["DS_FONE_ENRC"]; ?>" name="fone" id="fone" class="frm_pesq" style="width: 100px;" /></td>
        <td bgcolor="#EBEBEB">&nbsp;</td>
        <td bgcolor="#EBEBEB">&nbsp;</td>
      </tr>
    
    <tr>
        <td bgcolor="#EBEBEB" align="center" colspan="4">
        	<input type="Button" value="Voltar" onClick="document.location.href=('compras_ver.php?idc=<? echo $idc;?>');" class="frm_pesq" style="width:45px;" />
            &nbsp;&nbsp;
        	<input type="submit" value="Alterar End. Entrega" class="frm_pesq" style="width:130px;" />
        </td>
    </tr>
    </table>
    </form>

    <?php 
    }else{
    ?>
    <form action="compras_endentrega_inc.php" method="post">
    <input type="hidden" name="idc" value="<?php echo $idc ?>" />
    <table width="100%" border="0" cellspacing="1" cellpadding="2" class="textosver">
      <tr>
        <td height="20" bgcolor="#EBEBEB"><strong>Nome:</strong></td>
        <td colspan="3" bgcolor="#EBEBEB"><span class="style1"><input type="text" name="nome" id="nome" class="frm_pesq" style="width: 350px;" /></span></td>
        </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Endereço:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" name="endereco" id="endereco" class="frm_pesq" style="width: 180px;" /> N&deg; <input type="text" name="numero" id="numero" class="frm_pesq" style="width: 30px;" /></td>
        <td bgcolor="#EBEBEB"><strong>Bairro:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" name="bairro" id="bairro" class="frm_pesq" style="width: 150px;" /></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Cidade/UF:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" name="cidade" id="cidade" class="frm_pesq" style="width: 180px;" />/<input type="text" name="uf" id="uf" class="frm_pesq" style="width: 30px;" /></td>
        <td bgcolor="#EBEBEB"><strong>CEP:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" name="cep" id="cep" class="frm_pesq" style="width: 100px;" /></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Complemento:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" name="complem" id="complem" class="frm_pesq" style="width: 190px;" /></td>
        <td bgcolor="#EBEBEB"><strong>País:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" name="pais" id="pais" class="frm_pesq" style="width: 100px;" /></td>
      </tr>
      <tr>
        <td bgcolor="#EBEBEB"><strong>Fone:</strong></td>
        <td bgcolor="#EBEBEB"><input type="text" name="fone" id="fone" class="frm_pesq" style="width: 100px;" /></td>
        <td bgcolor="#EBEBEB">&nbsp;</td>
        <td bgcolor="#EBEBEB">&nbsp;</td>
      </tr>
    
    <tr>
        <td bgcolor="#EBEBEB" align="center" colspan="4">
        	<input type="Button" value="Voltar" onClick="document.location.href=('compras_ver.php?idc=<? echo $idc;?>');" class="frm_pesq" style="width:45px;" />
            &nbsp;&nbsp;
        	<input type="submit" value="Inserir End. Entrega" class="frm_pesq" style="width:130px;" />
        </td>
    </tr>
    </table>
    </form>
    <?php } ?>
</body>
</html>

