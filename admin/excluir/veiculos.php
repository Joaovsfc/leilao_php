<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    //selecionar as imagens
    $sql = "select foto from veiculo
        where id = :id limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(':id', $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $foto = "../imagens/{$dados->foto}";

    //sql para excluir
    $sql = "delete from veiculo where id = :id limit 1";
    $consultaveiculo= $pdo->prepare($sql);
    $consultaveiculo->bindParam(":id", $id);
    
    //verificar se consegue executar
    if ( $consultaveiculo->execute() ){
        //excluir os arquivos
        if ( file_exists ( $foto ) ) {
            unlink($foto);
        }
        //encaminhar para a tela de listagem
        echo "<script>location.href='listar/veiculos';</script>";
        exit;
    }

    mensagemErro('Não foi possível excluir');
