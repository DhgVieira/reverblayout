<?php
include 'auth.php';
include 'lib.php'; 

$idt = request("idt");
$idf = request("idf");
$mensagem = request("msg");

$id_cad = $SS_logado;

if (!$mensagem){
	Header("Location: msgs.php?idt=$idt&idf=$idf");
    exit();
}

$mensagem = MontarLink($mensagem);

$mensagem = str_replace(":D","<img src=smiley/msn/teeth_smile.gif align=absmiddle>",$mensagem);
$mensagem = str_replace(":(","<img src=smiley/msn/sad_smile.gif align=absmiddle",$mensagem);
$mensagem = str_replace(";)","<img src=smiley/msn/wink_smile.gif align=absmiddle",$mensagem);
$mensagem = str_replace(":S","<img src=smiley/msn/confused_smile.gif align=absmiddle",$mensagem);
$mensagem = str_replace(":s","<img src=smiley/msn/confused_smile.gif align=absmiddle",$mensagem);
$mensagem = str_replace(":o","<img src=smiley/msn/omg_smile.gif align=absmiddle",$mensagem);
$mensagem = str_replace(":O","<img src=smiley/msn/omg_smile.gif align=absmiddle",$mensagem);
$mensagem = str_replace(":P","<img src=smiley/msn/tounge_smile.gif align=absmiddle",$mensagem);
$mensagem = str_replace(":p","<img src=smiley/msn/tounge_smile.gif align=absmiddle",$mensagem);

$str = "INSERT INTO msgs (NR_SEQ_TOPICO_MESO, NR_SEQ_CADASTRO_MESO, DT_CADASTRO_MESO, ST_MSG_MESO, DS_MSG_MESO) VALUES ($idt, $id_cad, sysdate(),'A','$mensagem')";
$st = mysql_query($str);

$str = "UPDATE topicos set NR_MSGS_TOSO = NR_MSGS_TOSO + 1 WHERE NR_SEQ_TOPICO_TOSO = $idt";
$st = mysql_query($str);

GravaLog($SS_logadm,end(explode("/", $_SERVER['PHP_SELF'])),"Incluiu mensagem no forum");

mysql_close($con);

Header("Location: msgs.php?idf=$idf&idt=$idt");
exit();

function MontarLink ($texto)
{
       if (!is_string ($texto))
           return false;
      
    $er = "/http:\/\/(www\.|.*?\/)?([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";
    preg_match_all ($er, $texto, $match);
    
    foreach ($match[0] as $link)
    {
        
        $link = strtolower ($link);
        if (strstr ($link, "http://") === false)
            $link = "http://" . $link;
           $link_len = strlen ($link);
        
        //troca "&" por "&", tornando o link v�lido pela W3C
        $web_link = str_replace ("&", "&", $link);
       $texto = str_ireplace ($link, "<a href=\"" . $web_link . "\" target=\"_blank\">". (($link_len > 60) ? substr ($web_link, 0, 25). "...". substr ($web_link, -15) : $link) ."</a>", $texto);
        
    }
    
    return $texto;
}
?>
