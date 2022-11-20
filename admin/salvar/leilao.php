<?php

    //print_r($_POST);
    if(!isset($page)) exit;
    
    if($_POST){    
        $id_usuario = $_SESSION['usuario']['id'];
        $itens      = [];

        $id              = $_POST["id"]?? NULL;
        $titulo          = trim($_POST["titulo"] ?? NULL);
        $descricao       = trim($_POST["descricao"]?? NULL);
        $arremate        = isset($_POST["arremate"]);
        $valorArremate   = intval(trim($_POST["valorArremate"]?? NULL));
        $valorIncremento = intval(trim($_POST["incremento"]?? NULL));
        $valorInicial    = intval(trim($_POST["valorInicial"]?? NULL));
        $dtInicio        = trim($_POST["dtInicio"] ?? NULL);
        $dtFim           = trim($_POST["dtFim"] ?? NULL);
        //Conversão para o padrão para gravar no BD
        $dtInicio != NULL ? $dtInicio = str_replace("T", " ",$dtInicio): NULL;
        $dtFim    != NULL ? $dtFim = str_replace("T", " ",$dtFim): NULL;

        if(empty($_SESSION)){
            echo "<script>mensagemErroHistoryBack('Sem usuario na seção favor fazer o login novamente.')</script>";
            exit;        
        }
        if(empty($titulo)){
            echo "<script>mensagemErroHistoryBack('Preencha o titulo do leilão!')</script>";
            exit;        
        }
        if(empty($descricao)){
            echo "<script>mensagemErroHistoryBack('Preencha a descrição do leilão!')</script>";
            exit;
        }
        if(empty($dtInicio)){
            echo "<script>mensagemErroHistoryBack('Preencha a data de inicio do leilão!')</script>";
            exit;
        }
        if(empty($dtFim)){
            echo "<script>mensagemErroHistoryBack('Preencha a data de fim do leilão!')</script>";
            exit;
        }
        if(empty($valorInicial)){
            echo "<script>mensagemErroHistoryBack('Preencha o valor inicial do leilão!')</script>";
            exit;
        }

        $consulta = $pdo->prepare("SELECT * FROM `item` a WHERE id_usuario = :id_usuario AND a.id_item NOT IN(SELECT b.id_item FROM leilao_itens b WHERE b.id_leilao <> :id_leilao);");
        $consulta->bindParam(":id_usuario", $id_usuario);
        $consulta->bindParam(":id_leilao", $id);
        $consulta->execute();

        while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
            echo " $dados->id_item -";
            if (isset($_POST["arremate{$dados->id_item}"])) {
                array_push($itens,$dados->id_item);
            }
        }

        if(empty($itens)){
            echo "<script>
                    mensagemErroHistoryBack('Nenhum item selecionado para o leilão!');
                 </script>";
            exit;
        }


        //if (empty($id)) $id = $pdo->lastInsertId();
        //Gravação no banco de dados 
        
        if(empty($id)){
            $sql = "INSERT INTO leilao (descricao, titulo, dt_inicio, dt_fim, is_arremate, step, valor_arremate, valor_inicial, valor_atual, id_usuario) VALUES (:descricao, :titulo, :dt_inicio, :dt_fim, :is_arremate, :step, :valor_arremate, :valor_inicial, :valor_inicial, :id_usuario)";
        }else{
            $sql = "UPDATE leilao SET descricao = :descricao, titulo = :titulo, dt_inicio = :dt_inicio, dt_fim = :dt_fim, is_arremate = :is_arremate, step = :step, valor_arremate = :valor_arremate, valor_inicial = :valor_inicial, valor_atual = :valor_inicial  WHERE id_leilao = :id_leilao;";
        }

        if(!empty($sql)){
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":titulo", $titulo);
            $consulta->bindParam(":descricao", $descricao);
            $consulta->bindParam(":dt_inicio", $dtInicio);
            $consulta->bindParam(":dt_fim", $dtFim);
            $consulta->bindParam(":is_arremate", $arremate);
            $consulta->bindParam(":step", $valorIncremento);
            $consulta->bindParam(":valor_arremate", $valorArremate);
            $consulta->bindParam(":valor_inicial", $valorInicial);
            $consulta->bindParam(":id_usuario", $id_usuario);

            empty($id) ?$consulta->bindParam(":id_usuario", $id_usuario) : NULL;
            !empty($id) ?$consulta->bindParam(":id_leilao", $id) : NULL;
            

            if (!$consulta->execute() ){
                mensagemErro("Não foi possível salvar os dados");
            }
            if (empty($id)) $id = $pdo->lastInsertId();

            if(substr($sql, 0, 6) == 'UPDATE');{
                $sql = "DELETE FROM leilao_itens WHERE id_leilao = :id_leilao;";
                $consulta = $pdo->prepare($sql);
                $consulta->bindParam(":id_leilao", $id);
                if(!$consulta->execute() ){
                    echo "<script>mensagemErroHistoryBack('Falha ao execitar o SQL.')</script>"; 
                }
            }
            $count = 0;
                foreach($itens as &$idItem){
                    $sql = "INSERT INTO leilao_itens (id_leilao, id_item) VALUES (:id_leilao, :id_item);";
                    $consulta = $pdo->prepare($sql);
                    $consulta->bindParam(":id_leilao", $id);
                    $consulta->bindParam(":id_item", $idItem);
                    if(!$consulta->execute() ){
                        echo "<script>mensagemErroHistoryBack('Falha ao executar o SQL.')</script>"; 
                    }
                    $count = $count +1;
                }
            echo "<script>location.href='listar/leilao';</script>";
            exit;
        }else{
            echo "<script>mensagemErroHistoryBack('Falha ao carregar o SQL.')</script>";
        }
    }
                         