<?php
    require "../../config.php";

    if($_POST){
        $id_leilao = trim($_POST['id_leilao']);

        $dataAtual = date("Y-m-d H:i:s");
        $dataAtual != NULL ? $dataAtual = str_replace("T", " ",$dataAtual): NULL;

        $sql = "SELECT l.*, u.nome FROM lance l JOIN usuario u ON l.id_usuario = u.id_usuario WHERE l.id_lance = (SELECT MAX(id_lance) FROM `lance` WHERE id_leilao = :id_leilao);";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam('id_leilao', $id_leilao);
        

        if(!$consulta->execute()){
            echo "<script>alert('Erro ao buscar maior lance!')</script>";
        }

        $dados = $consulta->fetch(PDO::FETCH_OBJ);
        $array = array(
            'id_lance'=>$dados->id_lance,
            'id_usuario'=>$dados->id_usuario,
            'id_leilao'=>$dados->id_leilao,
            'vl_lance'=>$dados->vl_lance,
            'dt_lance'=>$dados->dt_lance,
            'nm_usuario'=>$dados->nome,
        );

        echo (json_encode($array));
    }
    

