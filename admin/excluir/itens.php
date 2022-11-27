<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( empty ( $id ) ) {
        echo "<script>mensagemErroHistoryBack('Registro inválido');</script>";

    }
    //verificar se o item não está em um leilão ativo 
    $sql = "SELECT * FROM leilao_itens WHERE id_item = :id LIMIT 1";
    $consultamarca = $pdo->prepare($sql);
    $consultamarca->bindParam(":id", $id);
    $consultamarca->execute();
    if(!empty($consultamarca->fetch(PDO::FETCH_OBJ))){
        echo "<script>mensagemErroHistoryBack('Este item não pode ser excluido pois já está vinculado a um leilão.');</script>";
        exit;
    }
    //excluir
    $sql = "DELETE FROM item WHERE id_item = :id LIMIT 1";
    $consultamarca = $pdo->prepare($sql);
    $consultamarca->bindParam(":id", $id);

    //verificar se consegue executar
    if (!$consultamarca->execute()){
    	mensagemErroHistoryBack("Não foi possível excluir o Item");
    } 
    echo "<script>location.href='listar/itens';</script>";
    exit;
