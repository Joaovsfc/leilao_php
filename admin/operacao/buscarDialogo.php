<?php
    require "../../config.php";

    if($_POST){
        $id_destinatario = trim($_POST['id_destinatario']);
        $id_remetente = trim($_POST['id_remetente']);
        $dataAtual = date("Y-m-d H:i:s");
        $dataAtual != NULL ? $dataAtual = str_replace("T", " ",$dataAtual): NULL;
        
        $sql = "SELECT m.*, u.nome FROM mensagem m JOIN usuario u on m.id_remetente = u.id_usuario where (m.id_remetente = :id_remetente and m.id_destinatario = :id_destinatario) OR (m.id_remetente = :id_destinatario and m.id_destinatario = :id_remetente) ORDER BY m.dt_mensagem ASC";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam('id_destinatario', $id_destinatario);
        $consulta->bindParam('id_remetente', $id_remetente);
        if(!$consulta->execute()){
            echo "<script>mensagemErroHistoryBack('Erro aao gravar mensagem!')</script>";
        }
        $textArea = '';
        
        while ($msgs = $consulta->fetch(PDO::FETCH_OBJ)){
            $msgs->id_remetente ==  $id_remetente ? $nome = 'Você' : $nome = $msgs->nome;
            $textArea .= "{$nome}: {$msgs->mensagem} <br>";
        }

        echo ($textArea);
    }
    

