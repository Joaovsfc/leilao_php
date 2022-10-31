<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( $_POST ) {
        //recuperar os dados digitados
        $id = trim( $_POST["id"] ?? NULL );
        $nome = trim( $_POST["nome"] ?? NULL);

        //verificar se o nome não está em branco
        if ( empty( $nome ) ) {
            mensagemErro("Preencha o nome do cliente");
        }

        //verificar se irá inserir ou se irá atualizar
        if ( empty ( $id ) ) {
            $sql = "insert into cliente (nome) values (:nome)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
        } else {
            $sql = "update cliente set nome = :nome where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome", $nome);
            $consulta->bindParam(":id", $id);
        }

        if ( !$consulta->execute() ){
            mensagemErro("Não foi possível salvar os dados");
        }
        echo "<script>location.href='listar/clientes';</script>";
        exit;
    }

    //mostrar uma mensagem de erro
    mensagemErro("Requisição inválida");