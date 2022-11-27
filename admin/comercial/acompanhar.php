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
                <input type="hidden" id="id_leiloeiro" value="<?=$dadosHora->id_usuario?>">
            </div>
            <div class="col-7">
                <label for="horario_leilao">Horario do Leilão:</label>
                <span name="horario_leilao"><?=date('d/m/Y H:i', strtotime($dadosHora->dt_inicio))?> até <?=date('d/m/Y H:i', strtotime($dadosHora->dt_fim))?></span>
                <br>
                <label for="valor_inicial">Valor inicial:</label>
                <span name="valor_inicial"><?=$dadosHora->valor_inicial?>  -- </span>
                <label for="step">Incremento minimo:</label>
                <span name="step" id="step_leilao"><?=$dadosHora->step?></span>
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
                                        <span>Leiloado por: <?=$dados->nome?></span>
                                    </div>
                                    <div class="col-6">
                                        <h5><?=$dados->item_nome?></h5>
                                        <textarea name="" id="" cols="30" rows="9" value="" disabled=""><?=$dados->item_descricao?></textarea>
                                        <br>
                                        <h6 id="vl_atual_label">Valor atual: <?=$dados->valor_atual?></h6>
                                        <span id="nm_maior_lance"></span> 
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-4">
                                <h5 class="card-title" style="margin-left:5px;">Mensagens</h5>
                                <div id="div_mensagens" class="card_mensagens" style="height: 260px; overflow-y: scroll">
                                    <?=$textArea?>
                                </div>
                                <br>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-7" style="padding: 0 0 0 1em">
                                <div class="input-group mb-3" style="width: 100%; margin: 0">
                                    <input type="text" class="form-control" placeholder="Digite sua mensagem.." aria-label="Recipient's username" aria-describedby="button-addon2" name="mensagem" id="mensagem">
                                    <a href="javascript:enviarMensagem(<?=$dados->id_leilao?>,<?=$_SESSION['usuario']['id']?>)" class="btn btn-outline-secondary" ><i class="bi bi-send"></i></a>
                                </div>
                            </div>
                            <div class="col-1" style="padding:0"></div>
                            <div class="col-4" style="padding: 0 2em 0 0">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" step="<?=$dados->step?>" placeholder="Digite seu lance" id="vl_lance">
                                    <a href="javascript:enviarLance(<?=$_SESSION['usuario']['id']?>)" class="btn btn-outline-secondary" ><i class="bi bi-hammer"></i></a>
                                </div>
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
    let id_leiloeiro = $("#id_leiloeiro").val();
    myInterval = setInterval(gerenciar, 1000);

    function gerenciar (){
        getMensagens(id_leilao);
        getMaxLance();
    }

    function getMensagens(idLeilao){
        $.post('operacao/buscarMensagem.php', 
            {   id_leilao: idLeilao },
            function(response){ 
                var mensagens = response;
                $('#div_mensagens').html(response);
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
            $("#mensagem").val('');
        });
    }

    function enviarLance(id_usuario){
        if(validarLance(id_usuario)){
            $.post('operacao/salvarLance.php',
                {
                    id_leilao: id_leilao,
                    id_usuario: id_usuario,
                    vl_lance: $("#vl_lance").val()
                },
                'json'
            ).done(function(response){
                var objLance = JSON.parse(response);
                console.log(response);
                if(objLance.erro){
                    alert(objLance.msg);
                }
            });
        }
    }

    function validarLance(id_usuario){
        var vlLance = $("#vl_lance").val();
        var step = $("#step_leilao").text();
        var lanceAtual = parseInt($("#vl_atual_label").text().substring(13), 10);
        var result = true;
        if(vlLance == ''){
            alert('Digite um valor valido.');
            result = false;
        }
        else if(id_usuario == id_leiloeiro){
            alert('Leiloeiro não pode dar lance no proprio leilão.');
            result = false;
        }else if(vlLance <= lanceAtual){
            alert('Lance ofertado menor ou igual ao maior lance anterior.');
            result = false;
        }else if((vlLance % step) != 0){
            alert('Lance ofertado não respeitou o step de lance.');
            result = false; 
        }
        return result;
    }

    function getMaxLance(){
        $.post('operacao/buscarMaxLance.php', 
            {   id_leilao: id_leilao   },
            function(response){ 
                var objLance = JSON.parse(response);
                $("#vl_atual_label").html('Valor atual: '+objLance.vl_lance);
                $("#nm_maior_lance").html('Maior lance por:'+objLance.nm_usuario);
            });
    }

/*
function teste2(idLeilao, idUsuario){
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
*/
</script>
