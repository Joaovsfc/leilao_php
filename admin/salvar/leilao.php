<?php
    if ( !isset ($page) ) exit;

    if($_POST){
        $id_usuario      = $_SESSION['usuario']['id'];

        $id              = $_POST["id"]?? NULL;
        $titulo          = trim($_POST["titulo"] ?? NULL);
        $descricao       = trim($_POST["descricao"]?? NULL);
        $arremate        = isset($_POST["arremate"]);
        $valorArremate   = intval(trim($_POST["valorArremate"]?? NULL));
        $valorIncremento = intval(trim($_POST["incremento"]?? NULL));
        $valorInicial    = intval(trim($_POST["valorInicial"]?? NULL));
        $dtInicio        = trim($_POST["dtInicio"] ?? NULL);
        $dtFim           = trim($_POST["dtFim"] ?? NULL);

        $dtInicio != NULL ? $dtInicio = str_replace("T", " ",$dtInicio): NULL;
        $dtFim    != NULL ? $dtFim = str_replace("T", " ",$dtFim): NULL;

        if(empty($_SESSION)){
            echo "<script>mensagemErro('Sem usuario na seção favor fazer o login novamente.')</script>";
            exit;        
        }
        if(empty($titulo)){
            echo "<script>mensagemErro('Preencha o titulo do leilão!')</script>";
            exit;        
        }
        if(empty($descricao)){
            echo "<script>mensagemErro('Preencha a descrição do leilão!')</script>";
            exit;
        }
        if(empty($dtInicio)){
            echo "<script>mensagemErro('Preencha a data de inicio do leilão!')</script>";
            exit;
        }
        if(empty($dtFim)){
            echo "<script>mensagemErro('Preencha a data de fim do leilão!')</script>";
            exit;
        }
        if(empty($valorInicial)){
            echo "<script>mensagemErro('Preencha o valor inicial do leilão!')</script>";
            exit;
        }
        
        if(empty($id)){
            $sql = "INSERT INTO leilao (descricao, titulo, dt_inicio, dt_fim, is_arremate, step, valor_arremate, valor_inicial, valor_atual, id_usuario) values (:descricao, :titulo, :dt_inicio, :dt_fim, :is_arremate, :step, :valor_arremate, :valor_inicial, :valor_inicial, :id_usuario)";
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

            !empty($id) ?$consulta->bindParam(":id_leilao", $id) : NULL;
            

            if ( !$consulta->execute() ){
                mensagemErro("Não foi possível salvar os dados");
            }
        }

        echo "<script>location.href='listar/leilao';</script>";
        exit;
    }
mensagemErro("Requisição inválida");