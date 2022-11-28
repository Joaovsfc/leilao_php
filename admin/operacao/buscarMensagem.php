<?php
    require "../../config.php";

    if($_POST){
        $id_leilao = trim($_POST['id_leilao']);
        $id_usuario = $_SESSION['usuario']['id'];
        $dataAtual = date("Y-m-d H:i:s");
        $dataAtual != NULL ? $dataAtual = str_replace("T", " ",$dataAtual): NULL;
        $sql = "SELECT m.*, u.nome FROM mensagem  m JOIN usuario u ON m.id_remetente = u.id_usuario WHERE m.id_leilao = :id_leilao ORDER BY m.dt_mensagem ASC;";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam('id_leilao', $id_leilao);
        if(!$consulta->execute()){
            echo "<script>mensagemErroHistoryBack('Erro aao gravar mensagem!')</script>";
        }
        $textArea = '';
        
        while ($msgs = $consulta->fetch(PDO::FETCH_OBJ)){
            $msgs->id_remetente ==  $id_usuario ? $nome = 'Você' : $nome = $msgs->nome;
            //$textArea = $textArea.''.$nome.': '.$msgs->mensagem.' ';
            $textArea .= "{$nome}: {$msgs->mensagem} <br>";
        }

        echo ($textArea);
    }
    

