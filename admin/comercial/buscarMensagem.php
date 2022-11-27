<?php
    if($_POST){
        $id_leilao = trim($_POST['id_leilao']);
        $dataAtual = date("Y-m-d H:i:s");
        $dataAtual != NULL ? $dataAtual = str_replace("T", " ",$dataAtual): NULL;

        $sql = "SELECT m.*, u.nome FROM mensagem  m JOIN usuario u ON m.id_remetente = u.id_usuario WHERE m.id_leilao = :id_leilao ORDER BY m.dt_mensagem ASC;";
        //$sql = "SELECT * FROM mensagem WHERE id_leilao = :id_leilao ORDER BY ";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam('id_leilao', $id_leilao);

        if(!$consulta->execute()){
            echo "<script>mensagemErroHistoryBack('Erro aao gravar mensagem!')</script>";
        }
        
        while ($msgs = $consulta->fetch(PDO::FETCH_OBJ)){
            $msgs->id_remetente == $_SESSION['usuario']['id'] ? $nome = 'Você' : $nome = $msgs->nome;
            $textArea = ($textArea.''.$nome.': '.$msgs->mensagem.'&#10;');
        }

        echo '<div id="div_retorno_mensagens">'.$textArea.'</div>';

        //$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        
    }

?>