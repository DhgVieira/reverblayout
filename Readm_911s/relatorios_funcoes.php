<?php
include 'lib.php';
$corpo = request("texto");
$tipo = request("tipo");
$email = request("email");
$aba = request("aba"); 
$assunto = request("assunto");
//echo $tipo;
//echo $assunto.'<br>'.$corpo;
if ($tipo == "Enviar"){	
	if ($email){
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n";
		$headers .= "From: compras@reverbcity.com\r\n";
		$headers .= "Return-Path: compras@reverbcity.com\r\n";

		mail($email,$assunto,$corpo,$headers);
		//echo '<br>'.$email.'<br>email enviado';
		Header("Location: relatorios.php?aba=$aba");
		exit();
	}
	
}
else if ($tipo == "Gerar PDF"){
require ('../Readm_911s/html2fpdf/html2fpdf.php');

$pdf=new HTML2FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->WriteHTML(utf8_decode($corpo));
$pdf->Output();	
}

?>