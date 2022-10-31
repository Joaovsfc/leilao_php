<?php
    //se nao existir a variavel page
    if ( !isset ($page) ) exit;

    if ( empty ( $id ) ) {
    	mensagemErro("Registro inválido");
    }
    /* ******************************************************* */



    /* ******************************************************* */

    $sql = "";

    /* ******************************************************* */
    $consultamarca = $pdo->prepare($sql);
    $consultamarca->bindParam(":id", $id);

    //verificar se consegue executar
    if ( $consultamarca->execute() ){
    	//encaminhar para a tela de listagem
        echo "<script>location.href='listar/clientes';</script>";
        exit;
    } else {
    	mensagemErro("Não foi possível excluir o cliente");
    }
