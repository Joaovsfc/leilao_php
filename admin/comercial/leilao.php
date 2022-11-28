<?php
    if ( !isset ( $page ) ) exit;
    $dataAtual = date("Y-m-d H:i:s");
?>
<div class="row">
    <div class="col-2"></div>
    <div class="card col-8" style="margin-top: 2em;">
        <div class="card-header">
            <h2 class="float-left">Leilões disponiveis</h2>
        </div>
        <div class="card-body">
            <?php
                //selecionando todas os leilões 
                $sqlPadrao = " SELECT l.*, img.caminho AS caminho_img, u.nome
                FROM leilao l 
                JOIN leilao_itens li ON l.id_leilao = li.id_leilao 
                JOIN imagem img ON li.id_item = img.id_item 
                JOIN usuario u ON l.id_usuario = u.id_usuario
                WHERE l.dt_inicio <= :dt_atual AND l.dt_fim > :dt_atual AND l.in_finalizado = 0
                ORDER BY l.id_leilao ASC";
                $consulta = $pdo->prepare($sqlPadrao);
                $consulta->bindParam(":dt_atual", $dataAtual);    
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
                       $textArea = ($textArea.''.$msgs->nome.': '.$msgs->mensagem.'&#10;');
                    }
                    ?>
                    <div class="card" style="margin-top: 1em;">
                        <div class="row" style="width: 100%;">
                            <div class="col-4">
                                <img src="../imagens/<?=$dados->caminho_img?>" class="card-img-left" alt="imagem do item" width="100%" >
                            </div>
                            <div class="col-4" style="padding: 1em 0 1em 1em">
                                <h5 class="card-title"><?=$dados->id_leilao?>-<?=$dados->titulo?></h5>
                                <label for="valor_inicial">Valor inicial:</label>
                                <span name="valor_inicial"><?=$dados->valor_inicial?></span>
                                <br>
                                <label for="valor_atual">Valor atual: </label>
                                <span name="valor_inicial"><?=$dados->valor_atual?></span>
                                <br>
                                <label for="step">Incremento minimo:</label>
                                <span name="step"><?=$dados->step?></span>
                                <br>
                                <label for="data_inicial">Periodo do leilão</label>
                                <br>
                                <span name="data_inicio"><?=date('d/m/Y H:i', strtotime($dados->dt_inicio))?> até <?=date('d/m/Y H:i', strtotime($dados->dt_fim))?></span>
                                <br>
                                <label for="leiloeiro">Leiloeiro:</label>
                                <span><?=$dados->nome?></span>
                                <br>
                                <?php
                                if($dados->is_arremate == true){
                                    ?>
                                    <span name="arremate">Valor do arremate: &#10003; <?=$dados->valor_arremate?> </span>
                                    <br>
                                    <?php
                                }else{
                                    ?>
                                    <span> </span>
                                    <br>
                                    <?php
                                }
                                ?>
                                <br>
                                <a href="comercial/acompanhar/<?=$dados->id_leilao?>" class="btn btn-primary" >Acompanhar leilao</a>
                            </div>
                            <div class="col-4">
                                <h5 class="card-title">Mensagens</h5>
                                <textarea name="" id="" cols="30" rows="10" value="" disabled=""><?=$textArea?></textarea>
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
    $.get( "operacao/finalizarLeiloes.php" );
</script>