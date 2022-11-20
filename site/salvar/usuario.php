<?php

    if($_POST){
        var_dump($_POST);
        $nome        = trim($_POST['nome'] ?? null);
        $email       = trim($_POST['email'] ?? null);
        $senha       = trim($_POST['senha'] ?? null);
        $contraSenha = trim($_POST['contra_senha'] ?? null);

        if(!isset($email)){
            echo 'email n vazio';
            filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        

        var_dump('teste');
    }else{
        echo'não foi como post';
    }


?>