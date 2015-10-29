<?php
include 'auth.php';

$texto = $_POST["html"]; 
$tipo = $_POST["tipo"];
$email = $_POST["email"];

if ($email){
    if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
    elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
    else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
     
    $nomeremetente     = "Reverbcity";
    $emailsender       = "contato@reverbcity.com";
    $emailremetente    = "contato@reverbcity.com";
    $emaildestinatario = $email;
    
    $headers = "MIME-Version: 1.1".$quebra_linha;
    $headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
    $headers .= "From: ".$emailsender.$quebra_linha;
    $headers .= "Return-Path: " . $emailsender . $quebra_linha;
    $headers .= "Reply-To: ".$emailremetente.$quebra_linha;
    
    @mail($emaildestinatario, "Reverbcity - Ponto Funcionário", $texto, $headers);
    
    ?>
    <script language="JavaScript">
       alert('Email enviado com Sucesso!');
       window.location.href=('ponto.php');
    </script>
    <?php
    exit();
}else{
    require ('../Readm_911s/html2fpdf/html2fpdf.php');
    
    $pdf=new HTML2FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',12);
    $pdf->WriteHTML($texto);
    $pdf->Output();	
}
exit();
?>