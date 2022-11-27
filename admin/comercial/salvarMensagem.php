<?php
    if ( !isset ($page) ) exit;

    if($_POST){
        $id_remetente = trim($_POST['id_remetente']);
        $id_leilao = trim($_POST['id_leilao']);
        $mensagem = trim($_POST['str_mensagem']);
        $dataAtual = date("Y-m-d H:i:s");
        $dataAtual != NULL ? $dataAtual = str_replace("T", " ",$dataAtual): NULL;

        
        $sql = "INSERT INTO mensagem (id_leilao, id_remetente, mensagem, dt_mensagem) VALUES (:id_leilao, :id_remetente, :mensagem, :dt_mensagem)";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(":id_leilao", $id_leilao);
        $consulta->bindParam(":id_remetente", $id_remetente);
        $consulta->bindParam(":mensagem", $mensagem);
        $consulta->bindParam(":dt_mensagem", $dataAtual);
        if(!$consulta->execute()){
            echo "<script>mensagemErroHistoryBack('Erro aao gravar mensagem!')</script>";
        }  
    }

?>