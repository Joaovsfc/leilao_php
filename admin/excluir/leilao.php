<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( empty ( $id ) ) {
    	mensagemErro("Registro inválido");
    }
    //verificar se o leilão está ativo 
    $sql = "SELECT * FROM leilao WHERE id_leilao = :id LIMIT 1";
    $consultamarca = $pdo->prepare($sql);
    $consultamarca->bindParam(":id", $id);
    $consultamarca->execute();
    $dados = $consultamarca->fetch(PDO::FETCH_OBJ);
    

    $dataInicio = strtotime($dados->dt_inicio);
    $dataFim = strtotime($dados->dt_fim);
    $dataAtual = date("Y-m-d H:i:s");
    if($dataFim < $dataAtual & $dados->in_finalizado){
        echo "<script>mensagemErroHistoryBack('Não é possivel excluir um leilão já concluido.');</script>";
    }elseif($dataInicio > $dataAtual & $dataFim < $dataAtual){
        echo "<script>mensagemErroHistoryBack('Não é possivel excluir um leilão em andamento.');</script>";
    }
    
    //excluir
    $sql = "DELETE FROM leilao WHERE id_leilao = :id LIMIT 1";
    $consultamarca = $pdo->prepare($sql);
    $consultamarca->bindParam(":id", $id);

    //verificar se consegue executar
    if (!$consultamarca->execute()){
        echo "<script>mensagemErroHistoryBack('Erro ao excluir leilão.');</script>";
    } 
    echo "<script>location.href='listar/leilao';</script>";
    exit;

 