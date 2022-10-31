<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( $_POST ) {

        //recuperar os dados enviados
        foreach ( $_POST as $key => $value ) {
            //echo "<p>$key - $value</p>";
            $$key = trim ( $value ?? NULL );
        }

        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            mensagemErro("Digite um e-mail válido");
        } else if ( $senha != $senha2 ) {
            mensagemErro("As senhas digitadas não são iguais");
        }

        //se já existe um usuário cadastrado com este login
        $sql = "select id from usuario where login = :login AND
        id <> :id limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":login", $login);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( !empty ($dados->id ) ) {
            mensagemErro("Já existe um usuário com este login");
        }

        if ( empty ( $id ) ) {
            
            //inserir no banco

            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "insert into usuario (nome, login, email, senha, ativo) values (:nome, :login, :email, :senha, :ativo)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":login", $login);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":senha", $senha);
            $consulta->bindParam(":ativo", $ativo);

        } else if ( empty ($senha ) ) {

            //fazer o update, mas sem a senha

            $sql = "update usuario set nome = :nome, email = :email, login = :login, ativo = :ativo where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":login", $login);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":ativo", $ativo);
            $consulta->bindParam(":id", $id);

        } else {

            //fazer update com a senha

            $senha = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "update usuario set nome = :nome, email = :email, login = :login, ativo = :ativo, senha =:senha where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":login", $login);
            $consulta->bindParam(":email", $email);
            $consulta->bindParam(":ativo", $ativo);
            $consulta->bindParam(":senha", $senha);
            $consulta->bindParam(":id", $id);

        }

        if ( $consulta->execute() ) {
            echo "<script>location.href='listar/usuarios';</script>";
        } else {
            mensagemErro("Não foi possível salvar o registro");
        }

    }