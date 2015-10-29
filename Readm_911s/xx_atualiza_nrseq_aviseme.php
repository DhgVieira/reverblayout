<?php
include 'auth.php';
include 'lib.php';
$sql = "select DS_EMAIL_AVRC, NR_SEQ_AVISEME_AVRC from aviseme where NR_SEQ_CADASTRO_AVRC is null";
$st = mysql_query($sql);

if (mysql_num_rows($st) > 0) {
  	while($row = mysql_fetch_row($st)) {
        $email = $row[0];
        $ida   = $row[1];
        $sql3 = "select NR_SEQ_CADASTRO_CASO from cadastros where DS_EMAIL_CASO = '$email'";
        $st3 = mysql_query($sql3);
        if (mysql_num_rows($st3) > 0) {
      	   $row3 = mysql_fetch_row($st3);
      	   $idc = $row3[0];
           $STR = "update aviseme set NR_SEQ_CADASTRO_AVRC = $idc where NR_SEQ_AVISEME_AVRC = $ida";
           $st3ST = mysql_query($STR);
        }
   }
}
echo "fimmmmmm";
mysql_close($con);
?>