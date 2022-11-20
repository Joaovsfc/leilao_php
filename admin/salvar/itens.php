<?php
    if ( !isset ($page) ) exit;

    if($_POST){
        $id_item = trim($_POST["id"] ?? NULL);
        $nome_item = trim($_POST["nome"]?? NULL);
        $descricao_item = trim($_POST["descricao"]?? NULL);
        $id_categoria_item = intval(trim($_POST["categoria"]?? NULL));
        $id_usuario = $_SESSION['usuario']['id'];

        $foto = $_FILES['foto']['name'] ?? NULL;
    
        if(empty($nome_item)){
            mensagemErro("Preencha o nome do item!");
        }
        if(empty($descricao_item)){
            echo "<script>mensagemErro('Preencha a descrição do item!')</script>";
            exit;
        }
        if(empty($id_categoria_item)){
            echo "<script>mensagemErro('Preencha a descrição do item!')</script>";
            exit;
        }
        if(empty($id_item)){
            $sql = "INSERT INTO item (nome, descricao, id_categoria, id_usuario) VALUES (:nome_item, :descricao_item, :id_categoria_item, :id_usuario)";
        }else{
            $sql = "UPDATE item SET nome = :nome_item, descricao = :descricao_item, id_categoria = :id_categoria_item WHERE id_item = :id_item;";
        }
        
        if(!empty($sql)){
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome_item", $nome_item);
            $consulta->bindParam(":descricao_item", $descricao_item);
            $consulta->bindParam(":id_categoria_item", $id_categoria_item);
            empty($id_item) ?$consulta->bindParam(":id_usuario", $id_usuario) : NULL;
            !empty($id_item) ?$consulta->bindParam(":id_item", $id_item) : NULL;
            
            if ( !$consulta->execute() ){
                mensagemErro("Não foi possível salvar os dados");
            }
        }

        echo "<script>location.href='listar/itens';</script>";
        exit;
    }
mensagemErro("Requisição inválida");