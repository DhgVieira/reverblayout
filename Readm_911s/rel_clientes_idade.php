<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" />
        <meta charset="UTF-8">
        <title>Relatório de clientes por idade</title>
        <style>
            body {
                font-family:Calibri, Helvetica, sans-serif;
                font-size: 14px;
            }
            .oculta {
                display: none;
            }
        </style>
        <script type="text/javascript" src="scripts/autocomplete/jquery-1.4.2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.titulo_idade').click(function(){
                    var idade = $(this).attr('id');
                    $('.tr_' + idade).toggleClass('oculta');
                });
                $('.header_idade').each(function(){
                    var idade2 = $(this).parent().parent().attr('id');
                    $(this).text($(this).text() + ' (' + $('.tr_' + idade2).length + ' cadastros)');
                })
            });
        </script>
    </head>
    <body>
        <table align="center">
            <tr>
                <td align="center" colspan="3"><strong style="font-size: 25px;">Relatório de clientes por idade</strong></td>
            </tr>
        <?php
            include 'lib.php';
            include 'auth.php';

            $str = "SELECT 
                        TIMESTAMPDIFF(YEAR,
                            DT_NASCIMENTO_CASO,
                            CURDATE()) AS idade,
                        DS_NOME_CASO AS nome,
                        DS_EMAIL_CASO AS email
                    FROM
                        cadastros
                    WHERE
                        DT_NASCIMENTO_CASO IS NOT NULL
                            AND DT_NASCIMENTO_CASO <> '0000-00-00'
                            AND YEAR(DT_NASCIMENTO_CASO) <= YEAR(CURDATE())
                            AND YEAR(DT_NASCIMENTO_CASO) >= '1900'
                    ORDER BY idade";

            $st = mysql_query($str);
            if (mysql_num_rows($st) > 0) {

                $idade = '';

                while($row = mysql_fetch_row($st)) {
                    if($idade != $row[0]){
                        ?>
                            <tr bgcolor="silver" id="<?php echo $row[0]; ?>" class="titulo_idade">
                                <td colspan="2" align="center"><strong class="header_idade" style="cursor: pointer;"><?php echo $row[0]; ?> anos</strong></td>
                            </tr>
                            <tr bgcolor="#DFDFDF" class="oculta tr_<?php echo $row[0] ?>">
                                <td align="left"><?php echo utf8_encode($row[1]); ?></td>
                                <td align="left"><?php echo $row[2]; ?></td>
                            </tr>
                        <?php
                    }else{
                        ?>
                            <tr bgcolor="#DFDFDF" class="oculta tr_<?php echo $row[0] ?>">
                                <td align="left"><?php echo utf8_encode($row[1]); ?></td>
                                <td align="left"><?php echo $row[2]; ?></td>
                            </tr>
                        <?php
                    }

                    $idade     = $row[0];
                }
            }
        ?>
<?php mysql_close($con); ?>