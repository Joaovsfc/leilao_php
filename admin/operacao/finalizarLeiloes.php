<?php
    require "../../config.php";
    $dataAtual = date("Y-m-d H:i:s");

    $sqlPadrao = " SELECT l.*
    FROM leilao l 
    WHERE l.dt_inicio <= :dt_atual AND l.dt_fim < :dt_atual AND (l.in_finalizado = 0 OR l.id_ganhador is null)";
    $consulta = $pdo->prepare($sqlPadrao);
    $consulta->bindParam(":dt_atual", $dataAtual);  
    if($consulta->execute()){
        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){

            $sqlLance = "SELECT l.* FROM lance l WHERE l.id_lance = (SELECT MAX(id_lance) FROM lance lan WHERE lan.id_leilao = :id_leilao)";
            $consultaLance = $pdo->prepare($sqlLance);
            $consultaLance->bindParam(":id_leilao", $dados->id_leilao); 
            if($consultaLance->execute()){
                
                $dadosLance = $consultaLance->fetch(PDO::FETCH_OBJ);
                $sqlInsert = "UPDATE leilao SET id_ganhador = :id_ganhador, in_finalizado = 1, valor_lance = :valor_lance WHERE id_leilao = :id_leilao;";
                $insert = $pdo->prepare($sqlInsert);
                $insert->bindParam(":id_ganhador", $dadosLance->id_usuario); 
                $insert->bindParam(":id_leilao", $dadosLance->id_leilao); 
                $insert->bindParam(":valor_atual", $dadosLance->vl_lance); 
                $insert->execute();
                var_dump('executou até o fim');

            }
        }
    }
?>