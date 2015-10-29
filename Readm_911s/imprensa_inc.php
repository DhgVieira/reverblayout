<?php
include 'auth.php';
include 'lib.php';

$nome_post = request("nome_post");
$txt_imprensa  = request("FCKeditor1");
$linkfoto  = request("linkfoto");
$datapub   = request("datapub");
$link   = request("link");

if (!$datapub) {
    $datapub = date("Y-m-d G:i");
}else{
    $datapub = FormataDataMysql($datapub);
}

// $arquivo = isset($_FILES["FILE1"]) ? $_FILES["FILE1"] : FALSE;

if (!$nome_post){
	$msg = "Voce precisa informar o titulo do Post!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

if (!$txt_imprensa){
	$msg = "Voce precisa informar o texto do Post!";
	$msg = str_replace(" ","%20", $msg);
	Header("Location: erro.php?msg=$msg");
    exit();
}

$str = "INSERT INTO imprensa (titulo, post, data_post, link) VALUES 
						 ('$nome_post', '$txt_imprensa','$datapub', '$link')";

$st = mysql_query($str);
$id = mysql_insert_id();


if($_FILES['FILE1']['tmp_name'] != ""){
	$arquivo = $_FILES['FILE1']['name'];
	$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);

		
							
	$filename = md5(time() . rand(1000, 9999)) . ".". $extensao;

	$imagem_dir = "../arquivos/uploads/imprensa/" . $filename;

	move_uploaded_file($_FILES['FILE1']['tmp_name'], $imagem_dir);
						
	// Insere o registro
	try {
		$str2 = "UPDATE imprensa SET imagem_path = '".$filename."' WHERE idimprensa = $id";
		$st2 = mysql_query($str2);
	}
	catch(Exception $e) {
		die(var_dump($e));
	}
}

if($_FILES['FILE2']['tmp_name'] != ""){
	$arquivo = $_FILES['FILE2']['name'];
	$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);

		
							
	$filename = md5(time() . rand(1000, 9999)) . ".". $extensao;

	$imagem_dir = "../arquivos/uploads/imprensa/" . $filename;

	move_uploaded_file($_FILES['FILE2']['tmp_name'], $imagem_dir);
						
	// Insere o registro
	try {
		$str2 = "UPDATE imprensa SET imagem_path2 = '".$filename."' WHERE idimprensa = $id";
		$st2 = mysql_query($str2);
	}
	catch(Exception $e) {
		die(var_dump($e));
	}
}

if($_FILES['FILE3']['tmp_name'] != ""){
	$arquivo = $_FILES['FILE3']['name'];
	$extensao = pathinfo($arquivo, PATHINFO_EXTENSION);

		
							
	$filename = md5(time() . rand(1000, 9999)) . ".". $extensao;

	$imagem_dir = "../arquivos/uploads/imprensa/" . $filename;

	move_uploaded_file($_FILES['FILE3']['tmp_name'], $imagem_dir);
						
	// Insere o registro
	try {
		$str2 = "UPDATE imprensa SET imagem_path3 = '".$filename."' WHERE idimprensa = $id";
		$st2 = mysql_query($str2);
	}
	catch(Exception $e) {
		die(var_dump($e));
	}
}

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Inseriu Imprensa $nome_post");

mysql_close($con);

Header("Location: imprensa.php");

?>