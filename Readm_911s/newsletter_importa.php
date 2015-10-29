<?php
ini_set("max_execution_time","360");
ini_set("memory_limit","16M");
set_time_limit(360);
error_reporting(0);

include 'auth.php';
include 'lib.php';

$grupo = request("grupo");
$arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

$tot1 = 0;
$tot2 = 0;
$tot3 = 0;

if($arquivo["name"])
{	
	$arq_dir = "temp/" . $arquivo["name"];
	move_uploaded_file($arquivo["tmp_name"], $arq_dir);

	$ponteiro = fopen($arq_dir, "r");

	while (!feof ($ponteiro)) {
	  $linha = str_replace("'","",$linha);
	  $linha = str_replace("\"","",$linha);
	  $linha = str_replace("\t","",$linha);
	  $linha = trim(fgets($ponteiro, 4096));
	  $nome = "";
	  $email = "";
	  
	  if ($linha) {
		  if (strpos($linha,";") > 0) {
			$dados = explode(";", $linha);
			$email = $dados[0];
			$nome = $dados[1];
		  }else{
			$email = $linha ;
		  }
		  
		  //$sql = "select DS_EMAIL_CASO from cadastros WHERE DS_EMAIL_CASO = '$email'";
		  //$st = mysql_query($sql);
			
		  //if (mysql_num_rows($st) <= 0) {
			//$sql2 = "select IdAssinante from Assinante WHERE Email = '$email'";
			//$st2 = mysql_query($sql2);
			
			//if (mysql_num_rows($st2) > 0) {
			//	$row = mysql_fetch_row($st2);
			//	$idassi = $row[0];
			//	$str = "delete from AssinanteGrupo where IdAssinante = $idassi";
			//	$std = mysql_query($str);
						
			//	$str = "INSERT INTO AssinanteGrupo (IdAssinante, IdGrupo) values ($idassi, $grupo)";
			//	$std = mysql_query($str);
				
			//	$tot2++;
			//}else{
				$str = "INSERT INTO Assinante (Nome, Email) values ('$nome', '$email')";
				$std = mysql_query($str);
				$id = mysql_insert_id();
				
				$str = "INSERT INTO AssinanteGrupo (IdAssinante, IdGrupo) values ($id, $grupo)";
				$std = mysql_query($str);
				$tot3++;
			//}
		  //}else{
		  //	$tot1++;
		  //}
		}
	}
	
	fclose ($ponteiro);
	
	if (file_exists($arq_dir)) unlink($arq_dir);
	
	$totg = $tot1+$tot2+$tot3;
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Importou Mailing");
?>
<script language="JavaScript">
   alert('Importação Finalizada!\n\nTotal de E-Mails processados: <?php echo $totg ?>\nTotal de E-mails que já existiam: <?php echo $tot1+$tot2 ?>\nTotal de E-Mails novos inseridos: <?php echo $tot3 ?>');
   top.window.location.href=('newsletter_grpemail.php?idg=<?php echo $grupo ?>');
</script>
<?
mysql_close($con);
exit();
?>