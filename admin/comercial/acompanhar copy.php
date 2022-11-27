<?php
    if ( !isset ( $page ) ) exit;
    $dataAtual = date("Y-m-d H:i:s");
    
    if ( !empty($id) ){
        $sqlHora = "SELECT * FROM leilao WHERE id_leilao = :id;";
        $consulta = $pdo->prepare($sqlHora);
        $consulta->bindParam(":id", $id);    
        if(!$consulta->execute()){
            echo "<script>mensagemErroHistoryBack('Falha ao carregar o leilão. Entre em contato com o suporte.')</script>"; 
        }
        $dadosHora = $consulta->fetch(PDO::FETCH_OBJ);

    }

    
?>
<div class="row">
    <div class="col-2"></div>
    <div class="card col-8" style="margin-top: 2em;">
        <div class="card-header row">
            <div class="col-2">
                <h2 class="float-left">Leilão</h2>
                <input type="hidden" id="id_leilao" value="<?=$dadosHora->id_leilao?>">
            </div>
            <div class="col-7">
                <label for="horario_leilao">Horario do Leilão:</label>
                <span name="horario_leilao"><?=date('d/m/Y H:i', strtotime($dadosHora->dt_inicio))?> até <?=date('d/m/Y H:i', strtotime($dadosHora->dt_fim))?></span>
                <br>
                <label for="valor_inicial">Valor inicial:</label>
                <span name="valor_inicial"><?=$dadosHora->valor_inicial?>  -- </span>
                <label for="step">Incremento minimo:</label>
                <span name="step"><?=$dadosHora->step?></span>
            </div>
            <div class="col-2">
                <?php
                    if($dadosHora->is_arremate == true){
                    ?>
                    <strong>Arrematar por: R$ <?=$dadosHora->valor_arremate?> </strong>
                    <?php
                    }
                ?>
            </div>
            <div class="col-1">
                <?php
                    if($dadosHora->is_arremate == true){
                    ?>
                    <a href="#" class="btn btn-success" ><i class="bi bi-hammer"></i></a>
                    <?php
                    }
                ?>
            </div>
        </div>
        <div class="card-body">
            <?php
                //selecionando todas os leilões 
                $sqlPadrao = " SELECT l.*, img.caminho AS caminho_img, u.nome, it.nome AS item_nome, it.descricao AS item_descricao
                FROM leilao l 
                JOIN leilao_itens li ON l.id_leilao = li.id_leilao 
                JOIN item it ON li.id_item = it.id_item
                JOIN imagem img ON li.id_item = img.id_item 
                JOIN usuario u ON l.id_usuario = u.id_usuario
                WHERE l.id_leilao = :id_leilao";
                $consulta = $pdo->prepare($sqlPadrao);
                $consulta->bindParam(":id_leilao", $id);    
                if(!$consulta->execute()){
                    echo "<script>mensagemErroHistoryBack('Falha ao carregar os leilões. Entre em contato com o suporte.')</script>"; 
                }
                
                while ($dados = $consulta->fetch(PDO::FETCH_OBJ)){
                    $sqlMsg = "SELECT m.*, u.nome FROM mensagem  m JOIN usuario u ON m.id_remetente = u.id_usuario WHERE m.id_leilao = :id_leilao ORDER BY m.dt_mensagem ASC;";
                    $consultaMsg = $pdo->prepare($sqlMsg);
                    $consultaMsg->bindParam('id_leilao', $dados->id_leilao);
                    if(!$consultaMsg->execute()){
                        echo "<script>alert('Falha ao carregar as mensagens do leilão. Entre em contato com o suporte.')</script>"; 
                    }
                    $textArea = '';
                    while ($msgs = $consultaMsg->fetch(PDO::FETCH_OBJ)){
                        $msgs->id_remetente == $_SESSION['usuario']['id'] ? $nome = 'Você' : $nome = $msgs->nome;
                        $textArea = ($textArea.''.$nome.': '.$msgs->mensagem.' <br> ');
                    }
                    ?>
                    <div class="card" style="margin-top: 1em;">
                        <div class="row" style="width: 100%;">
                            <div class="col-8">
                                <div class="row" style="height: 300px">
                                    <div class="col-6">
                                        <img src="../imagens/<?=$dados->caminho_img?>" class="card-img-left" alt="imagem do item" width="100%" >
                                    </div>
                                    <div class="col-6">
                                        <h5><?=$dados->item_nome?></h5>
                                        <textarea name="" id="" cols="30" rows="9" value="" disabled=""><?=$dados->item_descricao?></textarea>
                                        <br>
                                        <h6>Valor atual: <?=$dados->valor_atual?></h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" style="padding: 0 0 0 2em;">
                                        <label for="mensagem">Digite sua mensagem:</label>
                                        <input type="text" name="mensagem" id="mensagem" class="form-control" width="80%">
                                        <a href="javascript:teste(<?=$dados->id_leilao?>,<?=$_SESSION['usuario']['id']?>)" class="btn btn-secondary" >enviar</a>
                                        <?=$dataAtual?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4" id="div_mensagens">
                                <h5 class="card-title" style="margin-left:5px;">Mensagens</h5>
                                <?=$textArea?>
                                <!-- <textarea name="" id="campo_mensagens" cols="30" rows="18" value="" disabled=""></textarea> -->
                                <br>
                            </div>
                        </div>
                    </div>
                    <?php

                }
                ?>
        </div>
    </div>
</div>
<script>
    let id_leilao = $("#id_leilao").val();
    console.log(id_leilao);
    //setInterval(getMensagens(id_leilao), 1000);
    myInterval = setInterval(teste, 1000);

    function teste (){
        console.log('teste');
    }

    function getMensagens(idLeilao){
        $.post('operacao/buscarMensagem.php', 
            {   id_leilao: idLeilao },
            function(response){ 
                console.log('getMensagens');
                var mensagens = response;
                console.log(response);
                //$('#div_mensagens').text(mensagens.substr(2,(mensagens.length)-1));
                $('#div_mensagens').html(response);
            });
    }

    function teste(idLeilao, idUsuario){
        $.post('comercial/salvarMensagem', 
            {
                id_leilao: idLeilao,
                id_remetente: idUsuario,
                str_mensagem: $("#mensagem").val()
            },
            function(response){ 
                console.log('gravou eu acho');
                //getMensagens(idLeilao);
            });
    }
    function enviarMensagem(idLeilao, idUsuario) {
        $.post('comercial/salvarMensagem',
            {
                id_leilao: idLeilao,
                id_remetente: idUsuario,
                str_mensagem: $("#mensagem").val()
            },
            'json'
        ).done(function(e){
            console.log(e);
            console.log('aqui');
        });
    }






</script>
