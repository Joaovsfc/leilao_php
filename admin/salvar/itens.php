<?php
    if ( !isset ($page) ) exit;

    if($_POST){
        $id_item = trim($_POST["id"] ?? NULL);
        $nome_item = trim($_POST["nome"]?? NULL);
        $descricao_item = trim($_POST["descricao"]?? NULL);
        $id_categoria_item = intval(trim($_POST["categoria"]?? NULL));
        $id_usuario = $_SESSION['usuario']['id'];

        $caminho_apagar = trim($_POST["caminho_apagar"]?? NULL);
        $foto = $_FILES["foto"]["name"] ?? NULL;
        //$foto == NULL ? $foto = $caminho_apagar: NULL;
        
        if(empty($nome_item)){
            mensagemErroHistoryBack("Preencha o nome do item!");
        }
        if(empty($descricao_item)){
            echo "<script>mensagemErroHistoryBack('Preencha a descrição do item!')</script>";
            exit;
        }
        if(empty($id_categoria_item)){
            echo "<script>mensagemErroHistoryBack('Preencha a descrição do item!')</script>";
            exit;
        }
        if(empty($foto) & empty($id_item)){
            echo "<script>mensagemErroHistoryBack('Favor selecionar uma imagem!')</script>";
            exit;
        }
        elseif(!empty($foto)){
            $foto = time()."_{$foto}";
            if(!move_uploaded_file($_FILES["foto"]["tmp_name"], "../imagens/{$foto}")){
                echo "<script>mensagemErroHistoryBack('Erro aao copiar arquivo!')</script>";
                exit;
            }
        }      
        if(empty($id_item)){
            $sql = "INSERT INTO item (nome, descricao, id_categoria, id_usuario) VALUES (:nome_item, :descricao_item, :id_categoria_item, :id_usuario)";
        }else{
            $sql = "UPDATE item SET nome = :nome_item, descricao = :descricao_item, id_categoria = :id_categoria_item WHERE id_item = :id_item;";
        }
        
        if(!empty($sql)){
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":nome_item", $nome_item);
            $consulta->bindParam(":descricao_item", $descricao_item);
            $consulta->bindParam(":id_categoria_item", $id_categoria_item);
            empty($id_item) ?$consulta->bindParam(":id_usuario", $id_usuario) : NULL;
            !empty($id_item) ?$consulta->bindParam(":id_item", $id_item) : NULL;
            
            if ( !$consulta->execute() ){
                mensagemErroHistoryBack("Não foi possível salvar os dados");
            }
            if (empty($id_item)) $id_item = $pdo->lastInsertId();

            if(!empty($foto)){
                $sqlFoto = "DELETE FROM imagem WHERE id_item = :id_item;";
                $consulta = $pdo->prepare($sqlFoto);
                $consulta->bindParam("id_item", $id_item);
                if(!$consulta->execute()){
                    mensagemErroHistoryBack("Não foi possível remover os dados da foto.");
                }     
                if(!empty($caminho_apagar)){
                    if(!unlink('../imagens/'.$caminho_apagar)){
                        mensagemErroHistoryBack("Não foi possível remover os dados da foto do servidor.");
                    } 
                }
                 
                $sqlFoto = "INSERT INTO imagem (id_item, caminho) VALUES (:id_item, :caminho);";
                $consulta = $pdo->prepare($sqlFoto);
                $consulta->bindParam(":id_item", $id_item);
                $consulta->bindParam(":caminho", $foto);
                if(!$consulta->execute()){
                    mensagemErroHistoryBack("Não foi possível salvar os dados da foto.");
                } 
            }
        }

        echo "<script>location.href='listar/itens';</script>";
        exit;
    }
mensagemErroHistoryBack("Requisição inválida");