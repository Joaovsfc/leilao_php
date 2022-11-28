<?php
    require "../../config.php";

    
    if($_POST){
        $id_remetente = trim($_POST['id_remetente']);
        $id_destinatario = trim($_POST['id_destinatario']);
        $mensagem = trim($_POST['str_mensagem']);
        $dataAtual = date("Y-m-d H:i:s");
        $dataAtual != NULL ? $dataAtual = str_replace("T", " ",$dataAtual): NULL;
     
        if(!empty($mensagem)){
            $sql = "INSERT INTO mensagem (id_destinatario, id_remetente, mensagem, dt_mensagem) VALUES (:id_destinatario, :id_remetente, :mensagem, :dt_mensagem)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":id_destinatario", $id_destinatario);
            $consulta->bindParam(":id_remetente", $id_remetente);
            $consulta->bindParam(":mensagem", $mensagem);
            $consulta->bindParam(":dt_mensagem", $dataAtual);

            if(!$consulta->execute()){
                echo "<script>mensagemErroHistoryBack('Erro aao gravar mensagem!')</script>";
            }else{
                echo "OK";
            }
        }
        
    }

?>