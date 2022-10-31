<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( empty ( $id ) ) {
        mensagemErro("Usuário inválido");
    }

    $sql = "select id, ativo from usuario where id = :id limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->execute();

    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    $ativo = "S";

    if ( $dados->ativo == "S" ) {

        $ativo = "N";

    }

    $sql = "update usuario set ativo = :ativo where id = :id limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(":id", $id);
    $consulta->bindParam(":ativo", $ativo);
    
    if ( $consulta->execute() ) {
        echo "<script>location.href='listar/usuarios'</script>";
        exit;
    } else {
        mensagemErro("Não foi possível alterar o status do usuário");
    }