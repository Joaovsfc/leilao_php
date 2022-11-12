<?php

    //print_r($_POST);

    
    if (empty($id)) $id = $pdo->lastInsertId();

    $consulta = $pdo->prepare("SELECT * FROM `item` a WHERE a.id_item not in(SELECT b.id_item FROM leilao_itens b);");
    $consulta->execute();

    while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
        
        if ( isset($_POST["arremate{$dados->id_item}"])) {

            echo "{$dados->id_item} ta marcado";
        }
    }
                         