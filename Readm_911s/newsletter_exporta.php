<?php 
//<!-- //***** -->
//<!-- SALVA EM ARQUIVO O GRUPO DE EMAIL SELECIONADO -->
include 'auth.php';
include 'lib.php';

$grupo2 = request("grupo2");
$arq = 'temp/email.txt';
$handle = fopen($arq,"w+");

if ($handle){	
	$num=0;
	if ($grupo2 <> 0) { // SALVA SOMENTE OS ASSINATNE DO GRUPO ESCOLHIDO
		$sql = "select a.Nome, a.Email from Assinante AS a, AssinanteGrupo AS b where b.IdGrupo='$grupo2' and b.IdAssinante=a.IdAssinante";
		$st = mysql_query($sql);
			if(mysql_num_rows($st) > 0){
				while($row = mysql_fetch_row($st)){
					$nome = $row[0];	
					$email = $row[1];
					$num++;
					fwrite($handle,$nome.','.$email.";\n");
					//echo 'nome: '.$nome.' email: '.$email."<br>";
				} // FIM WHILE
			}  // FIM IF
	} // FIM IF
	else { // SALVA TODOS AS ASSINANTES
		$sql = "select a.Nome, a.Email from Assinante AS a";
		$st = mysql_query($sql);
			if(mysql_num_rows($st) > 0){
				while($row = mysql_fetch_row($st)){
					$nome = $row[0];	
					$email = $row[1];
					$num++;
					fwrite($handle,$nome.','.$email.";\n");
					//echo 'nome: '.$nome.' email: '.$email."<br>";
				} // FIM WHILE
			}  // FIM IF
	} //FIM ELSE
	fclose($handle);
?>	<a href="temp/email.txt"> Download </a> <?
} // FIM IF
else{
 echo "Falha ao abrir o arquivo!";
}

?>

<?php /*?><script language="JavaScript">
   alert('Exportação Finalizada!\n\nExportados: <?php echo $num; ?> e-mails.\n Salvo no arquivo: <?php echo $arq;?>');
   top.window.location.href=('newsletter.php?aba=5');
</script><?php */?>
<?
mysql_close($con);
exit();
//<!-- //***** -->
?>