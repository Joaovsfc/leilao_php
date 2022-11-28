<?php
    require "../../config.php";

    if($_POST){
        $id_usuario = trim($_POST['id_usuario']);
        $id_leilao = trim($_POST['id_leilao']);
        $vl_lance = trim($_POST['vl_lance']);
        $in_arremate = trim($_POST['in_arremate']);
        $dataAtual = date("Y-m-d H:i:s");
        $dataAtual != NULL ? $dataAtual = str_replace("T", " ",$dataAtual): NULL;
        $erro = false;
        $msgErro = 'OK';

        $sql = "SELECT l.*, lei.step, lei.id_usuario AS id_leiloeiro FROM lance l JOIN leilao lei ON l.id_leilao = lei.id_leilao WHERE l.id_lance = (SELECT MAX(id_lance) FROM `lance` WHERE id_leilao = :id_leilao);";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam('id_leilao', $id_leilao);

        if(empty($vl_lance)){
            $msgErro = 'Digite um valor valido.';
            $erro = true;
        } 

        if(!$consulta->execute()){
            $msgErro = 'Erro ao buscar maior lance anterior.';
            $erro = true;
        }

        if($dados = $consulta->fetch(PDO::FETCH_OBJ)){
            if($dados->id_leiloeiro == $id_usuario) {
                $msgErro = 'Leiloeiro não pode dar lance no proprio leilão.';
                $erro = true;
            }elseif($dados->vl_lance >= $vl_lance) {
                $msgErro = 'Lance ofertado menor ou igual ao maior lance anterior.';
                $erro = true;
            }elseif(($vl_lance%$dados->step) != 0) {
                $msgErro = 'Lance ofertado não respeitou o step de lance.';
                $erro = true;
            }
        }
        
        $sqlLeilao = "SELECT * FROM leilao l WHERE l.id_leilao = :id_leilao ;";
        $consultaLeilao = $pdo->prepare($sqlLeilao);
        $consultaLeilao->bindParam('id_leilao', $id_leilao);
        $consultaLeilao->execute();
        $dadosLeilao = $consultaLeilao->fetch(PDO::FETCH_OBJ);

        if($dadosLeilao->in_finalizado != 0 & $dadosLeilao->is_arremate == '0'){
            $msgErro = 'Leilão não permite arremate.';
            $erro = true;
        }
        
        if($erro){
            $array = array(
                'erro'=>$erro,
                'msg'=>$msgErro,
            );
        }else{
            $sql = "INSERT INTO lance (id_leilao, id_usuario, vl_lance, dt_lance) VALUES (:id_leilao, :id_usuario, :vl_lance, :dt_lance)";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":id_leilao", $id_leilao);
            $consulta->bindParam(":id_usuario", $id_usuario);
            $consulta->bindParam(":vl_lance", $dadosLeilao->valor_arremate);
            $consulta->bindParam(":dt_lance", $dataAtual);

            if(!$consulta->execute()){
                $msgErro = 'Erro ao gravar lance.';
                $erro = true;            
            }
            
            $sql = "UPDATE leilao SET valor_atual = :valor_atual, id_ganhador = :id_ganhador, in_finalizado = 1 WHERE id_leilao = :id_leilao";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":id_leilao", $id_leilao);
            $consulta->bindParam(":id_ganhador", $id_usuario);
            $consulta->bindParam(":valor_atual", $dadosLeilao->valor_arremate);

            if(!$consulta->execute()){
                $msgErro = 'Erro ao gravar arremate.';
                $erro = true;            
            }

            $array = array(
                'erro'=>$erro,
                'msg'=>$msgErro,
            );
        }
        echo (json_encode($array));
    }

?>