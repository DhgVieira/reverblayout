<?php
include 'auth.php';
include 'lib.php';

$arqorig   	= request("arqorig");
$extorig   	= request("extorig");
$categoria	= request("categoria");
$descricao	= request("descricao");

$sqlus = "select DS_EMAIL_USRC, DS_LOGIN_USRC from usuarios WHERE NR_SEQ_USUARIO_USRC = $SS_logadm";
$stus = mysql_query($sqlus);
if (mysql_num_rows($stus) > 0) {
	$rowus = mysql_fetch_row($stus);
	$remetemail = $rowus[0];
    $retnome  = $rowus[1];
}

$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;
$extensao = strtolower(end(explode('.', $arquivo['name'])));

$str = "UPDATE arquivos SET 
            NR_SEQ_CATEGORIA_AQRC = $categoria,
            DS_DESCRICAO_AQRC = '$descricao' 
            WHERE NR_SEQ_ARQUIVO_AQRC = $arqorig";
$st = mysql_query($str);

if ($arquivo["error"]==0){
    $str = "INSERT INTO arquivos_historico (
                NR_SEQ_ARQUIVO_AHRC,
                NR_SEQ_CATEG_AHRC,
                NR_SEQ_USER_AHRC,
                DS_ARQUIVO_AHRC,
                DS_DESCRICAO_AHRC,
                DT_ARQUIVO_AHRC,
                DS_NOMEORIG_AHRC,
                DS_EXT_AHRC,
                DT_ALTERAÇÃO_AHRC
    ) SELECT 
                NR_SEQ_ARQUIVO_AQRC,
                NR_SEQ_CATEGORIA_AQRC,
                NR_SEQ_USER_AQRC,
                DS_ARQUIVO_AQRC,
                DS_DESCRICAO_AQRC,
                DT_ARQUIVO_AQRC,
                DS_NOME_ORIG_AQRC,
                DS_EXT_AQRC,
                SYSDATE()
    FROM arquivos WHERE NR_SEQ_ARQUIVO_AQRC = $arqorig";
    $st = mysql_query($str);
    $id = mysql_insert_id();
    
    $str = "UPDATE arquivos SET 
                DT_ARQUIVO_AQRC = SYSDATE(),
                DS_EXT_AQRC = '$extensao',
                DS_NOME_ORIG_AQRC = '".$arquivo['name']."' 
                WHERE NR_SEQ_ARQUIVO_AQRC = $arqorig";
    $st = mysql_query($str);
    
    copy("arquivos/$arqorig.$extorig","arquivos/historico/$id.$extorig");
    
    $arquivo_nome = $arqorig . "." . $extensao;
    $arquivo_dir = "arquivos/" . $arquivo_nome;
    move_uploaded_file($arquivo["tmp_name"], $arquivo_dir);
    
    $sqlmin = "SELECT DS_ARQUIVO_AQRC, DS_NOME_ORIG_AQRC FROM arquivos WHERE NR_SEQ_ARQUIVO_AQRC = $arqorig";
	$stmin = mysql_query($sqlmin);
	$retnome = "";
	if (mysql_num_rows($stmin) > 0) {
		$rowmin = mysql_fetch_row($stmin);
		$retnome = utf8_decode($rowmin[0]." (".$rowmin[1].")");
	}
    
    $descricao = utf8_decode($descricao);
    
    $corpo = "<table width=\"557\" height=\"400\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">";
    $corpo .= "<tr><td width=\"557\" height=\"87\" valign=\"bottom\" colspan=\"3\"><img src=\"http://www.reverbcity.com/mailing/mail/images/top_mailing.gif\" width=\"557\" height=\"87\"></td>";
    $corpo .= "</tr><tr>";
    $corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "    <td><table width=\"100%\" cellpadding=\"3\" cellspacing=\"3\">";
    $corpo .= "        	<tr><td style=\"font-family:Arial, Helvetica, sans-serif;\" width=\"555\">";
    $corpo .= "        	<strong>Arquivo Modificado!</strong>";
    $corpo .= "        	<br /><br />";
    $corpo .= "        	O arquivo abaixo do sistema de arquivos Reverbcity foi alterado e você faz parte do mesmo:";
    $corpo .= "        	<br /><br />";
    $corpo .= "        	<strong>$retnome</strong><br />";
    $corpo .= "        	$descricao<br /><br />";
    $corpo .= "        	<a href=http://www.reverbcity.com/Readm_911s/arquivos.php>http://www.reverbcity.com/Readm_911s/arquivos.php</a><br /><br />";
    $corpo .= "        	Para baixar a nova versão acesse a área de arquivos da ADM Reverb<br /><br />";
    $corpo .= "        	Reverbcity System<br />";
    $corpo .= "        	www.reverbcity.com";
    $corpo .= "        	</td></tr>";
    $corpo .= "        </table></td>";
    $corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "</tr><tr>";
    $corpo .= "    <td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "    <td height=\"1\">&nbsp;</td>";
    $corpo .= "	<td width=\"1\" bgcolor=\"#7a6c61\"><img src=\"http://www.reverbcity.com/mailing/mail/images/x.gif\" width=\"1\" height=\"1\"></td>";
    $corpo .= "</tr><tr><td width=\"557\" height=\"26\" colspan=\"3\" valign=\"top\"><img src=\"http://www.reverbcity.com/mailing/mail/images/rod_mailing.gif\" usemap=\"#Map\" width=\"557\" height=\"26\" border=0></td>";
    $corpo .= "</tr></table>";
    
    $sql = "select DS_EMAIL_USRC from arquivos_rel, usuarios where NR_SEQ_USER_AURC = NR_SEQ_USUARIO_USRC and NR_SEQ_ARQUIVO_AURC = $arqorig";
    $st = mysql_query($sql);
    
    if (mysql_num_rows($st) > 0) {
        while($row = mysql_fetch_row($st)) {
            $email	   = $row[0];
            EnviaEmailNovo($remetemail,$retnome,$email,"","","Atualização de Arquivo Reverbcity", $corpo);
        }
    }
}

mysql_close($con);

Header("Location: arquivos.php");
exit();
?>