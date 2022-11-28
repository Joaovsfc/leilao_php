<?php
    if ( !isset ( $page ) ) exit;

    if($id){
     /*
        $sqlLeilao = "SELECT l.* , u.nome AS nome_leiloeiro
        FROM leilao l 
        JOIN usuario u
            ON l.id_usuario = u.id_usuario
        WHERE l.id_leilao = :id_leilao";
        $consultaLeilao = $pdo->prepare($sqlLeilao);
        $consultaLeilao->bindParam(":id_leilao", $id);    
        $consultaLeilao->execute();
        $dadosLeilao = $consultaLeilao->fetch(PDO::FETCH_OBJ);
     */
    $sqlLeilao = "SELECT u.* 
    FROM usuario u
    WHERE u.id_usuario = :id_usuario";
    $consultaLeilao = $pdo->prepare($sqlLeilao);
    $consultaLeilao->bindParam(":id_usuario", $id);    
    $consultaLeilao->execute();
    $dadosLeilao = $consultaLeilao->fetch(PDO::FETCH_OBJ);
    }
?>

<div class="row">
    <div class="col-3"></div>
    <div class="card col-6" style="margin-top: 2em;">
        <div class="card-header">
            <h2 class="float-left">Chat com: <?=$dadosLeilao->nome?></h2>
            <input type="hidden" value="<?=$dadosLeilao->id_usuario?>" id="id_leiloeiro">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 ">
                <div id="div_mensagens" class="card_mensagens" style="height: 260px; overflow-y: scroll">               
                </div>
                <br>
                    <div class="input-group mb-3" style="width: 100%; margin: 0">
                        <input type="text" class="form-control" placeholder="Digite sua mensagem.." aria-label="Recipient's username" aria-describedby="button-addon2" name="mensagem" id="mensagem">
                        <a href="javascript:enviarMensagem()" class="btn btn-outline-secondary" ><i class="bi bi-send"></i></a>
                    </div>
                    <input type="hidden" id="id_usuario" value="<?=$_SESSION['usuario']['id']?>">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var id_leiloeiro = $("#id_leiloeiro").val();
    var id_usuario = $("#id_usuario").val();

    myInterval = setInterval(gerenciar, 1000);

    function gerenciar (){
        getMensagens();
    }

    function enviarMensagem() {
        $.post('operacao/salvarDialogo.php',
            {
                id_destinatario: id_leiloeiro,
                id_remetente: id_usuario,
                str_mensagem: $("#mensagem").val()
            },
            'json'
        ).done(function(e){
            $("#mensagem").val('');
        });
        console.log('enviou');
    }

    function getMensagens(){
        $.post('operacao/buscarDialogo.php', 
            {   
                id_destinatario: id_leiloeiro,
                id_remetente: id_usuario,
            },
            function(response){ 
                var mensagens = response;

                $('#div_mensagens').html(response);
            });
    }
</script>