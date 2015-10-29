<?php

require 'dbconfig.php';

class User {

    function checkUser($uid, $oauth_provider, $username){

        //inicio o model
        $query = mysql_query("SELECT * FROM `cadastros` WHERE  NR_IDTWITTER_CASO = '$uid'") or die(mysql_error());


        $result = mysql_fetch_array($query);
        if (!empty($result)) {
            //se estiver vazio o usuário já tem um cadastro
        } else {
           //se nao tiver usuario insiro o resultado
            $query = mysql_query("INSERT INTO 
                                `cadastros` 
                                    (NR_IDTWITTER_CASO, 
                                    DS_NOME_CASO, 
                                    ST_CADASTRO_CASO, 
                                    DS_TIPO_CASO, 
                                    ST_CADASTROCOMPLETO_CASO,
                                    DS_SENHA_CASO) 
                                VALUES 
                                    ($uid, 
                                    '$username', 
                                    'PF', 
                                    'A', 
                                    0,
                                    '$uid')")
                                or die(mysql_error());
              
            $query = mysql_query("SELECT * FROM `cadastros` WHERE  NR_IDTWITTER_CASO = '$uid'");
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }

    

}

