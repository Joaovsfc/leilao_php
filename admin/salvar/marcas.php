<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( $_POST ) {
        //recuperar os dados digitados
        $id = trim( $_POST["id"] ?? NULL );
        $marca = trim( $_POST["marca"] ?? NULL);

        //verificar se o nome não está em branco
        if ( empty( $marca ) ) {
            mensagemErro("Preencha o nome da marca");
        }

        //verificar se esta marca já não está cadastrada
        $sql = "select id from marca 
            where marca = :marca and id <> :id 
            limit 1";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":marca", $marca);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //verificar se trouxe algum resultado
        if ( !empty ( $dados->id ) ) {
            mensagemErro("Já existe uma marca cadastrada com este nome");
        }

        //verificar se irá inserir ou se irá atualizar
        if ( empty ( $id ) ) {
            $sql = "insert into marca (marca) values (:marca)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":marca", $marca);
        } else {
            $sql = "update marca set marca = :marca where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":marca", $marca);
            $consulta->bindParam(":id", $id);
        }

        if ( !$consulta->execute() ){
            mensagemErro("Não foi possível salvar os dados");
        }
        echo "<script>location.href='listar/marcas';</script>";
        exit;
    }

    //mostrar uma mensagem de erro
    mensagemErro("Requisição inválida");